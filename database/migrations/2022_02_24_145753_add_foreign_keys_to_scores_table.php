<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('scores', function (Blueprint $table) {
            $table->foreign(['applicant_id'])->references(['id'])->on('applicants')->onDelete('CASCADE');
            $table->foreign(['exam_id'])->references(['id'])->on('exams')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('scores', function (Blueprint $table) {
            $table->dropForeign('scores_applicant_id_foreign');
            $table->dropForeign('scores_exam_id_foreign');
        });
    }
}
