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
        Schema::create('student_guardian_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->string('father_name');
            $table->string('mother_name');
            $table->string('guardian_mobile', 10);
            $table->string('grd_relation');
            $table->string('grd_occupation');
            $table->string('grd_income');
            $table->string('grd_education');
            $table->string('grd_city')->nullable();
            $table->string('grd_state')->nullable();
            $table->string('grd_email')->nullable();
            $table->text('grd_address');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_guardian_details');
    }
};
