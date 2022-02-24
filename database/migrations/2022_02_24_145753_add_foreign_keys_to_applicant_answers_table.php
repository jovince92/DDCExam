<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToApplicantAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('applicant_answers', function (Blueprint $table) {
            $table->foreign(['score_id'])->references(['id'])->on('scores')->onDelete('CASCADE');
            $table->foreign(['answer_id'])->references(['id'])->on('answers')->onDelete('SET NULL');
            $table->foreign(['question_id'])->references(['id'])->on('questions')->onDelete('SET NULL');
            $table->foreign(['applicant_id'])->references(['id'])->on('applicants')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('applicant_answers', function (Blueprint $table) {
            $table->dropForeign('applicant_answers_score_id_foreign');
            $table->dropForeign('applicant_answers_answer_id_foreign');
            $table->dropForeign('applicant_answers_question_id_foreign');
            $table->dropForeign('applicant_answers_applicant_id_foreign');
        });
    }
}
