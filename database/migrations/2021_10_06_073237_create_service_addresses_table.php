<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_addresses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_id');
            $table->decimal('price', 13, 2)->nullable();
            $table->text('address')->nullable();
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->integer('zipcode')->nullable();
            $table->decimal('lat', 10, 8)->nullable();
            $table->decimal('lng', 10, 8)->nullable();
            $table->timestamps();

            $table->foreign('service_id')
                ->references('id')
                ->on('services')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_addresses');
    }
}
