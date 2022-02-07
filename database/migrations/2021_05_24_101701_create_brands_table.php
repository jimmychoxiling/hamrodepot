<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('seller_id')->nullable();
            $table->string('name');
            $table->string('image')->nullable();
            $table->string('slug')->nullable();
            $table->tinyInteger('status')->default('0')->comment('0 = Pending, 1 = Active - Approve, 2 = In Active, 3 = Reject');
            $table->timestamps();

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
        Schema::dropIfExists('brands');
    }
}
