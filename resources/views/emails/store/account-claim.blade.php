@extends('emails.layouts.branded', [
    'title' => 'Set your password',
    'intro' => 'Thanks for your purchase. Set a password to access your downloads anytime.',
    'preheader' => 'Set a password to access your Weberse downloads.',
])

@section('email-content')
    <p style="margin:0 0 14px;">
        Hi{{ isset($user) && filled($user->name) ? ' '.$user->name : '' }},
    </p>
    <p style="margin:0 0 18px;">
        We’ve created an account for <strong>{{ $user->email ?? '' }}</strong>. Use the button below to set your password and access your download library.
    </p>

    <p style="margin:0 0 24px;">
        <a href="{{ $claimUrl }}" style="display:inline-block;background:#73B655;color:#ffffff;text-decoration:none;padding:12px 18px;border-radius:14px;font-weight:700;">
            Set password & access downloads
        </a>
    </p>

    <p style="margin:0 0 10px;color:#64748b;">
        This link expires in 24 hours. If you didn’t request this, you can ignore the email.
    </p>
@endsection

