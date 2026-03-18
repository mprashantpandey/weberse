<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('portfolio_projects', function (Blueprint $table) {
            $table->string('category')->nullable()->after('slug');
            $table->json('stack')->nullable()->after('body');
            $table->json('metrics')->nullable()->after('stack');
            $table->text('challenge')->nullable()->after('metrics');
            $table->text('solution')->nullable()->after('challenge');
            $table->text('outcome')->nullable()->after('solution');
        });

        Schema::create('case_studies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('summary', 500)->nullable();
            $table->string('client')->nullable();
            $table->string('industry')->nullable();
            $table->string('duration')->nullable();
            $table->string('engagement')->nullable();
            $table->string('featured_image')->nullable();
            $table->json('services')->nullable();
            $table->json('stack')->nullable();
            $table->longText('challenge')->nullable();
            $table->longText('solution')->nullable();
            $table->longText('outcome')->nullable();
            $table->json('results')->nullable();
            $table->json('metrics')->nullable();
            $table->text('quote')->nullable();
            $table->string('quote_author')->nullable();
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('case_studies');

        Schema::table('portfolio_projects', function (Blueprint $table) {
            $table->dropColumn([
                'category',
                'stack',
                'metrics',
                'challenge',
                'solution',
                'outcome',
            ]);
        });
    }
};
