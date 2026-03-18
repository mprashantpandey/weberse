<?php

namespace Database\Seeders;

use App\Enums\LeadStage;
use App\Enums\UserRole;
use App\Models\ClientDocument;
use App\Models\CMS\BlogPost;
use App\Models\CMS\CaseStudy;
use App\Models\CMS\PortfolioProject;
use App\Models\CMS\Service;
use App\Models\CMS\SiteSetting;
use App\Models\CMS\Testimonial;
use App\Models\Communication\EmailTemplate;
use App\Models\Communication\NewsletterCampaign;
use App\Models\Communication\NewsletterSubscriber;
use App\Models\CRM\Contact;
use App\Models\CRM\Lead;
use App\Models\CRM\LeadNote;
use App\Models\HRM\Department;
use App\Models\HRM\CompensationRecord;
use App\Models\HRM\EmployeeProfile;
use App\Models\HRM\EmployeePerk;
use App\Models\HRM\ExpenseClaim;
use App\Models\HRM\InterviewSchedule;
use App\Models\HRM\JobApplication;
use App\Models\HRM\JobOpening;
use App\Models\Support\SupportDepartment;
use App\Models\Support\SupportReply;
use App\Models\Support\SupportTicket;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        foreach (UserRole::values() as $role) {
            Role::findOrCreate($role, 'web');
        }

        $admin = User::query()->updateOrCreate(
            ['email' => 'admin@weberse.test'],
            [
                'name' => 'Weberse Admin',
                'job_title' => 'Platform Administrator',
                'password' => Hash::make('password'),
                'is_active' => true,
            ]
        );
        $admin->assignRole(UserRole::Admin->value);

        $sales = User::query()->updateOrCreate(
            ['email' => 'sales@weberse.test'],
            [
                'name' => 'Sales Manager',
                'password' => Hash::make('password'),
                'is_active' => true,
            ]
        );
        $sales->assignRole(UserRole::Sales->value);

        $hr = User::query()->updateOrCreate(
            ['email' => 'hr@weberse.test'],
            [
                'name' => 'HR Manager',
                'password' => Hash::make('password'),
                'is_active' => true,
            ]
        );
        $hr->assignRole(UserRole::HR->value);

        $support = User::query()->updateOrCreate(
            ['email' => 'support@weberse.test'],
            [
                'name' => 'Support Agent',
                'password' => Hash::make('password'),
                'is_active' => true,
            ]
        );
        $support->assignRole(UserRole::Support->value);

        $client = User::query()->updateOrCreate(
            ['email' => 'client@weberse.test'],
            [
                'name' => 'Client User',
                'whmcs_client_id' => 1001,
                'password' => Hash::make('password'),
                'is_active' => true,
            ]
        );
        $client->assignRole(UserRole::Client->value);

        SiteSetting::query()->updateOrCreate(
            ['key' => 'company_profile'],
            [
                'group' => 'branding',
                'value' => [
                    'company' => 'Weberse Infotech Private Limited',
                    'tagline' => 'Innovating Intelligence. Building the Future.',
                    'email' => 'hello@weberse.com',
                    'phone' => '+91 98765 43210',
                    'socials' => [
                        'linkedin' => 'https://linkedin.com/company/weberse',
                        'instagram' => 'https://instagram.com/weberse',
                    ],
                ],
                'type' => 'json',
                'is_public' => true,
            ]
        );

        $this->call(EmailTemplateSeeder::class);
        $this->call(StoreProductSeeder::class);

        NewsletterSubscriber::query()->insert([
            [
                'name' => 'Ritika Jain',
                'email' => 'ritika@example.test',
                'status' => 'active',
                'source' => 'website_footer',
                'subscribed_at' => now()->subDays(8),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Arjun Soni',
                'email' => 'arjun@example.test',
                'status' => 'active',
                'source' => 'admin',
                'subscribed_at' => now()->subDays(3),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        NewsletterCampaign::query()->create([
            'email_template_id' => EmailTemplate::query()->where('slug', 'newsletter-base-template')->value('id'),
            'title' => 'March Product & Delivery Update',
            'subject' => 'March updates from Weberse',
            'body' => "Hello {{name}},\n\nThis month at Weberse we refined our service pages, expanded HRM, and improved operational tooling.\n\nMore updates soon.\n\nRegards,\nWeberse Infotech",
            'status' => 'draft',
            'target_segment' => 'all_active',
        ]);

        Service::query()->insert([
            ['title' => 'Web Development', 'slug' => 'web-development', 'summary' => 'Custom Laravel, React, and commerce platforms.', 'body' => 'We build scalable digital products for growing businesses.', 'icon' => 'layout', 'is_published' => true, 'sort_order' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Cloud Hosting', 'slug' => 'cloud-hosting', 'summary' => 'Managed hosting and server operations integrated with WHMCS.', 'body' => 'Hosting services are provisioned and billed through WHMCS.', 'icon' => 'server', 'is_published' => true, 'sort_order' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'AI Automation', 'slug' => 'ai-automation', 'summary' => 'Practical AI workflows for support and operations.', 'body' => 'We focus on practical intelligence, not novelty.', 'icon' => 'sparkles', 'is_published' => true, 'sort_order' => 3, 'created_at' => now(), 'updated_at' => now()],
        ]);

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
                'created_at' => now(),
                'updated_at' => now(),
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
                'created_at' => now(),
                'updated_at' => now(),
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
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ] as $projectRecord) {
            PortfolioProject::query()->updateOrCreate(
                ['slug' => $projectRecord['slug']],
                $projectRecord
            );
        }

        foreach ([
            [
                'title' => 'Scaling a Modern Hosting Brand',
                'slug' => 'scaling-a-modern-hosting-brand',
                'summary' => 'How a fragmented hosting offer was restructured into a cleaner branded funnel.',
                'client' => 'CloudHarbor Hosting',
                'industry' => 'Hosting',
                'duration' => '8 weeks',
                'engagement' => 'Website redesign + hosting funnel',
                'featured_image' => 'assets/legacy/work-2.jpg',
                'services' => ['Web Development', 'UI/UX Design', 'WHMCS Integration'],
                'stack' => ['Laravel', 'Blade', 'TailwindCSS', 'WHMCS'],
                'challenge' => 'Low trust, weak differentiation, and multiple disconnected purchase paths.',
                'solution' => 'Introduced a focused marketing site, service positioning, and a branded handoff to WHMCS.',
                'outcome' => 'The hosting offer became easier to understand, the brand looked more credible, and the billing journey felt consistent from first click to checkout.',
                'results' => ['Clearer service navigation', 'Higher trust visual language', 'Better handoff into checkout'],
                'metrics' => ['Stronger buyer trust', 'Cleaner hosting plans', 'More coherent billing journey'],
                'quote' => 'The commercial story finally felt clear. Prospects understood the plans faster and the transition into billing no longer felt like a separate product.',
                'quote_author' => 'Operations Lead',
                'is_published' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Building an Internal Ops Platform',
                'slug' => 'building-an-internal-ops-platform',
                'summary' => 'Replacing scattered tools with a modular system for leads, hiring, and support.',
                'client' => 'Vertex Commerce',
                'industry' => 'Operations',
                'duration' => '12 weeks',
                'engagement' => 'Internal platform build',
                'featured_image' => 'assets/legacy/software.png',
                'services' => ['Custom Software Development', 'CRM', 'Client Portal'],
                'stack' => ['Laravel', 'Alpine.js', 'PostgreSQL', 'Redis'],
                'challenge' => 'The team lacked one controlled view of business operations.',
                'solution' => 'Designed a modular Laravel platform with CMS, CRM, HRM, support, and portal workflows.',
                'outcome' => 'The business moved from disconnected tools into a single operating surface with clearer ownership, cleaner data flow, and better visibility for staff and clients.',
                'results' => ['Fewer disconnected processes', 'Better role visibility', 'Cleaner client experience'],
                'metrics' => ['Unified internal views', 'Role-based visibility', 'Less tool fragmentation'],
                'quote' => 'Instead of juggling disconnected tools, the team now works from one structured workspace. That improved internal speed almost immediately.',
                'quote_author' => 'Founder',
                'is_published' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ] as $caseStudyRecord) {
            CaseStudy::query()->updateOrCreate(
                ['slug' => $caseStudyRecord['slug']],
                $caseStudyRecord
            );
        }

        BlogPost::query()->create([
            'author_id' => $admin->id,
            'title' => 'How Weberse Builds Integrated Digital Platforms',
            'slug' => 'how-weberse-builds-integrated-platforms',
            'excerpt' => 'A practical view on consolidating company systems without overengineering.',
            'body' => 'This platform follows a modular Laravel architecture with clear service boundaries.',
            'is_published' => true,
            'published_at' => now()->subDays(2),
        ]);

        Testimonial::query()->create([
            'name' => 'Amit Verma',
            'company' => 'Vertex Commerce',
            'quote' => 'Weberse brought our website, lead intake, and client support into one disciplined platform.',
            'is_published' => true,
        ]);

        $contact = Contact::query()->create([
            'name' => 'Priya Sharma',
            'email' => 'priya@vertex.test',
            'phone' => '+91 99999 11111',
            'company' => 'Vertex Commerce',
            'designation' => 'Director',
        ]);

        $lead = Lead::query()->create([
            'contact_id' => $contact->id,
            'owner_id' => $sales->id,
            'title' => 'Managed hosting and website revamp',
            'source' => 'website_form',
            'stage' => LeadStage::Contacted->value,
            'status' => 'open',
            'estimated_value' => 75000,
            'message' => 'Looking for a new website and migration from cPanel hosting.',
            'next_follow_up_at' => now()->addDays(2),
        ]);

        LeadNote::query()->create([
            'lead_id' => $lead->id,
            'user_id' => $sales->id,
            'body' => 'Discovery call completed. Proposal requested.',
        ]);

        $engineering = Department::query()->create([
            'name' => 'Engineering',
            'description' => 'Product delivery and platform operations.',
        ]);

        $job = JobOpening::query()->create([
            'department_id' => $engineering->id,
            'title' => 'Laravel Developer',
            'slug' => 'laravel-developer',
            'location' => 'Remote / Jaipur',
            'employment_type' => 'full_time',
            'description' => 'Build internal products and client systems using Laravel and JavaScript.',
            'salary_min' => 600000,
            'salary_max' => 1200000,
            'salary_currency' => 'INR',
            'experience_min' => 2,
            'experience_max' => 5,
            'notice_period' => '30 days',
            'immediate_joiner_preferred' => true,
            'skills' => ['Laravel', 'JavaScript', 'Blade', 'MySQL', 'REST APIs'],
            'application_questions' => [
                'What production Laravel applications have you worked on recently?',
                'How do you approach maintainability when building internal systems?',
            ],
            'is_published' => true,
            'published_at' => now()->subWeek(),
        ]);

        JobApplication::query()->create([
            'job_opening_id' => $job->id,
            'name' => 'Rohan Mehta',
            'email' => 'rohan@example.test',
            'phone' => '+91 88888 22222',
            'notice_period_response' => 'Immediate',
            'application_answers' => [
                'What production Laravel applications have you worked on recently?' => 'I worked on a CRM and a support platform serving about 5k monthly active users.',
                'How do you approach maintainability when building internal systems?' => 'I keep modules separated, reduce controller logic, and write around predictable workflows.',
            ],
            'status' => 'screening',
            'interview_status' => 'scheduled',
        ]);

        $employee = EmployeeProfile::query()->create([
            'user_id' => $hr->id,
            'department_id' => $engineering->id,
            'employee_code' => 'WEB-001',
            'join_date' => now()->subMonths(8)->toDateString(),
            'employment_status' => 'active',
            'documents' => ['nda.pdf'],
        ]);

        $application = JobApplication::query()->first();

        InterviewSchedule::query()->create([
            'job_application_id' => $application->id,
            'scheduled_by' => $admin->id,
            'interviewer_name' => 'Aman Gupta',
            'interviewer_email' => 'aman@weberse.test',
            'mode' => 'video',
            'meeting_link' => 'https://meet.google.com/demo-weberse-interview',
            'scheduled_for' => now()->addDays(2)->setTime(15, 0),
            'duration_minutes' => 45,
            'stage' => 'technical',
            'status' => 'scheduled',
            'notes' => 'Please be ready to discuss Laravel architecture and API design.',
        ]);

        CompensationRecord::query()->create([
            'employee_profile_id' => $employee->id,
            'title' => 'Monthly Salary',
            'pay_type' => 'monthly_salary',
            'amount' => 85000,
            'currency' => 'INR',
            'effective_from' => now()->subMonths(4)->toDateString(),
            'status' => 'active',
            'notes' => 'Current fixed monthly compensation.',
        ]);

        ExpenseClaim::query()->create([
            'employee_profile_id' => $employee->id,
            'submitted_by' => $hr->id,
            'approved_by' => $admin->id,
            'title' => 'Home office internet reimbursement',
            'category' => 'utilities',
            'amount' => 2200,
            'currency' => 'INR',
            'expense_date' => now()->subDays(10)->toDateString(),
            'status' => 'approved',
            'processed_at' => now()->subDays(5),
            'notes' => 'Monthly reimbursement.',
        ]);

        EmployeePerk::query()->create([
            'employee_profile_id' => $employee->id,
            'title' => 'Health Insurance',
            'perk_type' => 'benefit',
            'value' => 'Family cover',
            'status' => 'active',
            'starts_on' => now()->subMonths(6)->toDateString(),
            'notes' => 'Corporate medical plan.',
        ]);

        $supportDepartment = SupportDepartment::query()->create([
            'name' => 'Technical Support',
            'email' => 'support@weberse.test',
            'description' => 'Hosting and application support.',
            'is_active' => true,
        ]);

        $ticket = SupportTicket::query()->create([
            'user_id' => $client->id,
            'department_id' => $supportDepartment->id,
            'assigned_to' => $support->id,
            'subject' => 'Need access to hosting dashboard',
            'priority' => 'medium',
            'status' => 'open',
            'message' => 'Please confirm where to manage DNS and invoices.',
        ]);

        SupportReply::query()->create([
            'support_ticket_id' => $ticket->id,
            'user_id' => $support->id,
            'message' => 'Use the client portal overview or jump directly to the WHMCS billing subdomain.',
            'is_internal' => false,
        ]);

        ClientDocument::query()->create([
            'user_id' => $client->id,
            'title' => 'Master Service Agreement',
            'file_path' => 'documents/master-service-agreement.pdf',
            'visibility' => 'client',
            'notes' => 'Signed agreement copy.',
        ]);
    }
}
