<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDefaultStatusToStocksTable extends Migration
{
    public function up()
    {
        Schema::table('stocks', function (Blueprint $table) {
            $table->string('status')->default('pending')->change();
        });
    }

    public function down()
    {
        Schema::table('stocks', function (Blueprint $table) {
            // You should define how to revert the migration here.
            // For example, you might want to remove the default or change it back to what it was.
        });
    }
}
