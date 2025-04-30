<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movements extends Model
{
    use HasFactory;

    protected $fillable=[
        'product_id',
        'purchase_id',
        'sale_id',
        'quantity',
        'unit_price',
        'subtotal_movements',
        'iva',
        'totalprice',
        'transfer_type',
        'document_type',
        'document_number',
        'movement_date',
       ];


       public function product(){

        return $this->belongsTo(Product::class);
    }
}
