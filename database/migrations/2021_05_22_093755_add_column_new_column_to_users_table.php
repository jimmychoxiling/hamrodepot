<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnNewColumnToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('last_name')->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->string('gender')->nullable();
            $table->string('business_name')->nullable();
            $table->string('address_line1')->nullable();
            $table->string('address_line2')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('phone_number_type')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('product_plan_to_list')->nullable();
            $table->string('shipping_method')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('slug')->nullable();
            $table->tinyInteger('status')->nullable()->default('0')->comment('0 = Pending, 1 = Active - Approve, 2 = In Active, 3 = Reject');
            $table->tinyInteger('i_agree')->nullable()->default('1');


            $table->foreign('country_id')
                ->on('countries')
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
        Schema::table('users', function (Blueprint $table) {

            $table->dropForeign(['country_id']);
            $table->dropColumn('country_id');
            $table->dropColumn('last_name');
            $table->dropColumn('gender');
            $table->dropColumn('business_name');
            $table->dropColumn('address_line1');
            $table->dropColumn('address_line2');
            $table->dropColumn('state');
            $table->dropColumn('city');
            $table->dropColumn('zipcode');
            $table->dropColumn('phone_number_type');
            $table->dropColumn('phone_number');
            $table->dropColumn('product_plan_to_list');
            $table->dropColumn('shipping_method');
            $table->dropColumn('birth_date');
            $table->dropColumn('slug');
            $table->dropColumn('status');
            $table->dropColumn('i_agree');
        });
    }
}
