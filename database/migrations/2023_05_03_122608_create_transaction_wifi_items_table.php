<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionWifiItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_wifi_item', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->bigInteger('incre_id');
            $table->bigInteger('users_id');
            $table->bigInteger('products_id');
            $table->bigInteger('transaction_wifi_id');
            $table->string('payment_status');
            $table->decimal('payment_transaction', 12, 2);
            $table->longText('description');
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
        Schema::dropIfExists('transaction_wifi_item');
    }
}
