<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('service_id')->nullable();
            
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');

            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->string('state')->nullable();
            $table->date('service_date')->nullable();
            $table->text('description')->nullable();
            $table->string('time')->nullable();
            $table->string('city');
            $table->string('zipcode');

            $table->decimal('budget', 13, 2)->nullable();

            $table->timestamps();

            $table->foreign('user_id')
                ->on('users')
                ->references('id')
                ->onDelete('cascade');

            $table->foreign('service_id')
                ->on('services')
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
        Schema::dropIfExists('service_requests');
    }
}
