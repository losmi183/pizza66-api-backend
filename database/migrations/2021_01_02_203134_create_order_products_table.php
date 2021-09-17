<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_products', function (Blueprint $table) {
            $table->id();


            $table->unsignedBigInteger('order_id')->nullable();
            $table->foreign('order_id')->references('id')
                ->on('orders')->onUpdate('cascade')->onDelete('cascade');


            $table->unsignedBigInteger('product_id')->nullable();            
            $table->foreign('product_id')->references('id')
                  ->on('products')->onUpdate('cascade')->onDelete('set null');

            
            $table->unsignedInteger('quantity');
            $table->unsignedInteger('price');
            $table->string('size')->nullable();
            $table->json('addons')->nullable();


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
        Schema::dropIfExists('order_products');
    }
}
