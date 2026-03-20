# Database Schema

## Core

- `users`
- `roles`, `permissions`, pivot tables
- `activity_log`

## CMS

- `site_settings`
- `services`
- `portfolio_projects`
- `blog_posts`
- `testimonials`

## CRM

- `contacts`
- `leads`
- `lead_notes`
- `follow_ups`

## HRM

- `departments`
- `job_openings`
- `job_applications`
- `employee_profiles`
- `leave_requests`

## Client / Support

- `support_departments`
- `support_tickets`
- `support_replies`
- `client_documents`

## Integration

- `users.whmcs_client_id` links a Laravel user to a WHMCS client account.
