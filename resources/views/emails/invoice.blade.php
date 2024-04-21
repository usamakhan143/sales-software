<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice from {{ $data->brand->name }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 24px;
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        p {
            font-size: 16px;
            line-height: 1.6;
            color: #666;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: left;
            font-size: 16px;
            color: #333;
        }

        th {
            background-color: #f2f2f2;
        }

        .button {
            display: inline-block;
            background-color: #4CAF50;
            color: #fff;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
        }

        .button:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>Invoice from {{ $data->brand->name }}</h1>

        <p>Dear {{ $data->clientDetails->name }},</p>

        <p>We hope this email finds you well. Attached to this email, you will find the invoice for the
            services/products provided to you by {{ $data->brand->name }}. Please review the details carefully.</p>

        <table>
            <tr>
                <th>Invoice Number</th>
                <td>#{{ $data->invoiceNumber }}</td>
            </tr>
            <tr>
                <th>Date</th>
                <td>{{ $data->combineDate }}</td>
            </tr>
            <tr>
                <th>Due Date</th>
                <td>{{ $data->dueDate }}</td>
            </tr>
            @if ($data->totalAmountDue > 0)
                <tr>
                    <th>Total Amount Due</th>
                    <td>{{ $data->totalAmountDue }}</td>
                </tr>
            @endif
        </table>

        <p>Please ensure that payment is made by the due date mentioned above to avoid any late fees.</p>

        <p>If you have any questions or concerns regarding the invoice, feel free to reach out to us at
            {{ $data->brand->email }}.</p>

        <p>Thank you for your prompt attention to this matter. We look forward to continuing our business relationship
            with you.</p>

        @if ($data->payLink !== 'NA')
            <p style="text-align: center;"><a href="{{ $data->payLink }}" class="button"
                    style="background-color: #17BED5; color:#ffff; font-weight:bold">Pay
                    Now</a></p>
        @endif

        <p>Best regards,<br>
            {{-- [Your Name]<br> --}}
            {{-- [Your Position]<br> --}}
            {{ $data->brand->fullName }}</p>
    </div>

</body>

</html>
