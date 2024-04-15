<!DOCTYPE html>
<html>

<head>
    <title>Invoice #{{ $data->invoiceNumber }}</title>
    <style>
        /* Basic styling */
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fb;
        }

        /* Invoice container */
        .invoice-container {
            max-width: 100%;
            margin: 10px auto;
            padding: 10px;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 6px 24px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        /* Header section */
        .invoice-header {
            margin-bottom: 30px;
        }

        /* Logo and tagline section */
        .company-info:after {
            /* content: "";
            display: table;
            clear: both; */
            display: grid;
            align-items: center;
        }

        .company-info-box {
            float: left;
            width: 48%;
            display: grid;
            align-items: center;
        }

        .company-info img {
            max-width: 150px;
            height: auto;
            border-radius: 6px;
            margin-right: 15px;
        }

        .tagline {
            font-size: 14px;
            color: #6c757d;
            margin: 0;
            font-weight: bold;
            font-style: italic;
            text-align: right;
            line-height: 49px;
        }

        /* Clear float */
        .company-info::after {
            content: "";
            display: table;
            clear: both;
        }

        /* Invoice title */
        .invoice-header h1 {
            font-family: 'Poppins', sans-serif;
            font-size: 32px;
            color: #000000;
            margin: 0;
            border-bottom: 2px solid #71C9C3;
            padding-bottom: 10px;
            margin-top: 20px;
            /* Add margin top to separate from logo and tagline */
        }

        /* Info section */
        .info-section {
            margin-bottom: 30px;
        }

        .info-box {
            width: 43.5%;
            padding: 20px;
            background-color: #f0f4f7;
            border-radius: 8px;
            float: left;
            margin-right: 10px;
            margin-left: 0px;
            border: 1px solid #dee2e6;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }

        /* Clear float */
        .info-section::after {
            content: "";
            display: table;
            clear: both;
        }

        .info-box h3 {
            margin-top: 0;
            color: #495057;
            margin-bottom: 8px;
            font-size: 14px;
            font-family: 'Playfair Display', serif;
        }

        .info-box p {
            margin: 0;
            font-size: 13px;
            color: #6c757d;
            line-height: 1.5;
        }

        /* Line item table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            overflow: hidden;
            background-color: #f8f9fb;
        }

        th,
        td {
            padding: 15px;
            border-bottom: 1px solid #dee2e6;
            text-align: center;
            font-size: 14px;
        }

        th {
            background-color: #71C9C3;
            color: #000;
            font-weight: 600;
            font-family: 'Poppins', sans-serif;
            font-size: 16px;
        }

        tr:nth-child(even) {
            background-color: #e9ecef;
        }

        /* Footer section */
        .footer {
            text-align: right;
            margin-top: 20px;
        }

        .footer p {
            color: #495057;
            font-weight: bold;
            font-size: 15px;
        }
    </style>
</head>

<body>
    <div class="invoice-container">
        <!-- Header -->
        <div class="invoice-header">
            <!-- Logo and tagline section -->
            <div class="company-info">
                <!-- Logo and tagline in one box -->
                <div class="company-info-box">
                    @if (request()->getHttpHost() == '127.0.0.1:8000')

                        {{-- @if (file_exists(public_path($data->brand->mainLogo->file_url)))
                            <!-- If the image exists, display it -->
                            <img src='{{ asset($data->brand->mainLogo->file_url) }}' alt="{{ $data->brand->name }}" />
                        @else --}}
                        {{ $data->brand->name }}
                        {{-- @endif --}}
                    @else
                        @if (file_exists(storage_path($data->brand->mainLogo->file_url)))
                            <!-- If the image exists, display it -->
                            <img src='{{ asset('storage/' . $data->brand->mainLogo->file_url) }}'
                                alt="{{ $data->brand->name }}" />
                        @else
                            {{ $data->brand->name }}
                        @endif

                    @endif
                </div>
                <div class="company-info-box">
                    <p class="tagline">{{ $data->brand->tagLine }}</p>
                </div>
            </div>

            <!-- Clear float -->
            <div style="clear: both;"></div>

            <!-- Invoice title -->
            <h1>Invoice #{{ $data->invoiceNumber }}</h1>
            <p>Due Date: {{ $data->dueDate }}</p> <!-- Add the due date -->
        </div>

        <!-- Info section -->
        <div class="info-section">
            <!-- Sender info -->
            <div class="info-box">
                <h3>From:</h3>
                <p>{{ $data->brand->fullName }}<br>
                    Email: {{ $data->brand->email }}<br>
                    Phone: {{ $data->brand->phone }}</p>
            </div>

            <!-- Recipient info -->
            <div class="info-box">
                <h3>To:</h3>
                <p>{{ $data->clientDetails->name }}<br>
                    Email: {{ $data->clientDetails->email }}<br>
                    {{ $data->clientDetails->phone !== 'NA' ? 'Phone: ' . $data->clientDetails->phone . '<br>' : '' }}
                    {{ $data->clientDetails->address !== 'NA' ? 'Address: ' . $data->clientDetails->address . '<br>' : '' }}
                    {{ $data->clientDetails->city !== 'NA' && $data->clientDetails->state !== 'NA' && $data->clientDetails->zipCode !== 'NA' ? 'City, State, Zip Code: ' . $data->clientDetails->city . ', ' . $data->clientDetails->state . ', ' . $data->clientDetails->zipCode . '<br>' : '' }}
                    {{ $data->clientDetails->country !== 'NA' ? 'Country: ' . $data->clientDetails->country : '' }}</p>
            </div>
        </div>

        <!-- Line item table -->
        <table>
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <!-- Loop through the offerservices array -->
                @foreach ($data->offerServices as $offerService)
                    <tr>
                        <td>{{ $offerService->description }}</td>
                        <td>{{ $offerService->qty }}</td>
                        <td>${{ $offerService->price }}</td>
                        <td>${{ $offerService->price * $offerService->qty }}</td>
                    </tr>
                @endforeach

            </tbody>
        </table>

        <!-- Footer section -->
        <div class="footer">
            <table style="width: auto; margin-left: auto; margin-right: 0;">
                <tr>
                    <td style="text-align: left; font-weight: bold; padding-right: 10px;">Subtotal:</td>
                    <td style="text-align: right;">${{ $data->subTotal }}</td>
                </tr>
                @if ($data->shippingCharges > 0)
                    <tr>
                        <td style="text-align: left; font-weight: bold; padding-right: 10px;">Shipping Charges:</td>
                        <td style="text-align: right;">${{ $data->shippingCharges }}</td>
                    </tr>
                @endif
                @if ($data->isDiscount !== 0)
                    <tr>
                        <td style="text-align: left; font-weight: bold; padding-right: 10px;">Discount:</td>
                        <td style="text-align: right;">-$0.00</td>
                    </tr>
                @endif
                <tr>
                    <td style="text-align: left; font-weight: bold; padding-right: 10px;">Total Amount:</td>
                    @if ($data->totalAmountDue > 0)
                        <td style="text-align: right;">
                            ${{ $data->isRecurring !== 0 ? $data->totalAmount . ' / ' . $data->recurringType : $data->totalAmount }}
                        </td>
                    @elseif ($data->totalAmountDue < 1)
                        <td style="text-align: right; font-size:22px; font-weight: bold; color:teal;">
                            ${{ $data->isRecurring !== 0 ? $data->totalAmount . ' / ' . $data->recurringType : $data->totalAmount }}
                        </td>
                    @endif
                </tr>
                @if ($data->totalAmountDue > 0)
                    <tr>
                        <td style="text-align: left; font-weight: bold; padding-right: 10px;">Partial
                            Payment:</td>
                        <td style="text-align: right; font-size:22px; font-weight: bold; color:teal;">
                            ${{ $data->currentAmount }}
                            / =
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: left; font-weight: bold; padding-right: 10px;">Remaining Balance:</td>
                        <td style="text-align: right;">${{ $data->totalAmountDue }}</td>
                    </tr>
                @endif
            </table>
            <p>Thank you for your business!</p>
            @if ($data->payLink !== 'NA')
                <p><a href="https://payment-link.com">Click here to pay</a></p>
            @endif
        </div>

    </div>
</body>

</html>
