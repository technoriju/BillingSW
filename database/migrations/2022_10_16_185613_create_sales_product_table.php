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
        Schema::create('sales_product', function (Blueprint $table) {
            $table->id('sales_product_id');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('product_id')->on('products');
            $table->integer('qty');
            $table->integer('mrp_price')->default(0);
            $table->integer('sales_price');
            $table->bigInteger('total_price')->default(0);
            $table->unsignedBigInteger('sales_report_id');
            $table->foreign('sales_report_id')->references('sales_report_id')->on('sales_report');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales_product');
    }
};
