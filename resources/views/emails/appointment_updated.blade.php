<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Status Updated</title>
</head>
<body>
    <h1>Your Appointment Status Has Been Updated</h1>
    <p>Hello,</p>
    <p>The status of your appointment has been changed to: <strong>{{ $appointment->status }}</strong>.</p>
    <p>Details:</p>
    <ul>
        <li>Appointment ID: {{ $appointment->id }}</li>
        <li>Date: {{ $appointment->appointment_date }}</li>
    </ul>
    <p>Thank you!</p>
</body>
</html>
