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
        Schema::table('sales_report', function (Blueprint $table) {
            $table->dropForeign(['customer_id']);
         });

         Schema::rename('sales_report', 'sale_reports');

         Schema::table('sale_reports', function (Blueprint $table) {
            $table->foreign('customer_id')->references('customer_id')->on('customers');
         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
