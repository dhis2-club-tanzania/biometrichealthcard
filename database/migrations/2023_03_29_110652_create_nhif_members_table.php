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
            $table->id();
            $table->string('FirstName');
            $table->string('Surname');
            $table->string('MobileNo');
            $table->string('Gender');
            $table->string('CardNo');
            $table->string('card_status');
            $table->string('image')->nullable();
            $table->boolean('FingerprintStatus')->default(false);
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
