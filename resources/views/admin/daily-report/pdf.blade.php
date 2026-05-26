<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11px;
            color: #1e293b;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #2563eb;
        }
        .header h1 { font-size: 20px; margin: 0; }
        .header .date { font-size: 11px; color: #64748b; margin-top: 5px; }
        .summary {
            margin-bottom: 20px;
            padding: 10px;
            background: #f8fafc;
            border-radius: 8px;
        }
        table { width: 100%; border-collapse: collapse; }
        th {
            background: #f1f5f9;
            padding: 8px;
            font-size: 9px;
            text-transform: uppercase;
            border: 1px solid #e2e8f0;
        }
        td { padding: 6px 8px; border: 1px solid #e2e8f0; }
        .text-right { text-align: right; }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 8px;
            color: #94a3b8;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $title }}</h1>
        <div class="date">Date: {{ \Carbon\Carbon::parse($date)->format('d F Y') }}</div>
    </div>

    <div class="summary">
        <strong>{{ $summary_label }}:</strong> Rs. {{ number_format($summary_value, 2) }} | 
        <strong>Total Records:</strong> {{ $count }}
    </div>

    <table>
        <thead>
            <tr>
                @foreach($headings as $heading)
                    <th>{{ $heading }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @forelse($rows as $row)
                <tr>
                    @foreach($columns as $column)
                        <td class="{{ str_contains($column, 'amount') ? 'text-right' : '' }}">
                            {{ data_get($row, $column, '-') }}
                        </td>
                    @endforeach
                </tr>
            @empty
                <tr><td colspan="{{ count($headings) }}" class="text-center">No records found</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Generated on: {{ now()->format('d M Y, h:i A') }}
    </div>
</body>
</html>