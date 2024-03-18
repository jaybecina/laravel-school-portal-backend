<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('subject_code');
            $table->string('name');
            $table->time('start_time', $precision = 0);
            $table->time('end_time', $precision = 0);
            $table->date('day');
            $table->string('prereq_subject_code')->nullable();
            $table->string('prereq_name')->nullable();
            $table->string('room_no');
            $table->integer('units');
            $table->text('detail');
            $table->foreignId('teacher_id')->references('id')->on('users')->constrained();
            $table->boolean('is_prereq')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};
