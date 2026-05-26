@php
    $report = $summary['summary'] ?? $summary ?? [];
    $generatedAt = now()->format('Y-m-d H:i:s');
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Monthly Report' }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #222;
            margin: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h2 {
            margin: 0;
            font-size: 22px;
        }

        .header p {
            margin: 4px 0 0;
            color: #666;
        }

        .summary {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 18px;
        }

        .summary td {
            border: 1px solid #ddd;
            padding: 8px;
            vertical-align: top;
        }

        .summary .label {
            font-weight: bold;
            background: #f7f7f7;
            width: 25%;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th, .table td {
            border: 1px solid #333;
            padding: 6px;
            font-size: 10px;
            text-align: center;
        }

        .table th {
            background: #efefef;
        }

        .text-right {
            text-align: right;
        }

        .footer {
            margin-top: 18px;
            font-size: 10px;
            color: #666;
            text-align: right;
        }

        .net-box {
            margin: 10px 0 18px;
            padding: 10px 12px;
            border: 1px solid #333;
            background: #fafafa;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>{{ $title ?? 'Monthly Report' }}</h2>
        <p>
            @if(isset($filters['report_type']) && $filters['report_type'] === 'range')
                From {{ $filters['from_date'] ?? '-' }} to {{ $filters['to_date'] ?? '-' }}
            @else
                Month: {{ $summary['month'] ?? '' }}
            @endif
        </p>
    </div>

    <table class="summary">
        <tr>
            <td class="label">Payment Total</td>
            <td>{{ number_format($report['payment_total'] ?? 0, 2) }}</td>
            <td class="label">Admission Total</td>
            <td>{{ number_format($report['admission_total'] ?? 0, 2) }}</td>
        </tr>
        <tr>
            <td class="label">Extra Income</td>
            <td>{{ number_format($report['extra_income_total'] ?? 0, 2) }}</td>
            <td class="label">Teacher Expense</td>
            <td>{{ number_format($report['teacher_expense_total'] ?? 0, 2) }}</td>
        </tr>
        <tr>
            <td class="label">Organizer Expense</td>
            <td>{{ number_format($report['organizer_expense_total'] ?? 0, 2) }}</td>
            <td class="label">Institute Expense</td>
            <td>{{ number_format($report['instituteExpencesTotal'] ?? $report['institute_expense_total'] ?? 0, 2) }}</td>
        </tr>
    </table>

    <div class="net-box">
        Net Total: {{ number_format($report['net_total'] ?? 0, 2) }}
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Payment</th>
                <th>Admission</th>
                <th>Extra Income</th>
                <th>Teacher Expense</th>
                <th>Organizer Expense</th>
                <th>Institute Expense</th>
                <th>Net Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($dailyRows ?? [] as $row)
                <tr>
                    <td>{{ $row['date'] }}</td>
                    <td>{{ number_format($row['payment_total'] ?? 0, 2) }}</td>
                    <td>{{ number_format($row['admission_total'] ?? 0, 2) }}</td>
                    <td>{{ number_format($row['extra_income_total'] ?? 0, 2) }}</td>
                    <td>{{ number_format($row['teacher_expense_total'] ?? 0, 2) }}</td>
                    <td>{{ number_format($row['organizer_expense_total'] ?? 0, 2) }}</td>
                    <td>{{ number_format($row['institute_expense_total'] ?? 0, 2) }}</td>
                    <td>{{ number_format($row['net_total'] ?? 0, 2) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">No records found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Generated at: {{ $generatedAt }}
    </div>
</body>
</html>