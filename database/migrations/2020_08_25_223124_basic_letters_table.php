<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BasicLettersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('basic_letters', function (Blueprint $table) {
        //     $table->id();
        //     $table->integer('division')->unsigned();
        //     $table->integer('letter_ref_number')->unsigned()->unique();
        //     $table->string('letter_type', 20);
        //     $table->string('event_name', 200);
        //     $table->string('event_description', 300);
        //     $table->string('event_date', 100);
        //     $table->string('event_time', 100);
        //     $table->string('event_place', 100);
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
        // Schema::dropIfExists('letters');
    }
}
