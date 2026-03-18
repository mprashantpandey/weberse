<?php

namespace Database\Seeders;

use App\Models\Store\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class StoreProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name' => 'Weberse CRM Starter Kit (Laravel)',
                'short_description' => 'A clean CRM foundation: leads, contacts, pipeline, notes, and follow-ups.',
                'price_paise' => 249900, // ₹2,499.00
                'meta' => [
                    'category' => 'Laravel',
                    'tags' => ['crm', 'laravel', 'admin-panel', 'saas'],
                    'highlights' => [
                        'Role-based access (admin/sales/support)',
                        'Lead stages + follow-ups',
                        'Modern dashboard UI',
                    ],
                    'requirements' => [
                        'PHP 8.2+',
                        'MySQL 8+',
                        'Composer + Node',
                    ],
                ],
            ],
            [
                'name' => 'Weberse Support Desk Module',
                'short_description' => 'Tickets, departments, replies, and operational reporting-ready structure.',
                'price_paise' => 149900, // ₹1,499.00
                'meta' => [
                    'category' => 'Operations',
                    'tags' => ['support', 'tickets', 'helpdesk'],
                    'highlights' => [
                        'Ticket lifecycle + priorities',
                        'Fast UI for internal teams',
                        'Client-facing experience ready',
                    ],
                ],
            ],
            [
                'name' => 'Weberse Website + CMS Bundle',
                'short_description' => 'Premium marketing site templates + CMS scaffolding that matches Weberse styling.',
                'price_paise' => 199900, // ₹1,999.00
                'meta' => [
                    'category' => 'Website',
                    'tags' => ['cms', 'marketing', 'tailwind', 'blade'],
                    'highlights' => [
                        'Service pages + blog + portfolio',
                        'Brand-ready UI components',
                        'SEO fields for posts',
                    ],
                ],
            ],
            [
                'name' => 'Weberse WHMCS Theming Pack',
                'short_description' => 'A Weberse-branded WHMCS client + orderform theme (dark navy + green).',
                'price_paise' => 299900, // ₹2,999.00
                'meta' => [
                    'category' => 'WHMCS',
                    'tags' => ['whmcs', 'theme', 'orderform'],
                    'highlights' => [
                        'SaaS-like order flow with stepper',
                        'Landing page styling',
                        'Consistent branding',
                    ],
                ],
            ],
        ];

        foreach ($products as $row) {
            $slug = Str::slug($row['name']);

            Product::query()->updateOrCreate(
                ['slug' => $slug],
                [
                    'name' => $row['name'],
                    'slug' => $slug,
                    'short_description' => $row['short_description'] ?? null,
                    'description' => $row['description'] ?? null,
                    'cover_image' => $row['cover_image'] ?? null,
                    'status' => 'published',
                    'currency' => 'INR',
                    'price_paise' => (int) ($row['price_paise'] ?? 0),
                    'meta' => $row['meta'] ?? [],
                ]
            );
        }
    }
}

