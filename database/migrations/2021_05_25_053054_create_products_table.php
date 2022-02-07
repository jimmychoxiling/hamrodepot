<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('seller_id')->nullable();
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->string('sku')->nullable();
            $table->longText('description')->nullable();

            $table->string('sell_type')->nullable()->comment('Sell, Rent');
            $table->decimal('price', 13, 2)->nullable();
            $table->integer('stock')->default('0');
            $table->unsignedBigInteger('brands_id')->nullable();
            $table->tinyInteger('status')->default('0')->comment('0 = Pending, 1 = Active - Approve, 2 = In Active, 3 = Reject');

            $table->longText('product_overview')->nullable();
            $table->longText('specifications')->nullable();
            $table->longText('easy_returns')->nullable();

            $table->foreign('seller_id')
                ->on('users')
                ->references('id')
                ->onDelete('cascade');

            $table->foreign('brands_id')
                ->on('brands')
                ->references('id')
                ->onDelete('cascade');
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
        Schema::dropIfExists('products');
    }
}
