<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnStatusToVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::table('vouchers', function (Blueprint $table) {
            $table->tinyInteger('status')->default('0')->after('expires_at')->comment('0 = Pending, 1 = Active - Approve, 2 = In Active, 3 = Reject');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vouchers', function (Blueprint $table) {
            $table->tinyInteger('status');
        });
    }
}
