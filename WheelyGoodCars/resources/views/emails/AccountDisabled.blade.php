<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wheely account disabled</title>
</head>
<body>
    <h2>Hello {{ $user->name }},</h2>

    <p>Your account has been disabled. Don't worry — you have <strong>30 days</strong> to restore it before it is permanently deleted.</p>

    <p>To restore your account, click the button below:</p>

    <p>
        <a href="{{ $restoreUrl }}" class="button">Restore My Account</a>
    </p>

    <p>If you do not restore your account within 30 days, it will be permanently deleted and you will lose access to all data associated with this account.</p>

    <div class="footer">
        If you did not request this action or think this is a mistake, please contact our support team.
    </div>

    <p>Thanks, Wheely Team</p>
</body>
</html>