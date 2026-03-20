<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('email_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('category')->default('general');
            $table->string('subject');
            $table->longText('body');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('newsletter_subscribers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->unique();
            $table->string('status')->default('active');
            $table->string('source')->default('website_footer');
            $table->json('meta')->nullable();
            $table->timestamp('subscribed_at')->nullable();
            $table->timestamp('unsubscribed_at')->nullable();
            $table->timestamp('last_sent_at')->nullable();
            $table->timestamps();
        });

        Schema::create('newsletter_campaigns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('email_template_id')->nullable()->constrained('email_templates')->nullOnDelete();
            $table->string('title');
            $table->string('subject');
            $table->longText('body');
            $table->string('status')->default('draft');
            $table->string('target_segment')->default('all_active');
            $table->timestamp('sent_at')->nullable();
            $table->unsignedInteger('sent_count')->default(0);
            $table->text('last_error')->nullable();
            $table->timestamps();
        });

        Schema::create('outbound_emails', function (Blueprint $table) {
            $table->id();
            $table->foreignId('email_template_id')->nullable()->constrained('email_templates')->nullOnDelete();
            $table->foreignId('newsletter_campaign_id')->nullable()->constrained('newsletter_campaigns')->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('recipient_name')->nullable();
            $table->string('recipient_email');
            $table->string('subject');
            $table->longText('body');
            $table->string('status')->default('queued');
            $table->timestamp('sent_at')->nullable();
            $table->text('error_message')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('outbound_emails');
        Schema::dropIfExists('newsletter_campaigns');
        Schema::dropIfExists('newsletter_subscribers');
        Schema::dropIfExists('email_templates');
    }
};
