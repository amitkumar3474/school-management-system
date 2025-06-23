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
        Schema::create('transports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_route_id')->nullable()->constrained('transports')->onDelete('cascade');
            $table->string('route_name');
            $table->string('start_place');
            $table->string('stop_place');
            $table->string('vehicle_no');
            $table->string('driver_name');
            $table->string('driver_phone');
            $table->string('driver_license');
            $table->decimal('fee', 10, 2);
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transports');
    }
};
