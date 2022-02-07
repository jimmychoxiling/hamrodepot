<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_products', function (Blueprint $table) {
            $table->unsignedBigInteger('products_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
//            $table->unsignedBigInteger('subcategory_id')->nullable();

            $table->foreign('category_id')
                ->on('categories')
                ->references('id')
                ->onDelete('cascade');

//            $table->foreign('subcategory_id')
//                ->on('categories')
//                ->references('id')
//                ->onDelete('cascade');

            $table->foreign('products_id')
                ->on('products')
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
        Schema::dropIfExists('category_products');
    }
}
