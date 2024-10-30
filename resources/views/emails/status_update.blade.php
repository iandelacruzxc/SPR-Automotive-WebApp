<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Status Update</title>
</head>
<body>
    <h1>Transaction Status Update</h1>
    <p>Hello,</p>
    <p>The status of your transaction has been updated.</p>
    <p><strong>Transaction ID:</strong> {{ $transaction->id }}</p>
    <p><strong>Client Name:</strong> {{ $transaction->client_name }}</p>
    <p><strong>New Status:</strong> {{ $transaction->status }}</p>
    <p>Thank you for your attention!</p>
</body>
</html>
