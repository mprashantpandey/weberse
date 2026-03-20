# WHMCS: Features & What More You Can Add

This document summarises what WHMCS does out of the box and what you can add or customise for Weberse.

---

## 1. What WHMCS Already Covers

### Products & billing
- **Product groups** – e.g. Hosting, Other Services (order form templates: Standard Cart, Modern, etc.).
- **Product types** – Other (generic), Shared/Reseller/Server (with provisioning modules).
- **Pricing** – Per currency, billing cycle (monthly → triennial), setup fees.
- **One-time vs recurring** – e.g. SSL as one-time, hosting as recurring.
- **Tax** – Tax rules, exemptions, EU VAT, etc.
- **Promotions / discount codes** – Percentage or fixed, product/group scope, validity.

### Domains
- **Registration, transfer, renew** – TLD pricing in Domain Pricing; optional registrar modules (e.g. Enom, ResellerClub).
- **DNS / email forwarding / ID protection** – Toggle per TLD; often via registrar.
- **Domain sync** – Reminders, auto-renew, expiry notices.

### Add-ons & options
- **Product addons** – Extra disk, dedicated IP, etc.; linked to specific products; own pricing/billing cycle.
- **Configurable options** – Dropdown/radio/quantity/yes-no; e.g. “Backup: Weekly / Daily”; pricing can change by option; linked to product groups/products.
- **Bundles** – Multiple products in one order (cart config).

### Client area
- **Dashboard** – Overview, due invoices, active services, tickets, domains.
- **Services** – List hosting/other products; login to panel (if module supports it); upgrade/downgrade.
- **Invoices** – View, pay, PDF, payment methods.
- **Quotes** – Accept/decline.
- **Support tickets** – Departments, priority, attachments, canned replies, merge/split.
- **Knowledge base** – Categories, articles, search.
- **Announcements** – Global or per group.
- **Contacts / sub-accounts** – Extra logins with permissions.
- **Affiliates** – Commission, payouts, referral tracking.

### Admin
- **Clients** – CRUD, notes, merge, custom fields.
- **Orders** – Approve, accept, cancel; fraud checks.
- **Invoices** – Create, edit, send, apply credit, late fees.
- **Support** – Tickets, departments, staff, SLA, spam rules.
- **Reports** – Revenue, clients, orders, products, taxes, etc.
- **Automation** – Cron: suspend/terminate overdue, renew domains, send reminders, generate invoices.
- **Gateways** – PayPal, Stripe, bank transfer, etc.; multiple gateways.
- **Email** – Templates, merge fields, SMTP.
- **Custom fields** – Client, product, domain, checkout.

---

## 2. Features You Can Add or Extend

### A. Integrations (built-in or addons)
- **Registrars** – Connect Enom, ResellerClub, GoDaddy, etc. for real domain registration/transfer/renew.
- **Provisioning** – cPanel, Plesk, DirectAdmin, custom modules so hosting orders auto-create accounts.
- **Payment gateways** – Stripe, PayPal, local gateways; add more via Gateway Modules or marketplace.
- **SSO / auth** – OAuth, SAML, “Login with Google” (addon or custom).
- **Laravel bridge** – You already link from Laravel to WHMCS; optionally sync client or SSO (custom or addon).

### B. Customisation
- **Theme** – You have the Weberse child theme; extend with more overrides or a full custom theme.
- **Order form** – A **Weberse Cart** order form is available at `templates/orderforms/weberse_cart/` (navy + green styling to match the Weberse client theme). Enable it in **Setup → Products/Services → Order Form** by selecting "Weberse Cart" (or `weberse_cart`). It is a copy of Standard Cart with Weberse branding and `css/custom.css` overrides.
- **Client area pages** – Add pages (e.g. “Status” or “API”) via custom template or Client Area Page addon.
- **Hooks** – PHP hooks for: after order, after payment, ticket open, invoice created, etc.; use to call Laravel API, send webhooks, or change behaviour.
- **API** – WHMCS API (local or API role) for: create client, order, invoice, ticket from Laravel or external tools.

### C. Product & commercial
- **More product groups** – e.g. “Email”, “VPS”, “Design services”.
- **Bundles** – “Hosting + Domain + SSL” as a single product or bundle in cart.
- **Sliders / comparison** – Order form addon or custom template for plan comparison.
- **Upsells / cross-sells** – After order or in cart (addon or hooks).
- **Quotes & contracts** – Deeper quote workflow or PDF contracts (addon/template).
- **Subscriptions** – Align with Stripe/PayPal subscriptions via gateway or addon.

### D. Support & communication
- **Live chat** – Tawk.to, Crisp, LiveAgent, etc. (widget or addon).
- **Canned replies / macros** – Built-in; extend with more departments or templates.
- **SLA / escalation** – Addon or custom logic (e.g. close ticket after X days, escalate by priority).
- **Client notifications** – Extra email/SMS on invoice, ticket reply (hooks or addon).

### E. Automation & reporting
- **Custom reports** – Admin reports (e.g. MRR, churn, product mix) via Report module or SQL.
- **Scheduled tasks** – Extra cron jobs (e.g. sync with Laravel, backup list, cleanup).
- **Webhooks** – Send “order paid” or “ticket closed” to Laravel or external systems (hook or addon).

### F. Compliance & trust
- **GDPR** – Data export, consent, anonymise (built-in + settings); add consent logging if needed.
- **2FA** – Client and/or admin (addon or built-in in newer WHMCS).
- **Audit log** – Who changed what (built-in in later versions; extend if needed).

---

## 3. Quick Wins for Weberse

1. **Registrar module** – Add at least one (e.g. ResellerClub) so domain orders actually register/transfer.
2. **Provisioning module** – If you sell real hosting, add cPanel/Plesk so new orders create accounts.
3. **Payment gateway** – Enable Stripe/PayPal so invoices can be paid online.
4. **Email templates** – Adjust welcome, invoice, ticket reply to match Weberse branding.
5. **Hooks** – e.g. “AfterOrder” or “InvoicePaid” to notify Laravel or update internal systems.
6. **Client area link** – Keep “Hosting” / “Billing” in Laravel nav pointing to WHMCS (already in place).
7. **Custom fields** – e.g. “Company type”, “Referral source” for better segmentation and reporting.

---

## 4. Useful Admin Paths (after login)

| What              | Where in Admin                          |
|-------------------|------------------------------------------|
| Products / groups  | Setup → Products/Services                |
| Domain pricing     | Setup → Products/Services → Domain Pricing |
| Addons            | Setup → Products/Services → Add-ons      |
| Config options    | Setup → Products/Services → Configurable Options |
| Currencies        | Setup → Currencies                       |
| Gateways          | Setup → Payments → Payment Gateways      |
| Email templates   | Setup → Email Templates                 |
| Automation        | Setup → Automation Settings              |
| Reports           | Reports                                  |

---

## 5. Seeded Data (from `php billing/seed_plans.php`)

- **Hosting** – 4 plans (Starter / Business / Pro / Enterprise) with pricing.
- **Other Services** – SSL Certificate (one-time), Daily Backup, Priority Support.
- **Addons** – Extra 5 GB Storage, Dedicated IP (for hosting products).
- **Config option** – “Backup Frequency”: Weekly (included) / Daily (+$2/mo).
- **Domain TLDs** – .com, .net, .org, .in, .io with register/transfer/renew pricing.
- **Announcements** – Welcome, New services.
- **Knowledge base** – Getting Started, Billing, Domains + articles.

To test: use the cart to order hosting/domains/SSL, then Admin to manage products, clients, and invoices.
