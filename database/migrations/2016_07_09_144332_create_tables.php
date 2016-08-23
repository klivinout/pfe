<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //create table "sujets"
        Schema::create('sujets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('proposer_par');
            $table->string('objet');
            $table->longText('description');
            $table->string('pieces_jointe'); // list of the attachements in json
            $table->timestamps();

            //$table->foreign('proposer_par')->references('id')->on('users');
        });

        //create table "stages"
        Schema::create('stages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('stagiaire');
            $table->integer('responsable');
            $table->integer('sujet')->nullable();
            $table->timestamps();

            //$table->foreign('stagiaire')->references('id')->on('users');
            //$table->foreign('responsable')->references('id')->on('users');
            //$table->foreign('sujet')->references('id')->on('sujets');
        });

        //create table "taches"
        Schema::create('taches', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('stage');
            $table->integer('sujet');
            $table->string('objet');
            $table->longText('description');
            $table->timestamps();

            //$table->foreign('stage')->references('id')->on('stages');
            //$table->foreign('sujet')->references('id')->on('sujets');
        });

        //create table "presences"
        Schema::create('presences', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('stagiaire');
            $table->timestamps();

            //$table->foreign('stagiaire')->references('id')->on('users');
        });

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
