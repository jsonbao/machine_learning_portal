<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLearningTopicsSubjects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('learning_topic_subject', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('learning_topic_id')->unsigned();
            $table->integer('subject_id')->unsigned();
            $table->foreign('learning_topic_id')->references('id')->on('learning_topics')->onDelete('cascade');
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('learning_topic_subject');
           
    }
}
