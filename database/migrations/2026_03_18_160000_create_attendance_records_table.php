<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendance_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_profile_id')->constrained('employee_profiles')->cascadeOnDelete();
            $table->foreignId('marked_by')->nullable()->constrained('users')->nullOnDelete();
            $table->date('work_date');
            $table->timestamp('clock_in_at')->nullable();
            $table->timestamp('clock_out_at')->nullable();
            $table->string('status')->default('present');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['employee_profile_id', 'work_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendance_records');
    }
};
