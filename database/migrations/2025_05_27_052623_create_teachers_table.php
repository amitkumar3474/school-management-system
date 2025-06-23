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
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('staff_id')->unique();
            $table->string('name');
            $table->enum('gender', ['Male', 'Female', 'Other']);
            $table->date('dob')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->date('joining_date')->nullable();
            $table->text('address')->nullable();
            $table->string('blood_group')->nullable(); 
            $table->string('religion')->nullable(); 
            $table->string('marital_status')->nullable(); 
            $table->string('photo')->nullable();
            $table->tinyInteger('status')->default(1)->comment('1 = Active, 0 = Inactive'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
