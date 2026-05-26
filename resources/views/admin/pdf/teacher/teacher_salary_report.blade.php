<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Teacher Salary Report</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .title {
            margin-bottom: 15px;
        }
    </style>
</head>

<body>

    <h2 class="title">
        Teacher Salary Report - {{ $year }}/{{ str_pad($month, 2, '0', STR_PAD_LEFT) }}
    </h2>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Custom ID</th>
                <th>Initials</th>
                <th>Gross Income</th>
                <th>Advance Deduction</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody>
            @forelse($report as $index => $row)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $row['custom_id'] }}</td>
                    <td>{{ $row['initials'] }}</td>
                    <td>{{ number_format($row['gross_income'], 2) }}</td>
                    <td>{{ number_format($row['advance_deduction'], 2) }}</td>
                    <td>{{ ucfirst($row['salary_paid_status']) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" align="center">
                        No records found
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>

</html>