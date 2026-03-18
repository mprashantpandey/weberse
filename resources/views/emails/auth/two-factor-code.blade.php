@extends('emails.layouts.branded', [
    'preheader' => 'Your Weberse verification code',
    'title' => 'Verification required',
    'intro' => 'Use this one-time code to finish signing in to your Weberse account.',
])

@section('email_content')
    <p style="margin:0 0 16px;color:#334155;font-size:15px;line-height:1.7;">Hello {{ $name }},</p>
    <p style="margin:0 0 18px;color:#334155;font-size:15px;line-height:1.7;">Enter the verification code below to complete your login. This code expires in 10 minutes.</p>
    <div style="margin:0 0 20px;border-radius:18px;background:#0D2F50;padding:18px 22px;text-align:center;">
        <div style="font-size:32px;line-height:1;font-weight:700;letter-spacing:0.35em;color:#ffffff;">{{ $code }}</div>
    </div>
    <p style="margin:0;color:#64748b;font-size:13px;line-height:1.7;">If you did not attempt to sign in, reset your password and review your active sessions.</p>
@endsection
