<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddScoreIdToApplicantAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('applicant_answers', function (Blueprint $table) {
            $table->unsignedBigInteger('score_id')->index()->nullable();
            

            $table->foreign('score_id')->references('id')->on('scores')->onDelete('cascade');
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
            $table->dropForeign(['score_id']);
            $table->dropColumn('score_id');
        });
    }
}
