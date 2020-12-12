<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePickUpRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pick_up_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('pick_up_date');
            $table->integer('garbage_type_id')->unsigned();
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('organization_id')->unsigned()->nullable();
            $table->string('status')->default('pending');
            $table->boolean('client_confirmation')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pick_up_requests');
    }
}
