<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderStatusHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_status_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_detail_id');
            $table->unsignedBigInteger('status_id');
            $table->timestamps();

            $table->foreign('order_detail_id')
                ->on('order_details')
                ->references('id')
                ->onDelete('cascade');

            $table->foreign('status_id')
                ->on('order_statuses')
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
        Schema::dropIfExists('order_status_histories');
    }
}
