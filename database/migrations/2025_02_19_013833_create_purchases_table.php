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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products');
            $table->string('transfer_type')->nullable();
            $table->string('document_type')->nullable();
            $table->string('document_number')->nullable();
            $table->integer('quantity')->nullable();
            $table->decimal('purchase_price',10,2)->nullable();
            $table->decimal('subtotal',10,2)->nullable();
            $table->decimal('iva',10,2)->nullable();
            $table->decimal('total_price',10,2)->nullable();
            $table->timestamp('entry_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
