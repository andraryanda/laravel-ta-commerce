<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_transactions', function (Blueprint $table) {
            $table->id();

            $table->uuid('transactions_id');

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('transactions_id')
            ->references('id')
            ->on('transactions')
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
        Schema::dropIfExists('notification_transactions');
    }
}
