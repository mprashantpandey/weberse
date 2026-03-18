@extends('emails.layouts.branded', [
    'title' => 'Interview Scheduled',
    'intro' => 'A candidate interview event has been added to the hiring workflow.',
    'preheader' => $interview->application->name.' scheduled for '.$interview->application->jobOpening?->title,
])

@section('email-content')
    <p style="margin:0 0 18px;">A new interview has been scheduled.</p>

    <table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:separate;border-spacing:0 10px;">
        <tr><td style="width:150px;color:#64748b;">Candidate</td><td style="font-weight:600;color:#0D2F50;">{{ $interview->application->name }}</td></tr>
        <tr><td style="color:#64748b;">Role</td><td style="font-weight:600;color:#0D2F50;">{{ $interview->application->jobOpening?->title }}</td></tr>
        <tr><td style="color:#64748b;">Department</td><td style="font-weight:600;color:#0D2F50;">{{ $interview->application->jobOpening?->department?->name ?? 'General' }}</td></tr>
        <tr><td style="color:#64748b;">Date & Time</td><td style="font-weight:600;color:#0D2F50;">{{ $interview->scheduled_for?->format('d M Y, h:i A') }}</td></tr>
        <tr><td style="color:#64748b;">Stage</td><td style="font-weight:600;color:#0D2F50;">{{ str($interview->stage)->replace('_', ' ')->title() }}</td></tr>
        <tr><td style="color:#64748b;">Mode</td><td style="font-weight:600;color:#0D2F50;">{{ str($interview->mode)->replace('_', ' ')->title() }}</td></tr>
        <tr><td style="color:#64748b;">Interviewer</td><td style="font-weight:600;color:#0D2F50;">{{ $interview->interviewer_name }}</td></tr>
    </table>

    @if ($interview->meeting_link)
        <div style="margin-top:18px;">
            <strong style="color:#0D2F50;">Meeting Link:</strong>
            <a href="{{ $interview->meeting_link }}" style="color:#0D2F50;">{{ $interview->meeting_link }}</a>
        </div>
    @endif

    @if ($interview->notes)
        <div style="margin-top:22px;padding:18px 20px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:18px;">
            <div style="font-weight:700;color:#0D2F50;margin-bottom:8px;">Notes</div>
            <div>{{ $interview->notes }}</div>
        </div>
    @endif
@endsection
