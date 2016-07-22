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
            $table->date('date_debut');
            $table->date('date_fin');
            $table->string('etablissement')->nullable();
            $table->string('documents')->nullable(); // list of the administration documents in json
            $table->timestamps();

            //$table->foreign('stagiaire')->references('id')->on('users');
            //$table->foreign('responsable')->references('id')->on('users');
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

        //create table "messages"
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('from');
            $table->integer('to');
            $table->string('objet');
            $table->longText('message');
            $table->timestamps();

            //$table->foreign('from')->references('id')->on('users');
            //$table->foreign('to')->references('id')->on('users');
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
