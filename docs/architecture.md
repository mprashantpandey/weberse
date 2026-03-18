# Architecture

## Overview

Weberse Platform is a modular Laravel monolith designed for operational simplicity and clean domain boundaries.

```text
Public Website ----\
Admin Dashboard ----> Laravel 11 Platform ----> Database / Redis / Storage
Client Portal -----/             |
                                 v
                          WHMCS API + SSO
```

## Modules

- Website: public marketing pages, careers, blog, hosting landing.
- CMS: editable website content and branding.
- CRM: leads, contacts, notes, follow-ups.
- HRM: jobs, applications, employees, leave tracking.
- Client Portal: hosting overview, invoices, documents, support.
- Support: ticket submission and staff response.
- Analytics: internal KPIs and WHMCS sales snapshots.
- WHMCS Integration: service layer for API and SSO handoff.

## Layers

- Controllers: request handling.
- Services: business logic and external integrations.
- Models: persistence and relations.
- Views: Blade layouts and page templates.
- Policies and middleware: access control.

## Auth and Permissions

- Laravel session auth for web UI.
- Sanctum for future API consumption.
- Spatie roles for `admin`, `hr`, `sales`, `support`, `client`.

## Integration Boundary

- Laravel never recreates invoices, hosting plans, domain logic, or payments.
- WHMCS data is fetched into the client/admin experience through `WhmcsService`.
- Checkout and detailed hosting actions redirect to WHMCS.
