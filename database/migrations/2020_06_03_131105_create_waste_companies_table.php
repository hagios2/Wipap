<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->string('location');
            $table->string('status')->default('Pending');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('logo')->nullable();
            $table->timestamp('last_login');
            $table->text('policy');
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
