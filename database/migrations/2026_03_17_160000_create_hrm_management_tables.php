<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('interview_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_application_id')->constrained('job_applications')->cascadeOnDelete();
            $table->foreignId('scheduled_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('interviewer_name');
            $table->string('interviewer_email')->nullable();
            $table->string('mode')->default('video');
            $table->string('meeting_link')->nullable();
            $table->timestamp('scheduled_for');
            $table->unsignedInteger('duration_minutes')->default(45);
            $table->string('stage')->default('screening');
            $table->string('status')->default('scheduled');
            $table->text('notes')->nullable();
            $table->text('feedback')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });

        Schema::create('compensation_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_profile_id')->constrained('employee_profiles')->cascadeOnDelete();
            $table->string('title');
            $table->string('pay_type')->default('monthly_salary');
            $table->decimal('amount', 12, 2);
            $table->string('currency', 10)->default('INR');
            $table->date('effective_from');
            $table->date('effective_to')->nullable();
            $table->string('status')->default('active');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('expense_claims', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_profile_id')->constrained('employee_profiles')->cascadeOnDelete();
            $table->foreignId('submitted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('title');
            $table->string('category')->default('general');
            $table->decimal('amount', 12, 2);
            $table->string('currency', 10)->default('INR');
            $table->date('expense_date');
            $table->string('status')->default('pending');
            $table->string('receipt_path')->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();
        });

        Schema::create('employee_perks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_profile_id')->constrained('employee_profiles')->cascadeOnDelete();
            $table->string('title');
            $table->string('perk_type')->default('benefit');
            $table->string('value')->nullable();
            $table->string('status')->default('active');
            $table->date('starts_on')->nullable();
            $table->date('ends_on')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employee_perks');
        Schema::dropIfExists('expense_claims');
        Schema::dropIfExists('compensation_records');
        Schema::dropIfExists('interview_schedules');
    }
};
