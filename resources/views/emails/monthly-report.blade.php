<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Monthly Charges Report</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            font-family: 'DejaVu Sans', sans-serif;
            border: 1px solid #ddd;
            padding: 6px;
            text-align: left;
        }
        th {
            background-color: #f0f0f0;
        }
        tfoot td {
            font-weight: bold;
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <h2>Monthly Charges Report for {{ $family->family_name }} Family</h2>
    <p>Date: {{ \Carbon\Carbon::now()->format('F Y') }}</p>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Description</th>
                <th>Amount</th>
                <th>Charged By</th>
                <th>Frontdesk Staff</th>
                <th>Department</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach($charges as $charge)
                @php $total += $charge->price; @endphp
                <tr>
                    <td>{{ \Carbon\Carbon::parse($charge->charge_datetime)->format('Y-m-d') }}</td>
                    <td>{{ $charge->description }}</td>
                    <td>₱{{ number_format($charge->price, 2) }}</td>
                    <td>{{ $charge->member->full_name ?? 'N/A' }}</td>
                    <td>{{ $charge->user->name ?? 'N/A' }}</td>
                    <td>{{ $charge->department->name ?? 'N/A' }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2">TOTAL</td>
                <td colspan="4">₱{{ number_format($total, 2) }}</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
