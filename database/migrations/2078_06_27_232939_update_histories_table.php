<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('histories', function (Blueprint $table) {
            // Drop existing columns
            $table->dropColumn(['item_id', 'user_id', 'quantity', 'type', 'description']);

            // Add new columns
            $table->string('history_code')->unique();
            $table->string('adjustment_code')->nullable();
            $table->string('order_code')->nullable();
            $table->enum('status', ['order', 'penyesuaian'])->index();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('histories', function (Blueprint $table) {
            // Drop new columns
            $table->dropColumn(['history_code', 'adjustment_code', 'order_code', 'status']);

            // Add old columns back
            $table->bigInteger('item_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->integer('quantity');
            $table->enum('type', ['in', 'out']);
            $table->text('description')->nullable();
            $table->timestamps(); // Add back the timestamps
        });
    }
}
