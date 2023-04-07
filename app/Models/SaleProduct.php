<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleProduct extends Model
{
    use HasFactory;
    protected $table = 'sale_products';
    protected $primaryKey = 'sales_product_id';

    public function product()
    {
        return $this->hasOne(Product::class, 'product_id', 'product_id');
    }
}
