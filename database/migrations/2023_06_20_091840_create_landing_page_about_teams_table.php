<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLandingPageAboutTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('landing_page_about_teams', function (Blueprint $table) {
            $table->id();

            $table->string('name_people_team', 50);
            $table->string('job_people_team', 50);
            $table->longText('description_people_team');
            $table->string('image_people_team');

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
        Schema::dropIfExists('landing_page_about_teams');
    }
}
