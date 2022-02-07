<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('seller_id');
            $table->unsignedBigInteger('service_category_id');
            $table->string('name');
            $table->string('slug')->unique()->nullable();
            $table->string('image')->nullable();
            $table->string('tag')->nullable();
            $table->string('time')->nullable();
            $table->tinyInteger('status')->default('0')->comment('0 = Pending, 1 = Active - Approve, 2 = In Active, 3 = Reject');
            $table->timestamps();

            $table->foreign('seller_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('service_category_id')
                ->references('id')
                ->on('service_categories')
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
        Schema::dropIfExists('services');
    }
}
