<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicantContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applicant_contacts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('applicant_id')->index();
            $table->text('address');
            $table->string('region');
            $table->string('province');
            $table->string('city');
            $table->string('zipcode');
            $table->string('phone_number');
            $table->string('email');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('applicant_contacts');
    }
}
