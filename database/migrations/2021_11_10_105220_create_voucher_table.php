<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVoucherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->string('type')->nullable();
            $table->string('code')->nullable();
            $table->decimal('order_amount', 13, 2)->nullable();
            $table->decimal('discount_amount', 13, 2)->nullable();
            $table->date('starts_at')->nullable();
            $table->date('expires_at')->nullable();
            $table->time('from_time')->nullable();
            $table->time('to_time')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('vouchers');
    }
}
