# Weberse Platform

Laravel 11 business platform for Weberse Infotech Pvt. Ltd. It combines the corporate website, CMS, CRM, HRM, client portal, support desk, analytics, and WHMCS integration in one maintainable application.

## Repo

This repository is meant to be safe to share. Secrets must not be committed:
- `.env` is intentionally ignored
- use `.env.example` to configure environments

## Stack

- Laravel 11 / PHP 8.3
- Blade templates
- TailwindCSS 4
- Alpine.js
- Laravel Sanctum
- Spatie Permission
- Spatie Activitylog
- Redis-ready cache and queues
- Docker-ready deployment

## Modules

- Website
- CMS
- CRM
- HRM
- Client Portal
- Support
- Analytics
- WHMCS Integration

## Key Principle

Laravel owns identity, content, leads, hiring, support, and dashboards. WHMCS on `billing.weberse.com` remains the source of truth for hosting, invoices, billing, and payments.

## Docs

- [Architecture](/Users/prashant/Desktop/Weberse/docs/architecture.md)
- [Database Schema](/Users/prashant/Desktop/Weberse/docs/database-schema.md)

## Setup

1. Configure `.env`.
2. Run `composer install`.
3. Run `npm install`.
4. Run `php artisan key:generate`.
5. Run `php artisan migrate --seed`.
6. Run `npm run build`.
7. Run `php artisan serve`.
