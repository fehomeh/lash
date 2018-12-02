<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTable extends Migration
{
    /**
     * Create table for storing product.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'product',
            function (Blueprint $table) {
                $table->uuid('uuid');
                $table->string('product_type', 255);
                $table->float('price', 10, 2);
                $table->string('color', 30);
                $table->string('size', 5);
                $table->unique(['product_type', 'color', 'size'], 'unique__product_type__color__size');
                $table->primary('uuid');
            }
        );
    }

    /**
     * Remove table for storing product.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product');
    }
}
