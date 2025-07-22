<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('indonesia_villages', function (Blueprint $table) {
        $table->unsignedBigInteger('city_id')->after('district_code')->nullable();
        $table->foreign('city_id')->references('id')->on('indonesia_cities')->onDelete('cascade');
    });
}

public function down()
{
    Schema::table('indonesia_villages', function (Blueprint $table) {
        $table->dropForeign(['city_id']);
        $table->dropColumn('city_id');
    });
}
};
