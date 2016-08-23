<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*Schema::table('users', function ($table) {
            $table->foreign('departement')->references('id')->on('departements')->onDelete('cascade');
        });

        Schema::table('sujets', function ($table) {
            $table->foreign('proposer_par')->references('id')->on('users');
        });

        Schema::table('presences', function ($table) {
            $table->foreign('stagiaire')->references('id')->on('users');
        });

        Schema::table('messages', function ($table) {
            $table->foreign('from')->references('id')->on('users');
            $table->foreign('to')->references('id')->on('users');
        });

        Schema::table('stages', function ($table) {
            $table->foreign('stagiaire')->references('id')->on('users');
            $table->foreign('responsable')->references('id')->on('users');
        });

        Schema::table('taches', function ($table) {
            $table->foreign('stage')->references('id')->on('stages');
            $table->foreign('sujet')->references('id')->on('sujets');
        });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
