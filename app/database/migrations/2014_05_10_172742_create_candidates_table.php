<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCandidatesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('candidates', function(Blueprint $table) {
            $table->char('id', 36); //uuid
            $table->integer('county_id')->unsigned();
            $table->integer('town_id')->unsigned();
            $table->char('cunli_id', 20);
            $table->string('name');
            $table->string('head');
            $table->char('gender', 1); // m or f
            $table->date('dob'); // date of birth
            $table->text('data');
            $table->timestamps();
            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('candidates');
    }

}
