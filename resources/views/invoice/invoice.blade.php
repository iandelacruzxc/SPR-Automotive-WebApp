<!-- resources/views/invoice/invoice.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Standard Panel Repair</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f8f9fa;
            color: #333;
        }

        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .header,
        .footer {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #007bff;
        }

        .header p {
            margin: 5px 0;
            font-size: 14px;
        }

        .details-table,
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 14px;
        }

        .details-table th,
        .items-table th,
        .details-table td,
        .items-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .details-table th,
        .items-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .items-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        h2 {
            border-bottom: 2px solid #007bff;
            padding-bottom: 5px;
            color: #007bff;
            font-size: 18px;
            margin-top: 20px;
            margin-bottom: 10px;
        }

        .total {
            font-weight: bold;
            font-size: 16px;
            margin-top: 10px;
            text-align: right;
        }

        .footer p {
            margin: 0;
            font-size: 12px;
            color: #777;
        }

        .signature {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            text-align: center;
        }

        .signature div {
            width: 30%;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Invoice</h1>
            <p>Standard Panel Repair</p>
            <p> Light Industry & Science Park II, Admin Bldg.</p>
            <p>Phone: (123) 456-7890</p>
        </div>

        <h2>Transaction Details</h2>
        <table class="details-table">
            <tr>
                <th>Transaction Code</th>
                <td>{{ $transaction->code }}</td>
            </tr>
            <tr>
                <th>Name</th>
                <td>{{ $transaction->client_name }}</td>
            </tr>
            <tr>
                <th>Unit/Model</th>
                <td>{{ $transaction->unit }}</td>
            </tr>
            <tr>
                <th>Color</th>
                <td>{{ $transaction->color }}</td>
            </tr>
            <tr>
                <th>Plate No.</th>
                <td>{{ $transaction->plate_no }}</td>
            </tr>
            <tr>
                <th>Address</th>
                <td>{{ $transaction->address }}</td>
            </tr>
            <tr>
                <th>Phone No.</th>
                <td>{{ $transaction->contact }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $transaction->email }}</td>
            </tr>
            <tr>
                <th>Date In</th>
                <td>{{ \Carbon\Carbon::parse($transaction->date_in)->format('F j, Y, g:i A') }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>{{ $transaction->status }}</td>
            </tr>
        </table>

        <div class="items">
            <h2>Services</h2>
            <table class="items-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    @if($transaction->services->isEmpty())
                    <tr>
                        <td colspan="2">No services found for this transaction.</td>
                    </tr>
                    @else
                    @foreach($transaction->services as $transactionService)
                    <tr>
                        <td>{{ $transactionService->service->name }}</td>
                        <td>{{ number_format($transactionService->price, 2) }}</td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>

            <h2>Products</h2>
            <table class="items-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @if($transaction->products->isEmpty())
                    <tr>
                        <td colspan="4">No products found for this transaction.</td>
                    </tr>
                    @else
                    @foreach($transaction->products as $transactionProduct)
                    <tr>
                        <td>{{ $transactionProduct->product->name }}</td>
                        <td>{{ number_format($transactionProduct->product->price, 2) }}</td>
                        <td>{{ $transactionProduct->quantity }}</td>
                        <td>{{ number_format($transactionProduct->product->price * $transactionProduct->quantity, 2) }}</td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>

            <h2 class="total">Total Amount: {{ number_format($transaction->amount, 2) }}</h2>
        </div>

        <div class="footer">
            <p>Thank you for your business!</p>
        </div>
    </div>
</body>

</html>