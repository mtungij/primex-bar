<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Daily Stock Report - {{ $reportDate }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 9px;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
            color: #333;
        }
        .header p {
            margin: 5px 0 0 0;
            color: #666;
        }
        .summary {
            margin-bottom: 15px;
            display: table;
            width: 100%;
        }
        .summary-item {
            display: table-cell;
            text-align: center;
            padding: 8px;
            background: #f5f5f5;
            border: 1px solid #ddd;
        }
        .summary-label {
            font-size: 8px;
            color: #666;
            display: block;
        }
        .summary-value {
            font-size: 12px;
            font-weight: bold;
            color: #333;
            display: block;
            margin-top: 3px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th {
            background-color: #4a5568;
            color: white;
            padding: 6px 4px;
            text-align: left;
            font-size: 8px;
            font-weight: bold;
        }
        td {
            padding: 5px 4px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 8px;
        }
        tr:nth-child(even) {
            background-color: #f7fafc;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .profit-positive {
            color: #10b981;
            font-weight: bold;
        }
        .profit-negative {
            color: #ef4444;
            font-weight: bold;
        }
        .footer-totals {
            background: #edf2f7;
            padding: 10px;
            margin-top: 10px;
            border-radius: 4px;
        }
        .footer-totals table {
            margin: 0;
        }
        .footer-totals td {
            border: none;
            font-weight: bold;
            padding: 3px 8px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>DAILY STOCK REPORT</h1>
        <p>Report Date: {{ date('F d, Y', strtotime($reportDate)) }}</p>
        <p>Generated: {{ now()->format('F d, Y h:i A') }}</p>
    </div>

    <div class="summary">
        <div class="summary-item">
            <span class="summary-label">Opening Stock</span>
            <span class="summary-value">{{ number_format($totals['opening_stock']) }}</span>
        </div>
        <div class="summary-item">
            <span class="summary-label">Added Stock</span>
            <span class="summary-value">{{ number_format($totals['added_stock']) }}</span>
        </div>
        <div class="summary-item">
            <span class="summary-label">Sold Qty</span>
            <span class="summary-value">{{ number_format($totals['sold_qty']) }}</span>
        </div>
        <div class="summary-item">
            <span class="summary-label">Closing Stock</span>
            <span class="summary-value">{{ number_format($totals['closing_stock']) }}</span>
        </div>
        <div class="summary-item">
            <span class="summary-label">Total Profit</span>
            <span class="summary-value">{{ number_format($totals['profit'], 0) }}</span>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th class="text-center" style="width: 3%;">S/N</th>
                <th style="width: 15%;">Product Name</th>
                <th style="width: 10%;">Category</th>
                <th class="text-right" style="width: 7%;">Opening</th>
                <th class="text-right" style="width: 7%;">Added</th>
                <th class="text-right" style="width: 8%;">Buy Price</th>
                <th class="text-right" style="width: 8%;">Sell Price</th>
                <th class="text-right" style="width: 7%;">Sold</th>
                <th class="text-right" style="width: 7%;">Closing</th>
                <th class="text-right" style="width: 9%;">Buy Value</th>
                <th class="text-right" style="width: 9%;">Sell Value</th>
                <th class="text-right" style="width: 10%;">Profit</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reportData as $row)
                <tr>
                    <td class="text-center">{{ $row['sn'] }}</td>
                    <td>{{ $row['product_name'] }}</td>
                    <td>{{ $row['category'] }}</td>
                    <td class="text-right">{{ number_format($row['opening_stock']) }}</td>
                    <td class="text-right">{{ $row['added_stock'] > 0 ? '+' . number_format($row['added_stock']) : '-' }}</td>
                    <td class="text-right">{{ number_format($row['buy_price'], 0) }}</td>
                    <td class="text-right">{{ number_format($row['sell_price'], 0) }}</td>
                    <td class="text-right">{{ $row['sold_today'] > 0 ? number_format($row['sold_today']) : '-' }}</td>
                    <td class="text-right">{{ number_format($row['closing_stock']) }}</td>
                    <td class="text-right">{{ number_format($row['buy_value'], 0) }}</td>
                    <td class="text-right">{{ number_format($row['sell_value'], 0) }}</td>
                    <td class="text-right {{ $row['profit'] > 0 ? 'profit-positive' : ($row['profit'] < 0 ? 'profit-negative' : '') }}">
                        {{ number_format($row['profit'], 0) }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer-totals">
        <table>
            <tr>
                <td style="width: 20%;">Total Opening Stock:</td>
                <td class="text-right" style="width: 13%;">{{ number_format($totals['opening_stock']) }}</td>
                <td style="width: 20%;">Total Added:</td>
                <td class="text-right" style="width: 13%;">{{ number_format($totals['added_stock']) }}</td>
                <td style="width: 20%;">Total Sold:</td>
                <td class="text-right" style="width: 14%;">{{ number_format($totals['sold_qty']) }}</td>
            </tr>
            <tr>
                <td>Total Closing Stock:</td>
                <td class="text-right">{{ number_format($totals['closing_stock']) }}</td>
                <td>Total Buy Value:</td>
                <td class="text-right">{{ number_format($totals['buy_value'], 0) }}</td>
                <td>Total Sell Value:</td>
                <td class="text-right">{{ number_format($totals['sell_value'], 0) }}</td>
            </tr>
            <tr>
                <td colspan="4"></td>
                <td style="font-size: 10px;">TOTAL PROFIT:</td>
                <td class="text-right profit-positive" style="font-size: 12px;">{{ number_format($totals['profit'], 0) }}</td>
            </tr>
        </table>
    </div>
</body>
</html>
