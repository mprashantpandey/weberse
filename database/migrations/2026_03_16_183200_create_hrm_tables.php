<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('job_openings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('department_id')->nullable()->constrained('departments')->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('location')->nullable();
            $table->string('employment_type')->default('full_time');
            $table->longText('description')->nullable();
            $table->boolean('is_published')->default(true);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });

        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_opening_id')->constrained('job_openings')->cascadeOnDelete();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('resume_path')->nullable();
            $table->longText('cover_letter')->nullable();
            $table->string('status')->default('applied');
            $table->string('interview_status')->default('not_scheduled');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('employee_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('department_id')->nullable()->constrained('departments')->nullOnDelete();
            $table->string('employee_code')->unique();
            $table->date('join_date')->nullable();
            $table->string('employment_status')->default('active');
            $table->string('emergency_contact')->nullable();
            $table->json('documents')->nullable();
            $table->timestamps();
        });

        Schema::create('leave_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_profile_id')->constrained('employee_profiles')->cascadeOnDelete();
            $table->string('type')->default('casual');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('status')->default('pending');
            $table->text('reason')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leave_requests');
        Schema::dropIfExists('employee_profiles');
        Schema::dropIfExists('job_applications');
        Schema::dropIfExists('job_openings');
        Schema::dropIfExists('departments');
    }
};
