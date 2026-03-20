<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('leave_requests', function (Blueprint $table) {
            $table->text('review_note')->nullable()->after('reviewed_at');
        });

        Schema::table('expense_claims', function (Blueprint $table) {
            $table->text('review_note')->nullable()->after('processed_at');
        });

        Schema::table('compensation_records', function (Blueprint $table) {
            $table->foreignId('created_by')->nullable()->after('employee_profile_id')->constrained('users')->nullOnDelete();
            $table->foreignId('approved_by')->nullable()->after('created_by')->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable()->after('approved_by');
            $table->text('review_note')->nullable()->after('notes');
        });

        Schema::table('employee_perks', function (Blueprint $table) {
            $table->foreignId('created_by')->nullable()->after('employee_profile_id')->constrained('users')->nullOnDelete();
            $table->foreignId('approved_by')->nullable()->after('created_by')->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable()->after('approved_by');
            $table->text('review_note')->nullable()->after('notes');
        });
    }

    public function down(): void
    {
        Schema::table('employee_perks', function (Blueprint $table) {
            $table->dropConstrainedForeignId('created_by');
            $table->dropConstrainedForeignId('approved_by');
            $table->dropColumn(['approved_at', 'review_note']);
        });

        Schema::table('compensation_records', function (Blueprint $table) {
            $table->dropConstrainedForeignId('created_by');
            $table->dropConstrainedForeignId('approved_by');
            $table->dropColumn(['approved_at', 'review_note']);
        });

        Schema::table('expense_claims', function (Blueprint $table) {
            $table->dropColumn('review_note');
        });

        Schema::table('leave_requests', function (Blueprint $table) {
            $table->dropColumn('review_note');
        });
    }
};
