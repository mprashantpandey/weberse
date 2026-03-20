<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->timestamp('last_contacted_at')->nullable()->after('next_follow_up_at');
            $table->timestamp('proposal_sent_at')->nullable()->after('last_contacted_at');
            $table->decimal('proposal_amount', 12, 2)->nullable()->after('proposal_sent_at');
            $table->string('proposal_reference')->nullable()->after('proposal_amount');
            $table->text('lost_reason')->nullable()->after('proposal_reference');
        });

        Schema::table('follow_ups', function (Blueprint $table) {
            $table->timestamp('completed_at')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('follow_ups', function (Blueprint $table) {
            $table->dropColumn('completed_at');
        });

        Schema::table('leads', function (Blueprint $table) {
            $table->dropColumn([
                'last_contacted_at',
                'proposal_sent_at',
                'proposal_amount',
                'proposal_reference',
                'lost_reason',
            ]);
        });
    }
};
