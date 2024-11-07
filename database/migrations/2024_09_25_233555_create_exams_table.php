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
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lesson_id')->nullable()->constrained('lessons')->onDelete('cascade');
            $table->bigInteger('the_right_choice');
            $table->string('video_url');
            $table->bigInteger('choose1');
            $table->bigInteger('choose2');
            $table->bigInteger('choose3');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};
