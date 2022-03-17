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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('studentName');
            $table->string('studentId')->unique();
            $table->string('nationalId')->unique();
            $table->string('phone')->unique();
            $table->string('email')->unique();
            $table->longText('address');
            $table->enum('gender', ['Male', 'Female']);
            $table->date('age');
            $table->enum('degree', ['Bachelor', 'Master', 'Doctoral']);
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
        Schema::dropIfExists('students');
    }
};
