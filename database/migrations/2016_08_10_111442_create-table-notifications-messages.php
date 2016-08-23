<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableNotificationsMessages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('broadcast')->nullable();
            $table->integer('from')->nullable();
            $table->integer('to')->nullable();
            $table->integer('type'); 
                /**
                 * 10 :: condidat ajouter | 12::condidat modifier | 21 :: condidat en stagiaire | 
                 * 50 :: new tache | 51 :: tache confirmer | 52::tache à refaire | 53:: tache à examiner
                 * 40 :: sujet ajouter | 41 : sujet realisé en stage | 30:: stage en cours | 31 : Stage conclue
                 */
            $table->date('date_add');
            $table->date('date_seen')->nullable();
            $table->string('lien')->nullable();
            $table->timestamps();

            //$table->foreign('proposer_par')->references('id')->on('users');
        });
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('from');
            $table->integer('to');
            $table->integer('type');
            $table->date('date_add');
            $table->date('date_seen')->nullable();
            $table->timestamps();

            //$table->foreign('proposer_par')->references('id')->on('users');
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
