<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nhif_members', function (Blueprint $table) {
            $table->id();;
            $table->string('FirstName');
            $table->string('Surname');
            $table->string('MobileNo');
            $table->string('Gender');
            $table->string('CardNo');
            $table->string('image')->nullable();
            $table->boolean('FingerprintStatus')->default(false);
            // $table->string('FormFourIndexNo');
            // $table->string('MiddleName');
            // $table->string('AdmissionNo');
            // $table->string('CollageFaculty');
            // $table->string('ProgrammeOfStudy');
            // $table->integer('CourseDuration');
            // $table->string('MaritalStatus');
            // $table->date('DateJoiningEmployer');
            // $table->date('DateOfBirth');
            // $table->string('NationalID');
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
        Schema::dropIfExists('nhif_members');
    }
};
