<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->string('name', 45);
            $table->decimal('price', 12, 2);
            $table->string('description');

            $table->string('tags', 15)->nullable();
            $table->string('status_product', 20)->nullable();

            // $table->bigInteger('categories_id');
            $table->unsignedBigInteger('categories_id');

            $table->softDeletes();
            $table->timestamps();


            $table->foreign('categories_id')
                ->references('id')
                ->on('product_categories')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            // $table->foreign('categories_id')
            // ->references('id')
            // ->on('product_categories')
            // ->onDelete('restrict')
            // ->onUpdate('restrict');
            // $table->foreign('categories_id')->references('id')->on('product_categories')->onDelete('restrict')->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
