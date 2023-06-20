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

            $table->uuid('id')->primary();
            $table->bigInteger('incre_id');
            $table->unsignedbigInteger('users_id');
            $table->unsignedbigInteger('products_id');
            $table->uuid('transactions_id');

            $table->bigInteger('quantity');

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('transactions_id')
            ->references('id')
            ->on('transactions')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreign('products_id')
            ->references('id')
            ->on('products')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreign('users_id')
            ->references('id')
            ->on('users')
            ->onDelete('cascade')
            ->onUpdate('cascade');
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
