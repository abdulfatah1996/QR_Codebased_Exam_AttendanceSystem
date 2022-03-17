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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->string('phone')->nullable();
            $table->longText('address')->nullable();
            $table->enum('gender', ['Male', 'Female'])->nullable();
            $table->date('age')->nullable();
            $table->enum('degree', ['Bachelor', 'Master', 'Doctoral'])->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('college_id')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('college_id')->references('id')->on('colleges')->onDelete('cascade');
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
};
