<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            color: #1e293b;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #2563eb;
        }
        .header h1 {
            font-size: 22px;
            font-weight: 800;
            margin: 0;
            color: #0f172a;
        }
        .header .date {
            font-size: 12px;
            color: #64748b;
            margin-top: 5px;
        }
        .summary-cards {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 25px;
        }
        .card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 12px 20px;
            flex: 1;
            min-width: 150px;
        }
        .card.income { background: linear-gradient(135deg, #dcfce7, #bbf7d0); }
        .card.expense { background: linear-gradient(135deg, #fee2e2, #fecaca); }
        .card.net { background: linear-gradient(135deg, #dbeafe, #bfdbfe); }
        .card-title {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #475569;
            margin-bottom: 5px;
        }
        .card-value {
            font-size: 18px;
            font-weight: 800;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th {
            background: #f1f5f9;
            padding: 10px;
            font-size: 11px;
            text-transform: uppercase;
            border: 1px solid #e2e8f0;
        }
        td {
            padding: 8px 10px;
            border: 1px solid #e2e8f0;
        }
        .text-right {
            text-align: right;
        }
        .amount-income {
            color: #166534;
            font-weight: 600;
        }
        .amount-expense {
            color: #991b1b;
            font-weight: 600;
        }
        .amount-net {
            color: #1e40af;
            font-weight: 700;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 9px;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
            padding-top: 15px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $title }}</h1>
        <div class="date">Report Date: {{ \Carbon\Carbon::parse($date)->format('d F Y') }}</div>
    </div>

    <div class="summary-cards">
        <div class="card income">
            <div class="card-title">Total Income</div>
            <div class="card-value">
                Rs. {{ number_format(($summary_data['payment_total'] ?? 0) + ($summary_data['admission_total'] ?? 0) + ($summary_data['extra_income_total'] ?? 0), 2) }}
            </div>
        </div>
        <div class="card expense">
            <div class="card-title">Total Expenses</div>
            <div class="card-value">
                Rs. {{ number_format(($summary_data['teacher_expense_total'] ?? 0) + ($summary_data['organizer_expense_total'] ?? 0) + ($summary_data['instituteExpencesTotal'] ?? 0), 2) }}
            </div>
        </div>
        <div class="card net">
            <div class="card-title">Net Balance</div>
            <div class="card-value">
                Rs. {{ number_format($summary_data['net_total'] ?? 0, 2) }}
            </div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Category</th>
                <th>Sub Category</th>
                <th class="text-right">Amount (Rs.)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rows as $row)
                <tr>
                    <td><strong>{{ $row['category'] }}</strong></td>
                    <td>{{ $row['sub_category'] }}</td>
                    <td class="text-right
                        @if($row['type'] == 'income') amount-income
                        @elseif($row['type'] == 'expense') amount-expense
                        @elseif($row['type'] == 'net') amount-net
                        @endif">
                        @if($row['type'] == 'expense') - @endif
                        Rs. {{ number_format($row['amount'], 2) }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Generated on: {{ now()->format('d M Y, h:i A') }} | Nexora Education System
    </div>
</body>
</html>