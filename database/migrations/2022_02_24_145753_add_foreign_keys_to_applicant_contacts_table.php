<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToApplicantContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('applicant_contacts', function (Blueprint $table) {
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
        Schema::table('applicant_contacts', function (Blueprint $table) {
            $table->dropForeign('applicant_contacts_applicant_id_foreign');
        });
    }
}
