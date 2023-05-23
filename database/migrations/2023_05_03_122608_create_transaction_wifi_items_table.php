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
        Schema::create('transaction_wifi_items', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->unsignedbigInteger('incre_id');
            $table->unsignedbigInteger('users_id');
            $table->unsignedbigInteger('products_id');
            $table->uuid('transaction_wifi_id');

            $table->string('payment_status')->default('UNPAID');
            $table->decimal('payment_transaction', 12, 2);
            $table->string('payment_method')->default('MANUAL');
            $table->string('payment_bank')->nullable();
            $table->longText('description')->nullable();

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('transaction_wifi_id')
            ->references('id')
            ->on('transaction_wifis')
            ->onDelete('restrict')
            ->onUpdate('restrict');

            $table->foreign('products_id')
            ->references('id')
            ->on('products')
            ->onDelete('restrict')
            ->onUpdate('restrict');

            $table->foreign('users_id')
            ->references('id')
            ->on('users')
            ->onDelete('restrict')
            ->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction_wifi_items');
    }
}
