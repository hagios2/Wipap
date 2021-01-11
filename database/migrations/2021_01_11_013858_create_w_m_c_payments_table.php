<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWMCPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('w_m_c_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('waste_company_id')->unsigned();
            $table->integer('billing_detail_id')->nullable();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('email');
            $table->string('phonenumber');
            $table->string('vendor')->nullable();
            $table->string('momo_payment')->default(false);
            $table->string('txRef')->unique();
            $table->string('device_ip');
            $table->decimal('amount', 10, 2);
            $table->string('status')->default('pending');
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
        Schema::dropIfExists('w_m_c_payments');
    }
}
