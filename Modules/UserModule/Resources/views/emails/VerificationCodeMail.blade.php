<!DOCTYPE html>
<html>

<head>
    <title>Our Project Verification Code</title>
</head>

<body>
   
    <h1>Verification Code for Our Project</h1>
    <p>Dear {{ $msg_data['email'] }},</p>
    <p>Thank you for signing up with Our Project. To complete your registration, please verify your email address.</p>
    <p>Your verification code is:</p>
    <h2>{{ $msg_data['verification_code'] }}</h2>
    <p>Please enter this code in the verification form on our website to activate your account.</p>
    <p>If you did not request this verification, please ignore this email or contact our support team for assistance.</p>
    <p>Best regards,</p>
    <p>Our Project Team</p>
</body>

</html>
