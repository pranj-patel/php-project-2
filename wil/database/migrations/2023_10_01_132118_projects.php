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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('inp_username')->nullable();
            $table->string('inp_email')->nullable();
            $table->text('description');
            $table->integer('num_students');
            $table->unsignedBigInteger('inp_id');
            $table->unsignedInteger('year');
            $table->unsignedInteger('trimester');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
