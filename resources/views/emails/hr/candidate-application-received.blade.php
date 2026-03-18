@extends('emails.layouts.branded', [
    'title' => 'Application Received',
    'intro' => 'Your application has been recorded in the Weberse hiring pipeline.',
    'preheader' => 'We received your application for '.$application->jobOpening?->title,
])

@section('email-content')
    <p style="margin:0 0 16px;">Hello {{ $application->name }},</p>

    <p style="margin:0 0 16px;">We received your application for <strong>{{ $application->jobOpening?->title }}</strong> at Weberse Infotech.</p>

    <p style="margin:0 0 18px;">Our hiring team will review your profile, resume, and responses. If your application is shortlisted, we will contact you directly with the next step.</p>

    <table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:separate;border-spacing:0 10px;">
        <tr>
            <td style="width:150px;color:#64748b;">Role</td>
            <td style="font-weight:600;color:#0D2F50;">{{ $application->jobOpening?->title }}</td>
        </tr>
        <tr>
            <td style="color:#64748b;">Location</td>
            <td style="font-weight:600;color:#0D2F50;">{{ $application->jobOpening?->location ?? 'Remote' }}</td>
        </tr>
        <tr>
            <td style="color:#64748b;">Employment Type</td>
            <td style="font-weight:600;color:#0D2F50;">{{ str($application->jobOpening?->employment_type)->replace('_', ' ')->title() }}</td>
        </tr>
    </table>

    <p style="margin:22px 0 0;">Regards,<br><strong>Weberse Infotech Hiring Team</strong></p>
@endsection
