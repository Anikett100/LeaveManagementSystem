<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Cancellation Request</title>
</head>
<body>
    <div class="container">
        <h1>Leave Cancellation Request</h1>
        <p>A request has been made to cancel leave with the following details:</p>
        <ul>
            <li><strong>Leave ID:</strong> {{ $leaveId }}</li>
            <li><strong>Reason for Cancellation:</strong> {{ $reason }}</li>
        </ul>
    </div>
</body>
</html>
