@php($emailLogo = filled($companyProfile['light_logo'] ?? null) ? (\Illuminate\Support\Str::startsWith($companyProfile['light_logo'], ['http://', 'https://', '/']) ? $companyProfile['light_logo'] : asset($companyProfile['light_logo'])) : asset('assets/legacy/weberse-light.svg'))
@php($emailLogoHost = parse_url($emailLogo, PHP_URL_HOST))
@php($showEmailLogo = filled($emailLogo) && ! in_array($emailLogoHost, ['127.0.0.1', 'localhost', '::1'], true))
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? ($companyProfile['name'] ?? config('platform.company.name')) }}</title>
</head>
<body style="margin:0;padding:0;background:#eef4fa;font-family:Inter,Arial,sans-serif;color:#0f172a;">
    <div style="display:none;max-height:0;overflow:hidden;opacity:0;">
        {{ $preheader ?? ($companyProfile['tagline'] ?? config('platform.company.tagline')) }}
    </div>

    <table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="background:#eef4fa;margin:0;padding:24px 0;">
        <tr>
            <td align="center">
                <table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="max-width:680px;margin:0 auto;">
                    <tr>
                        <td style="padding:0 16px 18px;">
                            <table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="background:linear-gradient(135deg,#0D2F50,#163d61);border-radius:28px;overflow:hidden;">
                                <tr>
                                    <td style="padding:28px 32px;">
                                        @if ($showEmailLogo)
                                            <img src="{{ $emailLogo }}" alt="Weberse Infotech" style="height:42px;width:auto;display:block;">
                                        @else
                                            <div style="color:#ffffff;font-size:18px;line-height:1.2;font-weight:800;letter-spacing:0.08em;text-transform:uppercase;">
                                                {{ $companyProfile['name'] ?? config('platform.company.name') }}
                                            </div>
                                        @endif
                                        <div style="margin-top:18px;color:#ffffff;font-size:28px;line-height:1.2;font-weight:700;">
                                            {{ $title ?? ($companyProfile['name'] ?? config('platform.company.name')) }}
                                        </div>
                                        @if (!empty($intro ?? null))
                                            <div style="margin-top:10px;color:rgba(255,255,255,0.82);font-size:15px;line-height:1.7;">
                                                {{ $intro }}
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:0 16px;">
                            <table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="background:#ffffff;border-radius:28px;overflow:hidden;box-shadow:0 20px 50px rgba(13,47,80,0.08);">
                                <tr>
                                    <td style="padding:32px;">
                                        <div style="color:#334155;font-size:15px;line-height:1.9;">
                                            @yield('email-content')
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:16px;">
                            <table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="background:#081a2e;border-radius:24px;">
                                <tr>
                                    <td style="padding:22px 24px;color:#cbd5e1;font-size:13px;line-height:1.8;">
                                        <div style="font-weight:700;color:#ffffff;">{{ $companyProfile['name'] ?? config('platform.company.name') }}</div>
                                        <div>{{ $companyProfile['tagline'] ?? config('platform.company.tagline') }}</div>
                                        <div style="margin-top:10px;">
                                            Email: <a href="mailto:{{ $companyProfile['email'] ?? config('platform.company.email') }}" style="color:#73B655;text-decoration:none;">{{ $companyProfile['email'] ?? config('platform.company.email') }}</a><br>
                                            Phone: {{ $companyProfile['phone'] ?? config('platform.company.phone') }}<br>
                                            Location: {{ ($companyProfile['address_line_1'] ?? null) ?: ($companyProfile['location'] ?? config('platform.company.location')) }}
                                        </div>
                                        <div style="margin-top:12px;color:#94a3b8;">
                                            This is a system email from Weberse Infotech. Please keep it for your records.
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
