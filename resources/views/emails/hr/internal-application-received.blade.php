@extends('emails.layouts.branded', [
    'title' => 'New Job Application',
    'intro' => 'A new candidate has entered the hiring pipeline.',
    'preheader' => $application->name.' applied for '.$application->jobOpening?->title,
])

@section('email-content')
    <p style="margin:0 0 18px;">A new job application has been submitted.</p>

    <table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:separate;border-spacing:0 10px;">
        <tr><td style="width:150px;color:#64748b;">Candidate</td><td style="font-weight:600;color:#0D2F50;">{{ $application->name }}</td></tr>
        <tr><td style="color:#64748b;">Email</td><td style="font-weight:600;color:#0D2F50;">{{ $application->email }}</td></tr>
        <tr><td style="color:#64748b;">Phone</td><td style="font-weight:600;color:#0D2F50;">{{ $application->phone ?: 'Not provided' }}</td></tr>
        <tr><td style="color:#64748b;">Role</td><td style="font-weight:600;color:#0D2F50;">{{ $application->jobOpening?->title }}</td></tr>
        <tr><td style="color:#64748b;">Notice Period</td><td style="font-weight:600;color:#0D2F50;">{{ $application->notice_period_response ?: 'Not provided' }}</td></tr>
    </table>

    @if($application->cover_letter)
        <div style="margin-top:22px;padding:18px 20px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:18px;">
            <div style="font-weight:700;color:#0D2F50;margin-bottom:8px;">Cover Letter / Note</div>
            <div>{{ $application->cover_letter }}</div>
        </div>
    @endif

    @if($application->application_answers)
        <div style="margin-top:22px;font-weight:700;color:#0D2F50;">Question Responses</div>
        <div style="margin-top:12px;">
            @foreach($application->application_answers as $question => $answer)
                <div style="padding:16px 18px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:18px;margin-bottom:10px;">
                    <div style="font-weight:700;color:#0D2F50;margin-bottom:6px;">{{ $question }}</div>
                    <div>{{ $answer }}</div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
