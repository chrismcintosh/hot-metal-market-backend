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
        /** Add Orders */
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('stripe_payment_intent_id')->nullable();
            $table->foreignId('user_id')->nullable()->constrained();
            $table->bigInteger('total')->nullable()->unsigned();
            $table->enum('status', ['pi_generated', 'created', 'succeeded', 'failed', 'canceled']);
            $table->timestamps();
        });

        /** Add orders-products */
        Schema::create('order_product', function (Blueprint $table) {
            $table->id('id');
            $table->foreignUuid('order_id')->references('id')->on('orders');
            $table->bigInteger('product_id');
            $table->bigInteger('product_cost')->unsigned();
            $table->bigInteger('quantity')->unsigned();
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
        Schema::drop('orders');
        Schema::drop('order_product');
    }
};
