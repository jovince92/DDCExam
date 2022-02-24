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
            $table->bigIncrements('id');
            $table->unsignedBigInteger('question_id')->nullable()->index();
            $table->unsignedBigInteger('applicant_id')->index();
            $table->unsignedBigInteger('answer_id')->nullable()->index();
            $table->text('applicant_answer')->nullable();
            $table->unsignedInteger('score')->nullable()->default('0');
            $table->tinyInteger('checked')->default(0);
            $table->timestamps();
            $table->unsignedBigInteger('score_id')->nullable()->index();
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
