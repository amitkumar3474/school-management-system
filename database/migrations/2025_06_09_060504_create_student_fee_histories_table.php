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
        Schema::create('student_fee_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('enrollment_id')->constrained('student_enrollments')->onDelete('cascade');
            $table->string('label');     // e.g. Tuition Fee, Transport Fee
            $table->decimal('amount', 10, 2);
            $table->enum('action', ['+', '-']); // + = fee added, - = fee paid/deducted
            $table->text('note')->nullable(); // optional: for more detail
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_fee_histories');
    }
};
