<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchases extends Model
{            
    use HasFactory;

    protected $fillable = [
        'product_id',
        'transfer_type',
        'document_type',
        'document_number',
        'quantity',
        'purchase_price',
        'subtotal',
        'iva',
        'total_price',
        'entry_date',
        'suppliers_id',
    ];

    public function product(){

        return $this->belongsTo(Product::class);
    }
    
    public function supplier(){

        return $this->belongsTo(Suppliers::class);
    }

    
}
