<table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="background:rgba(115,182,85,0.08);border:1px solid rgba(115,182,85,0.22);border-radius:22px;">
    <tr>
        <td style="padding:18px 20px;">
            <div style="font-size:12px;line-height:1.8;color:#35506d;">
                <strong style="color:#0D2F50;">Authenticity check:</strong>
                Weberse emails will come from configured official addresses such as <strong>{{ $companyProfile['email'] ?? config('platform.company.email') }}</strong>.
                We will not ask for your password, OTP, or payment credentials by email.
                If anything looks suspicious, reply to this email or contact {{ $companyProfile['phone'] ?? config('platform.company.phone') }} directly.
            </div>
        </td>
    </tr>
</table>
