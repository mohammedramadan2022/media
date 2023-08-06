<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-GB">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Demystifying Email Design</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    {!! style('public/admin/css/bootstrap.css') !!}

    <style type="text/css">
        a[x-apple-data-detectors] {color: inherit !important;}
    </style>

</head>
<body style="margin: 0; padding: 0;">
<div class="container">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-6 col-xs-6">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td style="padding: 10px 0 25px 0;">

                        <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border-collapse: collapse; border: 1px solid #cccccc;">
                            <tr>
                                <td align="center" bgcolor="#6c757d" style="padding: 30px 0;">
                                    <img src="https://apluss.co/public/admin/images/logo-dark.png" alt="Creating Email Magic." width="50" style="display: block;" />
                                </td>
                            </tr>

                            <tr>
                                <td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
                                    <div class="text-center">
                                        <a href="{{ route('provider.reset-password', ['token' => $token]) }}">
                                            {{ url('/provider-panel/provider-reset-password/' . $token) }}
                                        </a>
                                        <br/>
                                        <br/>
                                        <br/>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td bgcolor="#6c757d" style="padding: 30px 30px;">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;">
                                        <tr>
                                            <td style="color: #ffffff; font-family: Arial, sans-serif; font-size: 14px;">
                                                <p style="margin: 0;">
                                                    © {{ date('Y') }} {{ config('app.name') }}. @lang('All rights reserved.')
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
        </div>
    </div>
</div>
</body>
</html>
