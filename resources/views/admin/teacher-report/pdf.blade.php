<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #222;
        }

        h2 {
            margin-bottom: 5px;
        }

        .meta {
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table th,
        table td {
            border: 1px solid #ccc;
            padding: 6px;
            font-size: 11px;
        }

        table th {
            background: #f2f2f2;
        }

        .text-right {
            text-align: right;
        }

        .total-row {
            background: #fafafa;
            font-weight: bold;
        }
    </style>
</head>
<body>

<h2>{{ $title }}</h2>

<div class="meta">
    <strong>Date:</strong> {{ $date }} <br>
    <strong>Teacher ID:</strong> {{ $teacher_id }} <br>
    <strong>Total Paid:</strong> Rs. {{ number_format($summary_value, 2) }}
</div>

<table>
    <thead>
    <tr>
        <th>Class</th>
        <th>Grade</th>
        <th>Category</th>
        <th>Student Code</th>
        <th>Student Name</th>
        <th>Guardian Mobile</th>
        <th>Payment ID</th>
        <th>Paid At</th>
        <th>Amount</th>
        <th>Method</th>
    </tr>
    </thead>

    <tbody>
    @forelse($rows as $row)
        <tr>
            <td>{{ $row['class_name'] }}</td>
            <td>{{ $row['grade_name'] }}</td>
            <td>{{ $row['category_name'] }}</td>
            <td>{{ $row['student_code'] }}</td>
            <td>{{ $row['student_name'] }}</td>
            <td>{{ $row['guardian_mobile'] }}</td>
            <td>{{ $row['payment_id'] }}</td>
            <td>{{ $row['paid_at'] }}</td>
            <td class="text-right">
                {{ number_format($row['amount'], 2) }}
            </td>
            <td>{{ $row['payment_method'] }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="10" align="center">
                No records found.
            </td>
        </tr>
    @endforelse
    </tbody>

    <tfoot>
    <tr class="total-row">
        <td colspan="8" class="text-right">
            Total
        </td>
        <td class="text-right">
            Rs. {{ number_format($summary_value, 2) }}
        </td>
        <td></td>
    </tr>
    </tfoot>
</table>

</body>
</html>