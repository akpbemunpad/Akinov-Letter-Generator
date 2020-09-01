<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class OtherLettersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('other_letters', function (Blueprint $table) {
        //     $table->id();
        //     $table->integer('letter_ref_number')->unsigned()->unique();
        //     $table->string('file_name', 100);
        //     $table->boolean('acc_hod')->default(false);
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
        //
    }
}
