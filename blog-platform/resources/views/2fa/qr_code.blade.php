<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enable 2FA</title>
</head>
<body>
    <h1>Scan QR Code</h1>
    <p>Scan the QR code below with your Google Authenticator app:</p>
    <img src="{{ $qrCodeUrl }}" alt="QR Code">
    <p>Secret Key: {{ $secret }}</p>
</body>
</html>
