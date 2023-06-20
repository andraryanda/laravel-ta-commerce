<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->bigInteger('incre_id');

            $table->unsignedbigInteger('users_id');

            $table->text('address')->nullable();
            $table->decimal('total_price', 12, 2);
            $table->float('shipping_price')->default(0);
            $table->string('status')->default('PENDING');
            $table->string('payment')->default('MANUAL');

            $table->softDeletes();
            $table->timestamps();

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
        Schema::dropIfExists('transactions');
    }
}
