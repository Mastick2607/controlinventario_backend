<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sales extends Model
{
    use HasFactory;


    protected $fillable=[
        'product_id',
        'quantity',
        'sale_price',
        'subtotal',
        'iva',
        'total_price',
        'sale_date',
        'customer_id' ,
        'transfer_type',
        'document_type',
        'document_number',
       ];


// Rellacion con el modelo

public function product(){

    return $this->belongsTo(Product::class);
}


public function customer(){

    return $this->belongsTo(Customer::class);
}

    }
