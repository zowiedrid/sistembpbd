<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('brand_id')->constrained()->onDelete('cascade');
            $table->text('description')->nullable();
            $table->integer('quantity');
            $table->string('unit');
            $table->decimal('price', 10, 2); // New field for price
            $table->boolean('is_visible')->default(true); // New field for is_visible
            $table->string('sku')->unique(); // New field for SKU
            $table->string('barcode')->unique(); // New field for barcode
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('items');
    }
}
