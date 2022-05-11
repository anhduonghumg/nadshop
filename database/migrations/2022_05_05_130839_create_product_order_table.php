<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_order', function (Blueprint $table) {
            $table->id();
            $table->string('order_code', 20);
            $table->string('fullname', 255);
            $table->string('phone', 20);
            $table->string('address', 100);
            $table->string('city', 100);
            $table->string('district', 100);
            $table->double('order_total');
            $table->enum('order_status', ['pending', 'shipping', 'success', 'cancel']);
            $table->enum('payment', ['cod', 'card']);
            $table->text('node');
            $table->unsignedBigInteger('user_id');
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
        Schema::dropIfExists('product_order');
    }
}
