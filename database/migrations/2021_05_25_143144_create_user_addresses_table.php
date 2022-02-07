<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('country_id')->nullable();
            $table->string('name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('address_line1')->nullable();
            $table->string('address_line2')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('zipcode')->nullable();
            $table->tinyInteger('address_type')->default('1')->comment('1 = Home, 2 = Office');
            $table->tinyInteger('delivery_type')->default('1')->comment('1 = Shipping, 2 = Billing');
            $table->timestamps();
            $table->foreign('user_id')->on('users')->references('id')->onDelete('cascade');
            $table->foreign('country_id')->on('countries')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_addresses');
    }
}
