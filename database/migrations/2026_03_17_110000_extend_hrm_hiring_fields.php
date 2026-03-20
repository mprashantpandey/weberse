<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('job_openings', function (Blueprint $table) {
            $table->unsignedInteger('salary_min')->nullable()->after('description');
            $table->unsignedInteger('salary_max')->nullable()->after('salary_min');
            $table->string('salary_currency', 10)->nullable()->after('salary_max');
            $table->unsignedTinyInteger('experience_min')->nullable()->after('salary_currency');
            $table->unsignedTinyInteger('experience_max')->nullable()->after('experience_min');
            $table->string('notice_period')->nullable()->after('experience_max');
            $table->boolean('immediate_joiner_preferred')->default(false)->after('notice_period');
            $table->json('skills')->nullable()->after('immediate_joiner_preferred');
            $table->json('application_questions')->nullable()->after('skills');
        });

        Schema::table('job_applications', function (Blueprint $table) {
            $table->string('notice_period_response')->nullable()->after('phone');
            $table->json('application_answers')->nullable()->after('cover_letter');
        });
    }

    public function down(): void
    {
        Schema::table('job_applications', function (Blueprint $table) {
            $table->dropColumn([
                'notice_period_response',
                'application_answers',
            ]);
        });

        Schema::table('job_openings', function (Blueprint $table) {
            $table->dropColumn([
                'salary_min',
                'salary_max',
                'salary_currency',
                'experience_min',
                'experience_max',
                'notice_period',
                'immediate_joiner_preferred',
                'skills',
                'application_questions',
            ]);
        });
    }
};
