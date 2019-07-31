<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('university_id')->unsigned()->default(1);
            $table->bigInteger('department_id')->unsigned()->default(1);
            $table->string('name');
            $table->integer('old_price')->default(1000);
            $table->integer('price')->default(500);
            $table->integer('display')->default(1);
            $table->longText('description')->nullable();
            $table->string('logo_url')->nullable()->default('http://naifacademy.net/logo.png');
            $table->string('preview_url')->nullable();
            $table->string('prerequisites')->nullable();
            $table->string('classLink')->nullable();
            $table->string('classTableInfo')->nullable();
            $table->timestamps();
        });

        Schema::table('courses', function ($table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('university_id')->references('id')->on('universities')->onDelete('cascade');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courses');
    }
}
