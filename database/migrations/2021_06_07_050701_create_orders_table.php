<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('shipping_address_id')->nullable();
            $table->string('order_no')->nullable();
            $table->decimal('sub_total')->nullable();
            $table->decimal('total')->nullable();
            $table->decimal('commission_total', 13, 2)->nullable();
            $table->string('payment_method')->nullable();
            $table->string('payment_method_title')->nullable();
            $table->string('payment_status')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                ->on('users')
                ->references('id')
                ->onDelete('cascade');

            $table->foreign('shipping_address_id')
                ->on('user_addresses')
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
        Schema::dropIfExists('orders');
    }
}
