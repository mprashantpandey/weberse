<?php

namespace Database\Seeders;

use App\Models\CMS\BlogPost;
use App\Models\CMS\CaseStudy;
use App\Models\CMS\PortfolioProject;
use App\Models\User;
use Illuminate\Database\Seeder;

class MarketingContentSeeder extends Seeder
{
    public function run(): void
    {
        $authorId = User::query()->orderBy('id')->value('id');

        foreach ([
            [
                'title' => 'Zenflow Ops',
                'slug' => 'zenflow-ops',
                'category' => 'Operations Platform',
                'client_name' => 'Vertex Commerce',
                'industry' => 'Operations',
                'featured_image' => 'assets/legacy/work-1.jpg',
                'project_url' => null,
                'summary' => 'A unified business operations dashboard for lead intake, support, and client collaboration.',
                'body' => 'Designed as a single operating surface for teams that needed clearer workflows across sales, support, and internal coordination.',
                'stack' => ['Laravel', 'TailwindCSS', 'Redis'],
                'metrics' => ['3 core workflows unified', 'Single dashboard for staff', 'Faster client response cycle'],
                'challenge' => 'The team was managing client conversations, leads, and delivery updates across disconnected tools.',
                'solution' => 'We designed a single operations platform with role-based dashboards, cleaner intake, and structured collaboration views.',
                'outcome' => 'The business gained one operational source of truth, faster follow-up, and better visibility for both staff and clients.',
                'is_published' => true,
            ],
            [
                'title' => 'Nova Host',
                'slug' => 'nova-host',
                'category' => 'Hosting Experience',
                'client_name' => 'CloudHarbor Hosting',
                'industry' => 'Hosting',
                'featured_image' => 'assets/legacy/work-2.jpg',
                'project_url' => null,
                'summary' => 'A premium hosting storefront and onboarding experience layered on top of WHMCS.',
                'body' => 'Built to improve plan clarity and create a stronger branded handoff into billing.',
                'stack' => ['WHMCS', 'Blade', 'JavaScript'],
                'metrics' => ['Sharper plan differentiation', 'Branded WHMCS handoff', 'Cleaner product navigation'],
                'challenge' => 'The product catalog and billing flow felt generic, which made differentiation difficult in a crowded market.',
                'solution' => 'We redesigned the marketing and hosting journey around clearer plan positioning and a stronger handoff into WHMCS.',
                'outcome' => 'The storefront looked more premium, communicated value faster, and made hosting offers easier to compare.',
                'is_published' => true,
            ],
            [
                'title' => 'Pulse Mobile',
                'slug' => 'pulse-mobile',
                'category' => 'Mobile Product',
                'client_name' => 'Pulse Mobile',
                'industry' => 'Mobile',
                'featured_image' => 'assets/legacy/work-3.jpg',
                'project_url' => null,
                'summary' => 'A service-booking mobile application with a clean acquisition and retention flow.',
                'body' => 'Designed around smoother onboarding, trust-building UI states, and operational visibility for the business team.',
                'stack' => ['Flutter', 'Firebase', 'Figma'],
                'metrics' => ['Reduced booking friction', 'Mobile-first UI system', 'Operational visibility built in'],
                'challenge' => 'The booking journey needed to feel simple for users while still supporting operational visibility on the backend.',
                'solution' => 'We mapped a lighter onboarding flow, designed clear UI states, and paired the mobile experience with operational support tools.',
                'outcome' => 'The result was a smoother product experience with better booking flow clarity and stronger product trust.',
                'is_published' => true,
            ],
        ] as $projectRecord) {
            PortfolioProject::query()->updateOrCreate(
                ['slug' => $projectRecord['slug']],
                $projectRecord
            );
        }

        foreach ([
            [
                'title' => 'Helping Jaipur Marble Studio Convert More Local Inquiries',
                'slug' => 'jaipur-marble-studio-lead-funnel',
                'summary' => 'A premium brochure site and lead funnel for a Jaipur-based marble and interiors business.',
                'client' => 'Jaipur Marble Studio',
                'industry' => 'Interiors',
                'duration' => '6 weeks',
                'engagement' => 'Website redesign + inquiry funnel',
                'featured_image' => 'assets/legacy/work-2.jpg',
                'services' => ['Web Development', 'UI/UX Design', 'Lead Capture'],
                'stack' => ['Laravel', 'Blade', 'TailwindCSS'],
                'challenge' => 'The business depended on WhatsApp and referrals, but its website did not communicate premium work clearly enough to support higher-value inquiries.',
                'solution' => 'We rebuilt the site around stronger portfolio presentation, clearer contact paths, and location-aware inquiry prompts for residential and commercial projects.',
                'outcome' => 'The team got a cleaner stream of qualified inquiries and a website that felt aligned with the quality of their offline work.',
                'results' => ['Improved visual trust', 'More structured inquiries', 'Cleaner mobile browsing for local visitors'],
                'metrics' => ['Higher inquiry quality', 'Stronger project presentation', 'Faster follow-up context'],
                'quote' => 'Clients started referencing specific projects from the website before calling us. That did not happen earlier.',
                'quote_author' => 'Co-Founder',
                'is_published' => true,
            ],
            [
                'title' => 'Digitising Appointment Flow for a Local Dental Clinic',
                'slug' => 'uday-dental-clinic-appointments',
                'summary' => 'A clearer appointment and patient-inquiry flow for a growing clinic in Udaipur.',
                'client' => 'Uday Dental Clinic',
                'industry' => 'Healthcare',
                'duration' => '5 weeks',
                'engagement' => 'Website + booking inquiry workflow',
                'featured_image' => 'assets/legacy/software.png',
                'services' => ['Web Development', 'CRM', 'Automation'],
                'stack' => ['Laravel', 'Alpine.js', 'MySQL'],
                'challenge' => 'Calls, appointment requests, and follow-ups were handled manually, which made it harder for staff to respond consistently during busy hours.',
                'solution' => 'We introduced a simpler inquiry structure, staff-friendly intake screens, and better categorisation for treatment-related requests.',
                'outcome' => 'The clinic got a more reliable intake flow and a website that reduced confusion for first-time patients.',
                'results' => ['Cleaner inquiry routing', 'Better patient confidence', 'Less front-desk back-and-forth'],
                'metrics' => ['More complete inquiry details', 'Fewer missed requests', 'Improved response consistency'],
                'quote' => 'Patients now send clearer requests, and our team spends less time figuring out what they actually need.',
                'quote_author' => 'Clinic Manager',
                'is_published' => true,
            ],
            [
                'title' => 'Modernising a Boutique CA Firm’s Website Presence',
                'slug' => 'saraf-and-co-trust-refresh',
                'summary' => 'A trust-first redesign for a chartered accountant firm serving Jaipur and nearby districts.',
                'client' => 'Saraf & Co. Advisors',
                'industry' => 'Professional Services',
                'duration' => '4 weeks',
                'engagement' => 'Website refresh + service positioning',
                'featured_image' => 'assets/legacy/work-1.jpg',
                'services' => ['Web Development', 'Content Structuring', 'UI/UX Design'],
                'stack' => ['Blade', 'TailwindCSS', 'JavaScript'],
                'challenge' => 'The previous site looked dated and made serious advisory work feel generic, especially for visitors comparing firms online.',
                'solution' => 'We restructured the service pages, clarified industry expertise, and designed a more premium interface with stronger contact trust signals.',
                'outcome' => 'The firm gained a cleaner digital presence that better reflected its professionalism and improved first-contact confidence.',
                'results' => ['Sharper credibility signals', 'Clearer service communication', 'More polished first impression'],
                'metrics' => ['Improved trust perception', 'Faster service discovery', 'More direct inquiries'],
                'quote' => 'The new site feels closer to how we actually present ourselves in meetings. That alignment matters.',
                'quote_author' => 'Partner',
                'is_published' => true,
            ],
        ] as $caseStudyRecord) {
            CaseStudy::query()->updateOrCreate(
                ['slug' => $caseStudyRecord['slug']],
                $caseStudyRecord
            );
        }

        foreach ([
            [
                'title' => 'Why Local Service Businesses Lose Leads on Slow, Generic Websites',
                'slug' => 'why-local-service-business-websites-lose-leads',
                'excerpt' => 'What we keep seeing on local business websites across Jaipur, Udaipur, and nearby markets, and what to fix first.',
                'body' => <<<'HTML'
<p>Many local businesses do not have a traffic problem first. They have a clarity problem. Visitors land on the site, do not understand what the business specialises in, and then leave or send low-quality inquiries.</p>
<p>The common issues are simple: weak service hierarchy, outdated visuals, missing trust markers, poor mobile browsing, and contact forms that ask the wrong questions.</p>
<p>For local businesses, the website should do three things well: communicate expertise fast, build trust quickly, and guide the visitor into one clear next step. When those three things improve, the quality of inquiries usually improves with them.</p>
<p>The goal is not to make the site flashy. The goal is to make the business easier to trust.</p>
HTML,
                'cover_image' => 'assets/legacy/work-2.jpg',
                'seo_title' => 'Why Local Business Websites Lose Leads',
                'seo_description' => 'A practical note on why many local service business websites underperform and what improves inquiry quality.',
                'is_published' => true,
                'published_at' => now()->subDays(18),
            ],
            [
                'title' => 'How We Structure Website Content for Clinics, Advisors, and Interior Brands',
                'slug' => 'how-we-structure-website-content-for-local-businesses',
                'excerpt' => 'A simple framework for writing clearer service pages when the buyer needs trust before they need detail.',
                'body' => <<<'HTML'
<p>Different businesses need different positioning, but the content structure is often surprisingly similar. A clinic needs confidence. A CA firm needs credibility. An interiors business needs proof of taste and delivery quality.</p>
<p>We usually start by clarifying the offer, then mapping the most important objections, and then turning those into page sections. That gives the business a website that reads like a guided conversation instead of a generic brochure.</p>
<p>For most local businesses, the strongest pages are not the longest ones. They are the clearest ones.</p>
HTML,
                'cover_image' => 'assets/legacy/work-1.jpg',
                'seo_title' => 'Website Content Structure for Local Businesses',
                'seo_description' => 'How we shape clearer service-page content for local businesses that sell on trust and credibility.',
                'is_published' => true,
                'published_at' => now()->subDays(12),
            ],
            [
                'title' => 'What Better Inquiry Forms Actually Do for Growing Businesses',
                'slug' => 'what-better-inquiry-forms-do-for-growing-businesses',
                'excerpt' => 'Better forms do not just collect data. They improve follow-up quality, internal speed, and lead confidence.',
                'body' => <<<'HTML'
<p>Most contact forms either ask too little or far too much. The best inquiry forms create just enough structure to help the business respond with context.</p>
<p>For service businesses, that usually means collecting the type of requirement, approximate scope, location, urgency, and a short note. Those small changes reduce back-and-forth and help teams prioritise faster.</p>
<p>When the form is clearer, the internal response is usually clearer too. That is where conversion often improves.</p>
HTML,
                'cover_image' => 'assets/legacy/software.png',
                'seo_title' => 'Why Better Inquiry Forms Matter',
                'seo_description' => 'A short practical guide to improving inquiry forms for better lead quality and faster follow-up.',
                'is_published' => true,
                'published_at' => now()->subDays(9),
            ],
            [
                'title' => 'A Practical Way to Modernise a Business Website Without Overbuilding It',
                'slug' => 'modernise-a-business-website-without-overbuilding',
                'excerpt' => 'You do not need a heavy rebuild to improve trust, clarity, and inquiry quality. You need the right fixes in the right order.',
                'body' => <<<'HTML'
<p>Website improvement does not always begin with a full rebuild. In many cases, the first gains come from cleaner page hierarchy, better imagery, mobile fixes, stronger service positioning, and a more confident contact path.</p>
<p>That matters especially for growing local businesses that want a more premium presence but do not need complexity for its own sake.</p>
<p>Modernisation works best when design, content, and conversion flow are handled together instead of as separate tasks.</p>
HTML,
                'cover_image' => 'assets/legacy/work-3.jpg',
                'seo_title' => 'Modernise a Business Website Without Overbuilding It',
                'seo_description' => 'A practical note on improving a business website without unnecessary complexity or overengineering.',
                'is_published' => true,
                'published_at' => now()->subDays(5),
            ],
        ] as $postRecord) {
            BlogPost::query()->updateOrCreate(
                ['slug' => $postRecord['slug']],
                $postRecord + ['author_id' => $authorId]
            );
        }
    }
}
