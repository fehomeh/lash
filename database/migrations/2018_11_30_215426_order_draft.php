<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OrderDraft extends Migration
{
    /**
     * Create tables for order draft.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create(
            'order_draft',
            function (Blueprint $table) {
                $table->uuid('uuid');
                $table->string('country_code', 3);
                $table->primary('uuid');
            }
        );
        Schema::create('order_draft__product', function (Blueprint $table) {
            $table->uuid('order_uuid');
            $table->uuid('product_uuid');
            $table->integer('quantity', false, true);
            $table->primary(['order_uuid', 'product_uuid']);
        });
    }

    /**
     * Delete tables for order draft.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::drop('order_draft');
        Schema::drop('order_draft__product');
    }
}
