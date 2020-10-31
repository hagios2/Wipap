<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\UsersProductResource;
use App\Category;
use App\Product;

class SellersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api,merchandiser');
    }


    public function createCategory(Request $request)
    {
        Category::create($request->validate(['category' => 'required|string|unique:categories,category']));

        return response()->json(['status' => 'category created'], 200);
    }


    public function getCategories(Request $request)
    {
       
        return CategoryResource::collection(Category::all());

    }


    public function storeProduct(Category $category, ProductRequest $request)
    {
        
        $product = $request->validated();

        if(auth()->guard('merchandiser')->user())
        {

            $product['merchandiser_id'] = auth()->guard('merchandiser')->id();

        }else{

            $user = auth()->guard('api')->user();

            if(!$user->valid_id)
            {
                return response()->json(['status' => 'Valid ID required'],200);
            }

            $product['user_id'] = auth()->guard('api')->id();

        }


        $product_id = $category->addProduct($product);

        return response()->json(['status' => 'success', 'product_id' => $product_id], 200);
    }


    public function updateProduct(Product $product, ProductRequest $request)
    {
       if(auth()->guard('api')->id() !== $product->user_id && $product->merchandiser_id == null)
       {
            return response()->json(['status' => 'Forbidden'], 403);

       }else if(auth()->guard('merchandiser')->id() !== $product->merchandiser_id && $product->user_id == null){

            return response()->json(['status' => 'Forbidden'], 403);
       }

        $product->update($request->validated());


        return response()->json(['status' => 'success'], 200);
    } 


    public function saveProductImages(Product $product, Request $request)
    {
        /*  if(auth()->guard('api')->id() !== $product->user_id && $product->merchandiser_id == null)
            {
                return response()->json(['status' => 'Forbidden'], 403);
    
            }else if(auth()->guard('merchandiser')->id() !== $product->merchandiser_id && $product->user_id == null){
    
                return response()->json(['status' => 'Forbidden'], 403);    
            }
            */
                
        if($request->hasFile('product_images'))
        {

            $files = $request->file('product_images');

            foreach($files as $file)
            {
    
                $fileName = now().'_'.$file->getClientOriginalName();
        
                $file->storeAs('public/product images/'.$product->id, $fileName);
        
                $product->addProductImage([
                    'path' => storage_path('app/public/product images/'.$product->id.'/'.$fileName)]);
        
            }
    
            return response()->json(['status' => 'files saved'], 200);
        }

        return response()->json(['status' => 'product images is required'], 422);
    }


    public function deleteProduct(Product $product)
    {
        
        if($product->user && auth()->guard('api')->id() !== $product->user_id)
        {
            return response()->json(['message' => 'Forbidden'], 403);

        }elseif($product->merchandiser && auth()->guard('merchandiser')->id() !== $product->merchandiser_id){

            return response()->json(['message' => 'Forbidden'], 403);
        }

        $this->deleteProductReviews($product);

        $this->deleteProductImages($product); 

        $product->delete();
        
        return response()->json(['status' => 'product deleted'], 200);
    }


    public function deleteProductReviews(Product $product)
    {

        if($product->review)
        {
            $product->review->map(function($review){

                $review->delete();
            });
        }
    }

    public function deleteProductImages(Product $product)
    {
        if($product->image)
        {
            $product->image->map(function($image){

                #delete file

                $image->delete();
            });
        }
    }

    public function getUserProduct()
    {
        $user = auth()->guard('api')->user();

        if($user->product)
        {
            return UsersProductResource::collection($user->product);
        }

        return response()->json(['message' => 'user has no data']);
    }
    
}
