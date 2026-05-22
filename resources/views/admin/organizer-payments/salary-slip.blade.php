<!DOCTYPE html>
<html>

<head>
    <title>Organizer Salary Slip</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: #000;
        }

        .slip {
            width: 800px;
            margin: 20px auto;
            border: 1px solid #000;
            padding: 20px;
        }

        .text-center {
            text-align: center;
        }

        .text-end {
            text-align: right;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
        }

        th {
            background: #f2f2f2;
        }

        .no-border td {
            border: none;
            padding: 4px;
        }

        .total {
            font-weight: bold;
            font-size: 16px;
        }

        @media print {
            .no-print {
                display: none;
            }

            body {
                margin: 0;
            }

            .slip {
                margin: 0 auto;
            }
        }
    </style>
</head>

<body>

    <div class="slip">

        <div class="text-center">
            <h2>Organizer Salary Slip</h2>
            <p>{{ $year }}-{{ str_pad($month, 2, '0', STR_PAD_LEFT) }}</p>
        </div>

        <table class="no-border">
            <tr>
                <td><strong>Organizer Code:</strong></td>
                <td>{{ $organizer->code }}</td>
                <td><strong>Date:</strong></td>
                <td>{{ now()->format('Y-m-d') }}</td>
            </tr>

            <tr>
                <td><strong>Organizer Name:</strong></td>
                <td>{{ $organizer->name }}</td>
                <td><strong>Payment Status:</strong></td>
                <td>{{ ucfirst($salaryRecord->status) }}</td>
            </tr>

            <tr>
                <td><strong>Mobile:</strong></td>
                <td>{{ $organizer->mobile ?? '-' }}</td>
                <td><strong>Paid Date:</strong></td>
                <td>{{ $salaryRecord->payment_date?->format('Y-m-d') }}</td>
            </tr>
        </table>

        <table>
            <thead>
                <tr>
                    <th>Description</th>
                    <th class="text-end">Amount</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td>Total Income</td>
                    <td class="text-end">{{ number_format($totalIncome, 2) }}</td>
                </tr>

                <tr>
                    <td>Advance Deduction</td>
                    <td class="text-end">- {{ number_format($advanceAmount, 2) }}</td>
                </tr>

                <tr>
                    <td>Deduction</td>
                    <td class="text-end">- {{ number_format($deductionAmount, 2) }}</td>
                </tr>

                <tr>
                    <td>Other</td>
                    <td class="text-end">- {{ number_format($otherAmount, 2) }}</td>
                </tr>

                <tr class="total">
                    <td>Net Salary Paid</td>
                    <td class="text-end">{{ number_format($salaryRecord->amount, 2) }}</td>
                </tr>
            </tbody>
        </table>

        <br><br>

        <table class="no-border">
            <tr>
                <td>
                    _______________________<br>
                    Prepared By
                </td>

                <td class="text-end">
                    _______________________<br>
                    Organizer Signature
                </td>
            </tr>
        </table>

        <div class="text-center no-print" style="margin-top: 20px;">
            <button onclick="window.print()">
                Print
            </button>
        </div>

    </div>

</body>

</html>