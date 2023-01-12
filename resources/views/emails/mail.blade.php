<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="x-apple-disable-message-reformatting">
    <title>{{ config('app.name', 'Kenya Space Agency') }}</title>
    <meta name="author" content="SHIFTECH AFRICA LIMITED">
    <meta property="og:type" content="website"/>
    <meta property="og:title" content="{{ config('app.name') }}"/>
    <meta property="og:image" content="{{ asset('assets/images/logo.png') }}"/>
    <meta property="og:description"
          content="Kenya Space Agency"/>
    <!--[if mso]>
    <noscript>
        <xml>
            <o:OfficeDocumentSettings>
                <o:PixelsPerInch>96</o:PixelsPerInch>
            </o:OfficeDocumentSettings>
        </xml>
    </noscript>
    <![endif]-->
    <style>
        table, td, div, h1, p {
            font-family: Arial, sans-serif;
        }
    </style>
</head>
<body style="margin:0;padding:0;">
<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
    <tr>
        <td align="center" style="padding:0;">
            <table role="presentation"
                   style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
                <tr>
                    <td align="center" style="padding:40px 0 30px 0;background:#ffffff;">
                        <img src="{{ asset('assets/images/logo.png') }}" alt="" width="300"
                             style="height:auto;display:block;"/>
                    </td>
                </tr>
                <tr>
                    <td style="padding:36px 30px 42px 30px;">
                        <table role="presentation"
                               style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                            <tr>
                                <td style="padding:0 0 36px 0;color:black;">
                                    <hr>
                                    <h5 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;"
                                        align="center"><b>{{ $title }}</b></h5>
                                    <hr>
                                    <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                        {{ \App\Http\Controllers\SystemController::pass_greetings_to_user() }} {{ $name }}
                                        ,</p>
                                    <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">{{ $body }}</p>
                                    @if($showButton)
                                        <br>
                                        <center>
                                            <a href="{{ $url }}" style="display:inline-block;
padding:0.9em 1.6em;
margin:0 0.5em 0.5em 0;
border-radius:0.15em;
box-sizing: border-box;
text-decoration:none;
font-family:'Roboto',sans-serif;
text-transform:uppercase;
font-weight:600;
font-size: large;
color:#FFFFFF;
background-color:#01188c;
box-shadow:inset 0 -0.6em 0 -0.35em rgba(0,0,0,0.17);
text-align:center;
position:relative;">{{ $buttonName }}</a>
                                        </center>
                                    @endif
                                    <br>
                                    <p style="margin:0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;color:black;">
                                        <b>Thank you & Regards,</b></p>
                                    <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">{{ config('app.name') }}</p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="padding:30px;background:#01188c;">
                        <table role="presentation"
                               style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
                            <tr>
                                <td style="padding:0;width:50%;" align="center">
                                    <p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                                        Please do not reply directly to this email | Contact us via <a
                                            style="color:#ffffff;" href="maito:support@shiftech.co.ke">support@shiftech.co.ke</a>
                                        OR +254748653542
                                    </p>
                                    <p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                                        &copy; {{ date('Y') }} <a href="{{ config('app.url') }}"
                                                                  style="color:#ffffff;">{{ config('app.name') }}</a>
                                    </p>
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



