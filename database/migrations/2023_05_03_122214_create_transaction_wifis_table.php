<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionWifisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_wifi', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->bigInteger('incre_id');
            $table->bigInteger('users_id');
            $table->bigInteger('products_id');
            $table->decimal('total_price_wifi', 12, 2);
            $table->float('discount');
            $table->string('status');
            $table->date('expired_wifi');
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
        Schema::dropIfExists('transaction_wifi');
    }
}
