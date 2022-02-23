<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicantAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applicant_answers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('question_id')->index()->nullable();
            $table->unsignedBigInteger('applicant_id')->index();
            $table->unsignedBigInteger('answer_id')->index()->nullable();
            $table->text('applicant_answer')->nullable();
            $table->unsignedInteger('score')->nullable();
            $table->timestamps();

            $table->foreign('question_id')->references('id')->on('questions')->onDelete('set null');
            $table->foreign('applicant_id')->references('id')->on('applicants')->onDelete('cascade');
            $table->foreign('answer_id')->references('id')->on('answers')->onDelete('set null');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('applicant_answers');
    }
}
