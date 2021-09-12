<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWasteCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('waste_companies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('company_name');
            $table->string('company_email')->unique();
            $table->string('company_phone')->unique()->nullable();
            $table->string('company_address');
            $table->string('status')->default('pending');
            $table->boolean('published')->default(false);
            $table->string('logo')->nullable();
            $table->string('digital_address')->nullable();
            $table->string('lat');
            $table->string('long');
            $table->string('business_cert')->nullable();
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
        Schema::dropIfExists('waste_companies');
    }
}
