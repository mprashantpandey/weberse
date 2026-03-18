<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('store_products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('short_description', 500)->nullable();
            $table->longText('description')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('status')->default('draft')->index(); // draft|published|archived
            $table->string('currency', 3)->default('INR');
            $table->unsignedBigInteger('price_paise')->default(0);
            $table->json('meta')->nullable(); // tags, requirements, changelog, etc.
            $table->timestamps();
        });

        Schema::create('store_product_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('store_products')->cascadeOnDelete();
            $table->string('version')->nullable();
            $table->string('original_name');
            $table->string('storage_path');
            $table->unsignedBigInteger('size_bytes')->default(0);
            $table->string('checksum_sha256', 64)->nullable();
            $table->boolean('is_primary')->default(false);
            $table->timestamps();

            $table->index(['product_id', 'is_primary']);
        });

        Schema::create('store_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('buyer_name')->nullable();
            $table->string('buyer_email')->index();
            $table->string('buyer_phone')->nullable();
            $table->string('currency', 3)->default('INR');
            $table->unsignedBigInteger('subtotal_paise')->default(0);
            $table->unsignedBigInteger('total_paise')->default(0);
            $table->string('status')->default('pending')->index(); // pending|paid|failed|refunded
            $table->string('payment_provider')->default('razorpay')->index();
            $table->string('provider_order_id')->nullable()->index();
            $table->string('provider_payment_id')->nullable()->index();
            $table->string('provider_signature')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->json('meta')->nullable(); // webhook payloads, notes, coupon, etc.
            $table->timestamps();
        });

        Schema::create('store_order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('store_orders')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('store_products')->restrictOnDelete();
            $table->unsignedInteger('qty')->default(1);
            $table->unsignedBigInteger('unit_price_paise')->default(0);
            $table->unsignedBigInteger('line_total_paise')->default(0);
            $table->string('product_name_snapshot');
            $table->string('product_slug_snapshot');
            $table->string('product_version_snapshot')->nullable();
            $table->timestamps();
        });

        Schema::create('store_entitlements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('store_products')->restrictOnDelete();
            $table->foreignId('order_id')->constrained('store_orders')->cascadeOnDelete();
            $table->timestamp('granted_at')->useCurrent();
            $table->timestamp('revoked_at')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'product_id', 'order_id']);
            $table->index(['user_id', 'revoked_at']);
        });

        Schema::create('store_download_tokens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('entitlement_id')->constrained('store_entitlements')->cascadeOnDelete();
            $table->string('token', 80)->unique();
            $table->timestamp('expires_at')->index();
            $table->unsignedInteger('max_downloads')->default(5);
            $table->unsignedInteger('downloads_count')->default(0);
            $table->timestamp('last_downloaded_at')->nullable();
            $table->timestamps();
        });

        Schema::create('store_invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('store_orders')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('buyer_name')->nullable();
            $table->string('buyer_email')->index();
            $table->string('currency', 3)->default('INR');
            $table->unsignedBigInteger('subtotal_paise')->default(0);
            $table->unsignedBigInteger('total_paise')->default(0);
            $table->string('status')->default('issued')->index(); // issued|void|refunded
            $table->timestamp('issued_at')->useCurrent();
            $table->json('meta')->nullable();
            $table->timestamps();
        });

        Schema::create('store_invoice_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained('store_invoices')->cascadeOnDelete();
            $table->string('label');
            $table->unsignedInteger('qty')->default(1);
            $table->unsignedBigInteger('unit_price_paise')->default(0);
            $table->unsignedBigInteger('line_total_paise')->default(0);
            $table->json('meta')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('store_invoice_items');
        Schema::dropIfExists('store_invoices');
        Schema::dropIfExists('store_download_tokens');
        Schema::dropIfExists('store_entitlements');
        Schema::dropIfExists('store_order_items');
        Schema::dropIfExists('store_orders');
        Schema::dropIfExists('store_product_files');
        Schema::dropIfExists('store_products');
    }
};

