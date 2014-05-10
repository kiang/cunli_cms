<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCunlisTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('cunlis', function(Blueprint $table) {
            $table->char('id', 20);
            $table->integer('county_id')->unsigned();
            $table->integer('town_id')->unsigned();
            $table->string('title');
            $table->integer('count_candidates')->unsigned();
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
        Schema::drop('cunlis');
    }

}
