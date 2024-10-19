<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <h1>Your Appointment Has Been Booked</h1>
    <p>Hello,</p>
    @if ($appointment->status == 'confirmed')
    <p>Your appointment has been confirmed.</p>
    @elseif ($appointment->status == 'canceled')
    <p>Your appointment has been cancelled. We hope to see you again in the future.</p>
    @elseif ($appointment->status == 'completed')
    <p>Your appointment has been completed.</p>
    @else
    <p>Your appointment has been created with a status of: <strong>Pending</strong>.</p>
    @endif

    <p>Details:</p>
    <ul>
        <li>Appointment ID: {{ $appointment->id }}</li>
        <li>Date: {{ $appointment->appointment_date }}</li>
    </ul>
    <p>Thank you!</p>


</body>

</html>