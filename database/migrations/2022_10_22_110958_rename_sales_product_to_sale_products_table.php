<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sales_product', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropForeign(['sales_report_id']);
         });

         Schema::rename('sales_product', 'sale_products');

         Schema::table('sale_products', function (Blueprint $table) {
            $table->foreign('product_id')->references('product_id')->on('products');
            $table->foreign('sales_report_id')->references('sales_report_id')->on('sale_reports');
         });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sale_products', function (Blueprint $table) {
            //
        });
    }
};
