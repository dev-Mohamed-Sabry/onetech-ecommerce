<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Reset Your Password</title>
</head>

<body style="margin:0; padding:0; background-color:#f4f6f9; font-family: Arial, Helvetica, sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="padding:40px 0; background-color:#f4f6f9;">
        <tr>
            <td align="center">

                <!-- Main Container -->
                <table width="600" cellpadding="0" cellspacing="0"
                    style="background-color:#ffffff; border-radius:8px; overflow:hidden; box-shadow:0 4px 12px rgba(0,0,0,0.05);">

                    <!-- Header -->
                    <tr>
                        <td align="center"
                            style="background-color:#0e8ce4; padding:30px; color:#ffffff; font-size:28px; font-weight:bold;">
                            OneTech
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:40px 30px; text-align:center; color:#333333;">

                            <h2 style="margin:0 0 20px 0; font-size:22px;">
                                Reset Your Password
                            </h2>

                            <p style="font-size:15px; line-height:1.6; margin-bottom:30px; color:#555;">
                                We received a request to reset your password.
                                Click the button below to set a new password.
                            </p>

                            <!-- Button -->
                            <a href="{{ $data }}" style="display:inline-block; padding:14px 30px; background-color:#17a2b8; color:#ffffff; 
                                       text-decoration:none; border-radius:5px; font-size:15px; font-weight:bold;">
                                Reset Password
                            </a>

                            <p style="margin-top:30px; font-size:13px; color:#888;">
                                This link will expire in 30 minutes.
                            </p>

                            <p style="margin-top:20px; font-size:13px; color:#999;">
                                If you did not request a password reset, please ignore this email.
                            </p>

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td align="center" style="background-color:#f8f9fa; padding:20px; font-size:12px; color:#999;">
                            © {{ date('Y') }} OneTech. All rights reserved.
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>