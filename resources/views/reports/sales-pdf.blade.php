<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: DejaVu Sans; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 5px; }
        th { background: #eee; }
    </style>
</head>
<body>

<h3>Sales Report - {{ $date }}</h3>

<table>
    <thead>
        <tr>
            <th>Product</th>
            <th>Category</th>
            <th>Cashier</th>
            <th>Qty</th>
            <th>Price</th>
            <th>Total</th>
            <th>Time</th>
        </tr>
    </thead>
    <tbody>
        @foreach($rows as $row)
        <tr>
            <td>{{ $row->product }}</td>
            <td>{{ $row->category }}</td>
            <td>{{ $row->cashier }}</td>
            <td>{{ $row->qty }}</td>
            <td>{{ number_format($row->price) }}</td>
            <td>{{ number_format($row->total) }}</td>
            <td>{{ $row->created_at }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
