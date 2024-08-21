
 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Cancellation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #d9534f;
            font-size: 24px;
            margin: 0;
        }
        .content {
            line-height: 1.6;
        }
        .content p {
            margin: 0 0 10px;
        }
        .content span {
            font-weight: bold;
        }
        .footer {
            margin-top: 20px;
            text-align: start;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Leave Cancelled</h1>
        </div>
        <div class="content">
            <p>Subject: {{$leavecategory}} Cancellation for {{ $fromdate }} @if($fromdate != $todate) to {{ $todate }} @endif</p>
            {{-- <p>Dear {{ $username }},</p> --}}
            <p>We regret to inform you that your {{$leavecategory}} request for {{ $fromdate }} @if($fromdate != $todate) to {{ $todate }} @endif has been cancelled. Please find the details of your leave below:</p>
            <h2>Leave Summary</h2>
            <p><span>Leave Category:</span> {{ $leavecategory }}</p>
            <p><span>Leave Type:</span> {{ $leavetype }}</p>
            <p><span>Sandwich Leave:</span> {{ $issandwich }}</p>
            <p><span>From Date:</span> {{ $fromdate }} @if($fromdate != $todate) <span>To Date:</span> {{ $todate }} @endif</p>
            <p><span>Number of Days:</span> {{ $noofdays }}</p>
            <p><span>Reason:</span> {{ $reason }}</p>
            <p>If you have any questions or need further clarification, please contact your supervisor or HR team. We apologize for any inconvenience this may cause.</p>
            <p>Thank you for your understanding.</p>
        </div>
        <div class="footer">
            <p>Best regards,</p>
            <p>Your HR Team</p>
        </div>
    </div>
</body>
</html>
