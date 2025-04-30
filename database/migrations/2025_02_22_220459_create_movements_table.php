<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products');
            $table->foreignId('purchase_id')->nullable()->constrained('purchases')->onDelete('cascade');
            $table->foreignId('sale_id')->nullable()->constrained('sales')->onDelete('cascade');         
            $table->integer('quantity')->nullable();
            $table->decimal('unit_price',10,2)->nullable();
            $table->decimal('subtotal_movements',10,2)->nullable();       
            $table->decimal('iva',10,2)->nullable();
            $table->decimal('totalprice',10,2)->nullable();
            $table->string('transfer_type')->nullable();
            $table->string('document_type')->nullable();
            $table->string('document_number')->nullable();
            $table->timestamp('movement_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movements');
    }
};
