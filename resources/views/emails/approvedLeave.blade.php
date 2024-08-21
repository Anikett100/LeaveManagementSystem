{{-- 
<!DOCTYPE html>
<html>
<head>
    <title>Leave Approved</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap');
        * {
            box-sizing: border-box;
        }
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f9fafb;
            margin: 0;
            padding: 0;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="max-w-3xl mx-auto my-8 bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="bg-indigo-600 text-white text-center p-6">
            <h1 class="text-2xl font-bold">Your Leave Has Been Approved</h1>
        </div>
        <div class="p-6">
            <p class="font-semibold mb-4">Hello,</p>
            <p class="mb-4">Your leave request has been approved. Here are the details:</p>
            <table class="w-full text-left">
                <tbody>
                    <tr>
                        <td class="font-semibold py-2">Leave Type:</td>
                        <td class="py-2">{{ $leavetype }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold py-2">Leave Category:</td>
                        <td class="py-2">{{ $leavecategory }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold py-2">Sandwich Leave:</td>
                        <td class="py-2">{{ $issandwich }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold py-2">From Date:</td>
                        <td class="py-2">{{ $fromdate }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold py-2">To Date:</td>
                        <td class="py-2">{{ $todate }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold py-2">Number of Days:</td>
                        <td class="py-2">{{ $noofdays }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold py-2">Reason:</td>
                        <td class="py-2">{{ $reason }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold py-2">Approved Reason:</td>
                        <td class="py-2">{{ $actionreason }}</td>
                    </tr>
                </tbody>
            </table>
            <a href="#" class="inline-block mt-6 px-6 py-2 bg-indigo-600 text-white font-bold rounded-md">View Details</a>
        </div>
        <div class="bg-gray-200 text-center p-4">
            <p class="text-gray-700">If you have any questions, please contact HR.</p>
        </div>
    </div>
</body>
</html>
 --}}






 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Approval</title>
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
            <h1>Leave Approved</h1>
        </div>
        <div class="content">
            <p>Subject: {{$leavecategory}} Approved for {{ $fromdate }} @if($fromdate != $todate) to {{ $todate }} @endif</p>
            {{-- <p>Dear {{ $username }},</p> --}}
            <p>We are pleased to inform you that your {{$leavecategory}} request for {{ $fromdate }} @if($fromdate != $todate) to {{ $todate }} @endif has been approved. Please find the details of your leave below:</p>
            <h2>Leave Summary</h2>
            <p><span>Leave Category:</span> {{ $leavecategory }}</p>
            <p><span>Leave Type:</span> {{ $leavetype }}</p>
            <p><span>Sandwich Leave:</span> {{ $issandwich }}</p>
            <p><span>From Date:</span> {{ $fromdate }} @if($fromdate != $todate) <span>To Date:</span> {{ $todate }} @endif</p>
            <p><span>Number of Days:</span> {{ $noofdays }}</p>
            <p><span>Reason:</span> {{ $reason }}</p>
            <p>Please ensure that all your responsibilities are appropriately handed over to your colleagues before your leave begins. If there are any changes or further requirements, do not hesitate to reach out to your supervisor.</p>
            <p>We hope you have a restful and productive time during your leave.</p>
        </div>
        <div class="footer">
            <p>Best regards,</p>
            <p>Your HR Team</p>
        </div>
    </div>
</body>
</html>
