<!-- resources/views/emails/forgot_password.blade.php -->
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Password Reset</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            padding: 20px 0;
            border-bottom: 1px solid #dddddd;
        }

        .content {
            padding: 20px;
            line-height: 1.6;
        }

        .footer {
            text-align: center;
            padding: 20px 0;
            border-top: 1px solid #dddddd;
            color: #777777;
            font-size: 12px;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            color: #ffffff;
            background-color: #007bff;
            border-radius: 5px;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Password Reset Request</h1>
        </div>
        <div class="content">
            <p>Hi,</p>
            <p>We received a request to reset your password. Click the button below to reset it:</p>
            <p>
                <a href="{{ $url }}" class="button">Reset Password</a>
            </p>
            <p>If you did not request a password reset, please ignore this email.</p>
            <p>Thanks,<br>Your Application Name</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Your Application Name. All rights reserved.
        </div>
    </div>
</body>

</html>
