<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateStocksTableAndCreateStockItemsTable extends Migration
{
    public function up()
    {
        Schema::table('stocks', function (Blueprint $table) {
            $table->string('adjustment_code')->unique();
            $table->string('title');
            $table->text('note')->nullable();
            $table->string('status');
        });

        Schema::create('stock_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stock_id')->constrained()->onDelete('cascade');
            $table->foreignId('item_id')->constrained();
            $table->integer('quantity');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::table('stocks', function (Blueprint $table) {
            $table->dropColumn(['adjustment_code', 'title', 'note', 'status']);
        });

        Schema::dropIfExists('stock_items');
    }
}
