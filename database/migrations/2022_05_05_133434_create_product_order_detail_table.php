<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductOrderDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_order_detail', function (Blueprint $table) {
            $table->id();
            $table->integer('pro_order_qty');
            $table->double('pro_order_total');
            $table->unsignedBigInteger('product_detail_id');
            $table->unsignedBigInteger('product_order_id');
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
        Schema::dropIfExists('product_order_detail');
    }
}
