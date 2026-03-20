@extends('emails.layouts.branded', [
    'title' => 'Interview Scheduled',
    'intro' => 'Your next hiring step has been scheduled by Weberse Infotech.',
    'preheader' => 'Interview scheduled for '.$interview->application->jobOpening?->title,
])

@section('email-content')
    <p style="margin:0 0 16px;">Hello {{ $interview->application->name }},</p>

    <p style="margin:0 0 18px;">Your interview for <strong>{{ $interview->application->jobOpening?->title }}</strong> has been scheduled.</p>

    <table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:separate;border-spacing:0 10px;">
        <tr><td style="width:150px;color:#64748b;">Date & Time</td><td style="font-weight:600;color:#0D2F50;">{{ $interview->scheduled_for?->format('d M Y, h:i A') }}</td></tr>
        <tr><td style="color:#64748b;">Stage</td><td style="font-weight:600;color:#0D2F50;">{{ str($interview->stage)->replace('_', ' ')->title() }}</td></tr>
        <tr><td style="color:#64748b;">Mode</td><td style="font-weight:600;color:#0D2F50;">{{ str($interview->mode)->replace('_', ' ')->title() }}</td></tr>
        <tr><td style="color:#64748b;">Interviewer</td><td style="font-weight:600;color:#0D2F50;">{{ $interview->interviewer_name }}</td></tr>
    </table>

    @if ($interview->meeting_link)
        <div style="margin-top:20px;">
            <a href="{{ $interview->meeting_link }}" style="display:inline-block;background:#73B655;color:#ffffff;text-decoration:none;padding:12px 18px;border-radius:14px;font-weight:700;">Join Interview</a>
        </div>
        <div style="margin-top:10px;font-size:13px;color:#64748b;">If the button does not work, use this link: {{ $interview->meeting_link }}</div>
    @endif

    @if ($interview->notes)
        <div style="margin-top:22px;padding:18px 20px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:18px;">
            <div style="font-weight:700;color:#0D2F50;margin-bottom:8px;">Notes</div>
            <div>{{ $interview->notes }}</div>
        </div>
    @endif

    <p style="margin:22px 0 0;">Regards,<br><strong>Weberse Infotech HR Team</strong></p>
@endsection
