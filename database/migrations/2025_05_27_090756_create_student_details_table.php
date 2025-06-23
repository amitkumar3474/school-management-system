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
        Schema::create('student_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->string('aadhaar_number');
            $table->string('religion');
            $table->string('mother_tongue');
            $table->string('jan_aadhar_no')->nullable();
            $table->string('rural_urban')->nullable();
            $table->string('habitation')->nullable();
            $table->date('date_of_admission');
            $table->string('admission_no');
            $table->string('bpl');
            $table->string('weaker_section');
            $table->string('rte_education');
            $table->string('class_studied_previous_year');
            $table->string('status_if_class_1st');
            $table->integer('attended_school')->nullable();
            $table->string('medium');
            $table->string('disability_type');
            $table->string('cwsn_facility');
            $table->string('uniforms');
            $table->string('textbook');
            $table->string('transport');
            $table->string('bicycle');
            $table->string('escort_facility');
            $table->string('midday_meal');
            $table->string('hostel_facility');
            $table->string('special_training');
            $table->string('homeless_status');
            $table->string('appeared_last_exam');
            $table->string('passed_last_exam');
            $table->string('last_exam_percentage')->nullable();
            $table->string('stream');
            $table->string('trade_sector');
            $table->string('iron_folic_tablets');
            $table->string('deworming_tablets');
            $table->string('vitamin_a_tablets');
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_details');
    }
};
