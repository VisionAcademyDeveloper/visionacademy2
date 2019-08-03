<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('university_id')->default(1);
            $table->unsignedBigInteger('department_id')->default(1);
            $table->text('bio')->nullable('شخص سيكون عظيمًا ذات يوم:)');
            $table->string('twitter')->nullable();
            $table->string('telegram')->nullable();
            $table->string('avatar_url')->nullable()->default('http://lotem.io/wp-content/uploads/2015/12/Screen-Shot-2016-05-25-at-8.22.18-PM-2.png');
            $table->timestamps();

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
        Schema::dropIfExists('profiles');
    }
}
