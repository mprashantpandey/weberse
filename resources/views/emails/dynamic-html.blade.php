@extends('emails.layouts.branded', [
    'title' => $subjectLine,
    'intro' => 'A branded message from Weberse Infotech.',
    'preheader' => \Illuminate\Support\Str::limit(strip_tags($htmlBody), 120),
])

@section('email-content')
    {!! $htmlBody !!}
@endsection
