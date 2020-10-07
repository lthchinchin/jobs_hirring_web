<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblJobHirring extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_job_hirring', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('company_mail');
            $table->string('programing_language');
            $table->text('job_position');        
            $table->string('link_post');
            $table->text('desc');
            $table->integer('status');
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
        Schema::dropIfExists('tbl_job_hirring');
    }
}
