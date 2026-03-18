<?php

namespace Database\Seeders;

use App\Models\CMS\BlogPost;
use App\Models\CMS\CaseStudy;
use App\Models\CMS\PortfolioProject;
use App\Models\Store\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class DemoLocalBusinessContentSeeder extends Seeder
{
    public function run(): void
    {
        $authorId = User::query()->orderBy('id')->value('id');

        foreach ($this->products() as $product) {
            Product::query()->updateOrCreate(
                ['slug' => $product['slug']],
                $product
            );
        }

        foreach ($this->projects() as $project) {
            PortfolioProject::query()->updateOrCreate(
                ['slug' => $project['slug']],
                $project
            );
        }

        foreach ($this->caseStudies() as $caseStudy) {
            CaseStudy::query()->updateOrCreate(
                ['slug' => $caseStudy['slug']],
                $caseStudy
            );
        }

        foreach ($this->blogPosts($authorId) as $post) {
            BlogPost::query()->updateOrCreate(
                ['slug' => $post['slug']],
                $post
            );
        }
    }

    private function products(): array
    {
        return [
            [
                'name' => 'Local Business Website Starter',
                'slug' => 'local-business-website-starter',
                'short_description' => 'A clean website starter for clinics, advisors, boutiques, and service brands in growing city markets.',
                'description' => 'A practical website foundation with homepage, services, about, testimonials, contact flow, and SEO-ready structure. Suitable for local businesses that want a more premium first impression without overbuilding the stack.',
                'cover_image' => 'assets/legacy/work-1.jpg',
                'status' => 'published',
                'currency' => 'INR',
                'price_paise' => 349900,
                'meta' => [
                    'category' => 'Website',
                    'tags' => ['local business', 'website', 'lead generation'],
                    'highlights' => [
                        'Premium homepage + service pages',
                        'Mobile-friendly contact flow',
                        'SEO-friendly page structure',
                    ],
                    'best_for' => ['Clinics', 'CA firms', 'Interior studios', 'Coaching brands'],
                ],
            ],
            [
                'name' => 'Clinic Inquiry & Booking System',
                'slug' => 'clinic-inquiry-booking-system',
                'short_description' => 'A lightweight patient inquiry and appointment intake system for local clinics.',
                'description' => 'Built for clinics that want cleaner appointment capture, better inquiry detail, and a more trustworthy patient experience across mobile and desktop.',
                'cover_image' => 'assets/legacy/software.png',
                'status' => 'published',
                'currency' => 'INR',
                'price_paise' => 499900,
                'meta' => [
                    'category' => 'Healthcare',
                    'tags' => ['clinic', 'appointments', 'crm'],
                    'highlights' => [
                        'Structured inquiry intake',
                        'Patient-friendly booking experience',
                        'Staff-side follow-up visibility',
                    ],
                ],
            ],
            [
                'name' => 'Professional Services Trust Pack',
                'slug' => 'professional-services-trust-pack',
                'short_description' => 'A trust-first website pack for advisors, firms, and local consultancies.',
                'description' => 'Designed for service businesses that sell on credibility. Includes practice-area pages, team credibility sections, inquiry prompts, and a more polished brand presentation.',
                'cover_image' => 'assets/legacy/work-2.jpg',
                'status' => 'published',
                'currency' => 'INR',
                'price_paise' => 289900,
                'meta' => [
                    'category' => 'Professional Services',
                    'tags' => ['trust', 'services', 'advisory'],
                    'highlights' => [
                        'Trust-oriented UI sections',
                        'Stronger service presentation',
                        'Clearer inquiry prompts',
                    ],
                ],
            ],
            [
                'name' => 'WhatsApp Lead Capture Mini Suite',
                'slug' => 'whatsapp-lead-capture-mini-suite',
                'short_description' => 'A lightweight lead capture and follow-up setup for businesses that rely on WhatsApp conversations.',
                'description' => 'Ideal for local businesses that get first contact through WhatsApp. Includes structured inquiry capture, qualification prompts, and admin visibility for follow-ups.',
                'cover_image' => 'assets/images/whatsapp-automation-hero.svg',
                'status' => 'published',
                'currency' => 'INR',
                'price_paise' => 219900,
                'meta' => [
                    'category' => 'Automation',
                    'tags' => ['whatsapp', 'lead capture', 'automation'],
                    'highlights' => [
                        'Lead capture prompts',
                        'Clean staff follow-up view',
                        'Better inquiry context',
                    ],
                ],
            ],
        ];
    }

    private function projects(): array
    {
        return [
            [
                'title' => 'Anandi Dental Care',
                'slug' => 'anandi-dental-care',
                'category' => 'Clinic Website',
                'client_name' => 'Anandi Dental Care',
                'industry' => 'Healthcare',
                'featured_image' => 'assets/legacy/work-3.jpg',
                'project_url' => null,
                'summary' => 'A cleaner clinic website with inquiry routing, treatment pages, and patient-first mobile clarity.',
                'body' => 'Designed for a growing city clinic that needed a more credible first impression and a simpler appointment inquiry flow for mobile visitors.',
                'stack' => ['Laravel', 'Blade', 'TailwindCSS'],
                'metrics' => ['Clearer mobile browsing', 'Better inquiry quality', 'Stronger trust signals'],
                'challenge' => 'The previous website looked outdated and gave patients very little clarity on treatments, clinic credibility, or how to enquire properly.',
                'solution' => 'We rebuilt the experience around trust-first sections, treatment clarity, doctor credibility, and a simpler inquiry journey.',
                'outcome' => 'The clinic gained a stronger digital first impression and better-structured inquiry flow for new patients.',
                'is_published' => true,
            ],
            [
                'title' => 'Sundaram Marble & Interiors',
                'slug' => 'sundaram-marble-interiors',
                'category' => 'Portfolio Website',
                'client_name' => 'Sundaram Marble & Interiors',
                'industry' => 'Interiors',
                'featured_image' => 'assets/legacy/work-1.jpg',
                'project_url' => null,
                'summary' => 'A premium local-business portfolio website for residential and commercial interior work.',
                'body' => 'Built to help a small-city interiors brand present completed projects better and qualify higher-value inquiries.',
                'stack' => ['Blade', 'TailwindCSS', 'JavaScript'],
                'metrics' => ['Sharper project presentation', 'Premiumer visual trust', 'More complete inquiries'],
                'challenge' => 'The business had strong offline referrals but weak digital proof, making premium work harder to sell online.',
                'solution' => 'We focused on portfolio presentation, service clarity, locality trust signals, and a stronger inquiry form.',
                'outcome' => 'The website became a more effective sales asset instead of a passive brochure.',
                'is_published' => true,
            ],
            [
                'title' => 'Mohan Tax & Advisory',
                'slug' => 'mohan-tax-advisory',
                'category' => 'Professional Services Website',
                'client_name' => 'Mohan Tax & Advisory',
                'industry' => 'Professional Services',
                'featured_image' => 'assets/legacy/work-2.jpg',
                'project_url' => null,
                'summary' => 'A trust-focused web presence for a tax and compliance advisory firm.',
                'body' => 'Structured to communicate credibility, service scope, and enquiry confidence for a local advisory practice.',
                'stack' => ['Laravel', 'TailwindCSS'],
                'metrics' => ['Better service discovery', 'Higher trust first impression', 'Stronger local credibility'],
                'challenge' => 'The firm needed a website that felt more serious and credible to business owners comparing multiple advisors online.',
                'solution' => 'We introduced clearer service sections, partner credibility blocks, and more deliberate consultation prompts.',
                'outcome' => 'The firm’s digital presence became more aligned with the quality of its real-world consulting work.',
                'is_published' => true,
            ],
            [
                'title' => 'CityHost Billing Flow',
                'slug' => 'cityhost-billing-flow',
                'category' => 'Hosting Journey',
                'client_name' => 'CityHost',
                'industry' => 'Hosting',
                'featured_image' => 'assets/legacy/software.png',
                'project_url' => null,
                'summary' => 'A branded hosting journey that makes plans easier to compare before handing off into billing.',
                'body' => 'A hosting and billing experience designed for a regional hosting provider that wanted stronger plan clarity and more branded trust.',
                'stack' => ['Laravel', 'WHMCS', 'Blade'],
                'metrics' => ['Cleaner plan comparison', 'Better billing handoff', 'Stronger storefront credibility'],
                'challenge' => 'The original hosting journey felt generic and did not support confident plan comparison for small-business buyers.',
                'solution' => 'We introduced a cleaner offer hierarchy, benefit framing, and a more polished handoff into WHMCS.',
                'outcome' => 'The storefront became more usable and the hosting offer looked more credible to first-time buyers.',
                'is_published' => true,
            ],
        ];
    }

    private function caseStudies(): array
    {
        return [
            [
                'title' => 'Improving Inquiry Quality for a Neighbourhood Clinic',
                'slug' => 'improving-inquiry-quality-for-a-neighbourhood-clinic',
                'summary' => 'How a local clinic in a tier-2 city improved trust and inquiry quality with a clearer digital front.',
                'client' => 'Anandi Dental Care',
                'industry' => 'Healthcare',
                'duration' => '5 weeks',
                'engagement' => 'Website refresh + inquiry flow',
                'featured_image' => 'assets/legacy/work-3.jpg',
                'services' => ['Web Development', 'UI/UX Design', 'Lead Capture'],
                'stack' => ['Laravel', 'Blade', 'TailwindCSS'],
                'challenge' => 'Patients were landing on the site but not getting enough confidence or treatment clarity to submit structured requests.',
                'solution' => 'We redesigned the site around doctor trust, treatment pages, mobile usability, and a more practical inquiry structure.',
                'outcome' => 'The clinic received more useful inquiries and a stronger first impression for new patients evaluating options online.',
                'results' => ['Better inquiry detail', 'Improved patient trust', 'Cleaner mobile usability'],
                'metrics' => ['More complete inquiries', 'Less front-desk back-and-forth', 'Better credibility'],
                'quote' => 'We started getting better inquiries, not just more form submissions. That made the difference.',
                'quote_author' => 'Clinic Coordinator',
                'is_published' => true,
            ],
            [
                'title' => 'Turning Local Portfolio Traffic into Real Project Leads',
                'slug' => 'turning-local-portfolio-traffic-into-real-project-leads',
                'summary' => 'A small-city interiors business needed a website that reflected the quality of its finished work.',
                'client' => 'Sundaram Marble & Interiors',
                'industry' => 'Interiors',
                'duration' => '6 weeks',
                'engagement' => 'Portfolio website + lead flow',
                'featured_image' => 'assets/legacy/work-1.jpg',
                'services' => ['Portfolio Design', 'Web Development', 'Lead Management'],
                'stack' => ['Blade', 'TailwindCSS', 'JavaScript'],
                'challenge' => 'The business had strong word-of-mouth demand, but its old site did not justify premium pricing or showcase completed work properly.',
                'solution' => 'We restructured the site around project imagery, category-led browsing, and stronger enquiry prompts for home and commercial work.',
                'outcome' => 'The brand got a digital presence that matched the quality of its real projects and improved lead seriousness.',
                'results' => ['Premium project presentation', 'Improved trust', 'Better lead qualification'],
                'metrics' => ['Stronger enquiry quality', 'Faster portfolio scanning', 'Clearer service positioning'],
                'quote' => 'People began mentioning exact project references from the site before visiting our office.',
                'quote_author' => 'Founder',
                'is_published' => true,
            ],
            [
                'title' => 'Building Trust for a Local Advisory Practice',
                'slug' => 'building-trust-for-a-local-advisory-practice',
                'summary' => 'How a chartered-accountancy style advisory practice modernised its web presence without becoming too corporate.',
                'client' => 'Mohan Tax & Advisory',
                'industry' => 'Professional Services',
                'duration' => '4 weeks',
                'engagement' => 'Website repositioning + trust design',
                'featured_image' => 'assets/legacy/work-2.jpg',
                'services' => ['Web Design', 'Content Structuring', 'Conversion UX'],
                'stack' => ['Laravel', 'Blade'],
                'challenge' => 'The previous site looked dated and generic, which weakened trust among business owners comparing multiple firms.',
                'solution' => 'We clarified service structure, added stronger trust content, and made the consultation path feel more deliberate.',
                'outcome' => 'The firm’s website now reflects the professionalism clients expect before they make contact.',
                'results' => ['Sharper credibility', 'Improved first impression', 'Better consultation flow'],
                'metrics' => ['More direct enquiries', 'Stronger service clarity', 'Higher trust perception'],
                'quote' => 'The new site finally feels aligned with the kind of advisory work we do.',
                'quote_author' => 'Managing Partner',
                'is_published' => true,
            ],
        ];
    }

    private function blogPosts(?int $authorId): array
    {
        return [
            [
                'title' => 'Why Small-City Businesses Lose Good Leads on Generic Websites',
                'slug' => 'why-small-city-businesses-lose-good-leads-on-generic-websites',
                'excerpt' => 'A premium-looking website is not just about aesthetics. It directly affects how seriously local buyers treat your business.',
                'body' => <<<'HTML'
<p>Many local businesses in cities like Jaipur, Ajmer, Kota, and Udaipur do not actually have a traffic problem first. They have a clarity problem. People land on the site, do not understand the specialisation quickly enough, and leave without taking the next step.</p>
<p>The most common issues are weak service structure, poor mobile readability, missing trust signals, outdated imagery, and contact forms that collect almost no useful context.</p>
<p>If the business depends on trust, referrals, and higher-value enquiries, the website has to communicate quality before the first phone call. That means cleaner design, better page structure, and more deliberate enquiry flow.</p>
HTML,
                'cover_image' => 'assets/legacy/work-2.jpg',
                'seo_title' => 'Why Small-City Businesses Lose Leads on Generic Websites',
                'seo_description' => 'A practical note on how generic websites reduce trust and inquiry quality for local service businesses.',
                'is_published' => true,
                'published_at' => now()->subDays(14),
                'author_id' => $authorId,
            ],
            [
                'title' => 'What a Better Clinic Website Should Actually Do',
                'slug' => 'what-a-better-clinic-website-should-actually-do',
                'excerpt' => 'For clinics, the website should reduce confusion, improve trust, and make appointment enquiries easier to handle.',
                'body' => <<<'HTML'
<p>A clinic website does not need to be overloaded with features. It needs to answer the right questions quickly: who the doctors are, what treatments are offered, how patients should enquire, and why the clinic is trustworthy.</p>
<p>When those basics are missing, front-desk teams spend too much time clarifying requests that the website should have handled better.</p>
<p>The strongest clinic websites simplify the first step and support the staff behind it.</p>
HTML,
                'cover_image' => 'assets/legacy/work-3.jpg',
                'seo_title' => 'What a Better Clinic Website Should Do',
                'seo_description' => 'A practical guide to structuring a better clinic website for trust, clarity, and appointment enquiries.',
                'is_published' => true,
                'published_at' => now()->subDays(10),
                'author_id' => $authorId,
            ],
            [
                'title' => 'How Local Interior Brands Can Present Premium Work Online',
                'slug' => 'how-local-interior-brands-can-present-premium-work-online',
                'excerpt' => 'If the work is premium but the website feels generic, buyers notice the mismatch immediately.',
                'body' => <<<'HTML'
<p>Interior and marble businesses often depend on real project quality, but their websites do not present that work with the same care. The result is a brand mismatch: good execution offline, weak perception online.</p>
<p>Better portfolio structure, stronger project categorisation, and more thoughtful enquiry prompts can change how visitors judge the business within seconds.</p>
<p>For local premium categories, presentation is part of conversion.</p>
HTML,
                'cover_image' => 'assets/legacy/work-1.jpg',
                'seo_title' => 'How Local Interior Brands Should Present Premium Work Online',
                'seo_description' => 'A short guide to improving portfolio presentation and lead quality for local interiors businesses.',
                'is_published' => true,
                'published_at' => now()->subDays(7),
                'author_id' => $authorId,
            ],
            [
                'title' => 'Why Better Inquiry Forms Improve Follow-Up Quality',
                'slug' => 'why-better-inquiry-forms-improve-follow-up-quality',
                'excerpt' => 'A better enquiry form does not just collect data. It helps the team respond with better context.',
                'body' => <<<'HTML'
<p>Most forms ask either too little or too much. The right form captures enough detail to support faster, better follow-up without creating friction.</p>
<p>That usually means collecting service type, location, rough scope, urgency, and one short note. Those details help the team prioritise and reply more intelligently.</p>
<p>For growing businesses, form quality affects internal speed almost as much as conversion quality.</p>
HTML,
                'cover_image' => 'assets/legacy/software.png',
                'seo_title' => 'Why Better Inquiry Forms Improve Follow-Up Quality',
                'seo_description' => 'How enquiry form structure improves lead quality and internal follow-up speed for growing businesses.',
                'is_published' => true,
                'published_at' => now()->subDays(3),
                'author_id' => $authorId,
            ],
        ];
    }
}
