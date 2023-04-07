<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleReport extends Model
{
    use HasFactory;
    protected $table = 'sale_reports';
    protected $primaryKey = 'sales_report_id';

    public function customer()
    {
        return $this->hasOne(Customer::class, 'customer_id', 'customer_id');
    }

    public function sale_products()
    {
        return $this->hasMany(SaleProduct::class, 'sales_report_id', 'sales_report_id');
    }
}
