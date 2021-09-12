<?php

namespace App\Services;

use App\Company;
use App\WasteCompany;

class UploadServices
{
    public function uploadCompanyFiles(WasteCompany $company, $fileType)
    {

        if(request()->hasFile($fileType))
        {
            $file = request()->file($fileType);

            $fileName = $file->getClientOriginalName();

            // $relative_path = "$fileType/{$company->id}/";

            //$path =  "/var/www/html/uploads/".$relative_path;
            $path = public_path("uploads/$fileType/");

            $file->move($path, $fileName);

            $company->update([

                $fileType => $path.$fileName
            ]);
        }

    }

    public function uploadCompanyLogo(Company $company)
    {
        if(request()->hasFile('logo'))
        {
            $file = request()->file('logo');

            $fileName = $file->getClientOriginalName();

            $relative_path = "logos/{$company->id}/";

            $path =  "/var/www/html/uploads/".$relative_path;

            $file->move($path, $fileName);

            if(request()->method() == 'PATCH')
            {
                $company->avatar->update(['logo'=> $relative_path.$fileName]);
            }else{

                $avatar = [

//                'file_size' => $file->getSize(),
//
                    'logo' => $relative_path.$fileName
                ];

                $company->StoreAvatar($avatar);
            }
        }

    }

}
