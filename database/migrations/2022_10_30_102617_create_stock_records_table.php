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
        Schema::create('stock_records', function (Blueprint $table) {
            $table->id('product_id');
            $table->integer('category_id');
            $table->integer('subcategory_id')->default(0);
            $table->integer('seller_id')->default(0);
            $table->string('sku_code',30);
            $table->string('product_name',30);
            $table->integer('qty');
            $table->double('purchase_price');
            $table->double('mrp_price');
            $table->double('sell_price');
            $table->boolean('status')->default(1)->comment('1:Active, 0:Inactive');
            $table->boolean('action')->default(0)->comment('0:Insert, 1:Update, 2:Delete');
            $table->text('remark')->default('');
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
        Schema::dropIfExists('stock_records');
    }
};
