<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_items', function (Blueprint $table) {
            // $table->id();
            // $table->string('id', 32)->primary();
            $table->uuid('id')->primary();
            $table->bigInteger('incre_id');


            $table->bigInteger('users_id');
            $table->bigInteger('products_id');
            $table->uuid('transactions_id');
            // $table->string('transactions_id', 32);
            // $table->bigInteger('transactions_id');
            $table->bigInteger('quantity');

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
        Schema::dropIfExists('transaction_items');
    }
}
