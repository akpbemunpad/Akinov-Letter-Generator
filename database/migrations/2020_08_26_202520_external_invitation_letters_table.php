<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ExternalInvitationLettersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('external_invitation_letters', function (Blueprint $table) {
        //     $table->id();
        //     $table->integer('letter_ref_number')->unsigned()->unique();
        //     $table->string('event_name', 200);
        //     $table->string('event_date', 100);
        //     $table->string('event_time', 100);
        //     $table->string('event_place', 100);
        //     $table->string('event_topic', 100);
        //     $table->integer('speaker_type')->unsigned();
        //     $table->string('speaker_fullname', 100);
        //     $table->string('speaker_position', 100)->nullable();
        //     $table->string('speaker_gender', 20);
        //     $table->string('cp_name', 100);
        //     $table->string('cp_contact', 100);
        //     $table->boolean('acc_hod')->default(false);
        //     $table->string('file_name', 100);
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('external_invitation_letters');
    }
}
