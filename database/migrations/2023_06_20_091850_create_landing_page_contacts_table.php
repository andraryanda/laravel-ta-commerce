<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLandingPageContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('landing_page_contacts', function (Blueprint $table) {
            $table->id();

            $table->string('title_contact', 40);
            $table->longText('description_contact');
            $table->longText('address_contact');
            $table->string('phone_contact', 15);
            $table->string('email_contact', 40);

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
        Schema::dropIfExists('landing_page_contacts');
    }
}
