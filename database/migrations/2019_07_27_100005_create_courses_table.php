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
            $table->integer('user_id');
            $table->integer('university_id')->default(1);
            $table->integer('department_id')->default(1);
            $table->string('name');
            $table->integer('price')->default(500);
            $table->integer('display')->default(1);
            $table->longText('description');
            $table->string('logo_url')->nullable()->default('http://naifacademy.net/logo.png');
            $table->string('preview_url')->nullable();
            $table->string('prerequisites')->nullable();
            $table->string('classLink')->nullable();
            $table->string('classTableInfo')->nullable();
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
        Schema::dropIfExists('courses');
    }
}
