<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id')->nullable();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->unsignedBigInteger('seller_id')->nullable();
            $table->string('name')->nullable();
            $table->string('sku')->nullable();
            $table->string('sell_type')->nullable()->comment('Sell, Rent');
            $table->date('from_date')->nullable();
            $table->date('to_date')->nullable();
            $table->time('from_time')->nullable();
            $table->time('to_time')->nullable();
            $table->string('total_hrs')->nullable();
            $table->decimal('price', 13, 2)->nullable();
            $table->integer('quantity')->nullable();
            $table->decimal('sub_total', 13, 2)->nullable();
            $table->decimal('total', 13, 2)->nullable();
            $table->integer('commission')->nullable();
            $table->decimal('commission_total', 13, 2)->nullable();
            $table->timestamps();

            $table->foreign('order_id')
                ->on('orders')
                ->references('id')
                ->onDelete('cascade');

            $table->foreign('product_id')
                ->on('products')
                ->references('id')
                ->onDelete('cascade');

            $table->foreign('seller_id')
                ->on('users')
                ->references('id')
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
        Schema::dropIfExists('order_details');
    }
}
