<?php

namespace Database\Seeders;

use App\Models\Communication\EmailTemplate;
use Illuminate\Database\Seeder;

class EmailTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $templates = [
            [
                'name' => 'Application Received - Candidate',
                'slug' => 'application-received-candidate',
                'category' => 'hr',
                'subject' => 'We received your application for {{job_title}}',
                'body' => "Hello {{name}},\n\nWe have received your application for {{job_title}} in the {{department}} team.\n\nOur HR team will review your profile and contact you with the next update.\n\nRegards,\nWeberse Infotech",
                'description' => 'Sent to candidates after a successful application.',
                'is_active' => true,
            ],
            [
                'name' => 'Application Received - Internal',
                'slug' => 'application-received-internal',
                'category' => 'hr',
                'subject' => 'New application: {{candidate_name}} for {{job_title}}',
                'body' => "A new application has been received.\n\nCandidate: {{candidate_name}}\nEmail: {{candidate_email}}\nRole: {{job_title}}\nDepartment: {{department}}\nNotice period: {{notice_period}}",
                'description' => 'Sent to HR/Admin when a new application is submitted.',
                'is_active' => true,
            ],
            [
                'name' => 'Interview Scheduled - Candidate',
                'slug' => 'interview-scheduled-candidate',
                'category' => 'hr',
                'subject' => 'Interview scheduled for {{job_title}}',
                'body' => "Hello {{name}},\n\nYour {{stage}} interview for {{job_title}} has been scheduled on {{interview_date}}.\nInterviewer: {{interviewer_name}}\nMode: {{mode}}\nMeeting link: {{meeting_link}}\n\nRegards,\nWeberse Infotech HR Team",
                'description' => 'Sent to candidates after interview scheduling.',
                'is_active' => true,
            ],
            [
                'name' => 'Interview Scheduled - Internal',
                'slug' => 'interview-scheduled-internal',
                'category' => 'hr',
                'subject' => 'Interview scheduled: {{candidate_name}} for {{job_title}}',
                'body' => "Interview scheduled.\n\nCandidate: {{candidate_name}}\nEmail: {{candidate_email}}\nRole: {{job_title}}\nStage: {{stage}}\nDate: {{interview_date}}\nInterviewer: {{interviewer_name}}\nMeeting link: {{meeting_link}}",
                'description' => 'Sent internally after interview scheduling.',
                'is_active' => true,
            ],
            [
                'name' => 'Candidate Shortlisted',
                'slug' => 'candidate-shortlisted',
                'category' => 'hr',
                'subject' => 'Your application for {{job_title}} is moving forward',
                'body' => "Hello {{name}},\n\nThank you for applying for {{job_title}}.\n\nYour profile has been shortlisted for the next stage. Our team will share the next interview details shortly.\n\nRegards,\nWeberse Infotech HR Team",
                'description' => 'Sent when a candidate is shortlisted.',
                'is_active' => true,
            ],
            [
                'name' => 'Candidate Rejection',
                'slug' => 'candidate-rejection',
                'category' => 'hr',
                'subject' => 'Update on your application for {{job_title}}',
                'body' => "Hello {{name}},\n\nThank you for your interest in {{job_title}} at Weberse Infotech.\n\nAfter review, we are not moving ahead with your application for this role. We appreciate the time you invested and will keep your profile in mind for future openings.\n\nRegards,\nWeberse Infotech HR Team",
                'description' => 'Sent when a candidate is not selected.',
                'is_active' => true,
            ],
            [
                'name' => 'Newsletter Base Template',
                'slug' => 'newsletter-base-template',
                'category' => 'newsletter',
                'subject' => 'Weberse Updates for {{name}}',
                'body' => "Hello {{name}},\n\nHere are the latest updates from Weberse Infotech.\n\n- New case studies\n- Product delivery insights\n- Platform updates\n\nThanks,\nWeberse Infotech",
                'description' => 'Base newsletter template for campaigns and one-off mail.',
                'is_active' => true,
            ],
            [
                'name' => 'Newsletter Launch Update',
                'slug' => 'newsletter-launch-update',
                'category' => 'newsletter',
                'subject' => 'What we launched this month at Weberse',
                'body' => "Hello {{name}},\n\nThis month we shipped:\n\n- A refined marketing website\n- Cleaner admin operations\n- Hiring and communication workflows\n\nIf you want help shipping something similar, reply to this email.\n\nRegards,\nWeberse Infotech",
                'description' => 'Monthly launch and product update newsletter.',
                'is_active' => true,
            ],
            [
                'name' => 'Case Study Roundup',
                'slug' => 'newsletter-case-study-roundup',
                'category' => 'newsletter',
                'subject' => 'New case studies and delivery insights from Weberse',
                'body' => "Hello {{name}},\n\nWe have published new case studies covering:\n\n- Website conversions\n- Client portal delivery\n- Internal workflow simplification\n\nExplore the latest work and see how we structure scalable delivery.\n\nRegards,\nWeberse Infotech",
                'description' => 'Newsletter focused on portfolio and case-study updates.',
                'is_active' => true,
            ],
            [
                'name' => 'Proposal Follow-Up',
                'slug' => 'proposal-follow-up',
                'category' => 'sales',
                'subject' => 'Following up on your Weberse proposal',
                'body' => "Hello {{name}},\n\nI wanted to follow up on the proposal we shared for {{project_name}}.\n\nIf helpful, we can walk you through scope, timelines, and priorities on a short call this week.\n\nRegards,\n{{owner_name}}\nWeberse Infotech",
                'description' => 'Sales follow-up after a proposal has been shared.',
                'is_active' => true,
            ],
            [
                'name' => 'Client Onboarding Welcome',
                'slug' => 'client-onboarding-welcome',
                'category' => 'sales',
                'subject' => 'Welcome to Weberse, {{name}}',
                'body' => "Hello {{name}},\n\nWelcome aboard.\n\nYour project {{project_name}} is now being prepared for kickoff. We will share the working plan, communication channel, and first milestones shortly.\n\nRegards,\nWeberse Infotech",
                'description' => 'Sent after a new client engagement begins.',
                'is_active' => true,
            ],
            [
                'name' => 'Support Follow-Up',
                'slug' => 'support-follow-up',
                'category' => 'support',
                'subject' => 'Checking in on ticket {{ticket_number}}',
                'body' => "Hello {{name}},\n\nWe wanted to confirm whether the issue on ticket {{ticket_number}} has been fully resolved.\n\nIf you still need help, reply to this email and our support team will continue the thread.\n\nRegards,\nWeberse Support",
                'description' => 'Support follow-up after a ticket update or resolution.',
                'is_active' => true,
            ],
        ];

        foreach ($templates as $template) {
            EmailTemplate::query()->updateOrCreate(
                ['slug' => $template['slug']],
                $template
            );
        }
    }
}
