
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Request</title>
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
            color: #484C7F;
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
            <h1>Leave Request</h1>
        </div>
        <div class="content">
            <p>Subject: {{$leavecategory}} Request </p>
            <p>Dear Sir/Madam,</p>
            <p>I hope this message finds you well. I am writing to formally request a {{$leavecategory}} for {{ $fromdate }} @if($fromdate != $todate) to {{ $todate }} @endif. Please find the details of my request below:</p>
            <h2>Leave Summary</h2>
            <p><span>Leave Category:</span> {{ $leavecategory }}</p>
            <p><span>Leave Type:</span> {{ $leavetype }}</p>
            <p><span>Sandwich Leave:</span> {{ $issandwich }}</p>
            <p><span>From Date:</span> {{ $fromdate }} @if($fromdate != $todate) <span>To Date:</span> {{ $todate }} @endif</p>
            <p><span>Number of Days:</span> {{ $noofdays }}</p>
            <p><span>Reason:</span> {{ $reason }}</p>
            <p>Please let me know if you need any additional information or if there are any concerns regarding my leave request. I would be happy to discuss this further if needed.</p>
            <p>Thank you for considering my request. I look forward to your approval.</p>
        </div>
        <div class="footer">
            <p>Best regards,</p>
            <p>{{ $username }}</p>
           
        </div>
    </div>
</body>
</html>

