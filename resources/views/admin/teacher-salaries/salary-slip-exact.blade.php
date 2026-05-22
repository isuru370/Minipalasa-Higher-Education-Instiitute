<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <title>
        Salary Slip - {{ $data['teacher_name'] ?? 'Teacher' }}
    </title>

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 35px;
            font-size: 13px;
            color: #111;
        }

        .top-section {
            width: 100%;
            margin-bottom: 25px;
        }

        .top-table {
            width: 100%;
            border: none;
        }

        .top-table td {
            border: none;
            vertical-align: top;
        }

        .logo {
            width: 85px;
        }

        .header-center {
            text-align: center;
        }

        .header-center h2 {
            margin: 0;
            font-size: 24px;
            font-weight: 700;
        }

        .header-center h3 {
            margin: 4px 0;
            font-size: 16px;
        }

        .date-box {
            text-align: right;
            font-size: 12px;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .info-table th,
        .info-table td {
            border: 1px solid #dcdcdc;
            padding: 8px 10px;
        }

        .info-table th {
            background: #f5f5f5;
            width: 180px;
            text-align: left;
        }

        .main-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 18px;
        }

        .main-table th,
        .main-table td {
            border: 1px solid #000;
            padding: 8px;
            vertical-align: top;
        }

        .main-table th {
            background: #f3f3f3;
        }

        .right {
            text-align: right;
        }

        .center {
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }

        .small-text {
            font-size: 11px;
            color: #555;
            margin-top: 4px;
            line-height: 1.5;
        }

        .summary-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .summary-table th,
        .summary-table td {
            border: 1px solid #dcdcdc;
            padding: 8px 10px;
        }

        .summary-table th {
            background: #f7f7f7;
            text-align: left;
        }

        .paid {
            color: green;
            font-weight: bold;
        }

        .unpaid {
            color: #777;
            font-weight: bold;
        }

        .signature-area {
            margin-top: 50px;
            width: 100%;
        }

        .signature-table {
            width: 100%;
            border: none;
        }

        .signature-table td {
            border: none;
            width: 50%;
            text-align: center;
            padding-top: 40px;
        }

        .signature-line {
            border-top: 1px solid #000;
            display: inline-block;
            width: 220px;
            padding-top: 5px;
        }

        .error-message {
            text-align: center;
            margin-top: 100px;
            color: red;
        }

        @media print {
            body {
                margin: 15px;
            }
        }
    </style>
</head>

<body>

    @php

        $data = $data ?? [];

        $isSuccess = ($data['status'] ?? '') === 'success';

        $teacherId = $data['teacher_id'] ?? '';

        $teacherName = $data['teacher_name'] ?? '';

        $monthYearDisplay = $data['month_year_display'] ?? '';

        $dateGenerated = $data['date_generated'] ?? '';

        $isSalaryPaid = $data['is_salary_paid'] ?? false;

        $earnings = $data['earnings'] ?? [];

        $deductions = $data['deductions'] ?? [];

        $totalClassAmount = $data['total_class_amount'] ?? 0;

        $totalTeacherEarnings = $data['total_teacher_earnings'] ?? 0;

        $totalOrganizeCut = $data['total_organize_cut'] ?? 0;

        $totalInstitutionCut = $data['total_institution_cut'] ?? 0;

        $totalAddition = $data['total_addition'] ?? 0;

        $totalDeductions = $data['total_deductions'] ?? 0;

        $netSalary = $data['net_salary'] ?? 0;

        $paymentMethod = $data['payment_method'] ?? 'Cash / Bank Transfer';

    @endphp

    @if(!$isSuccess)

        <div class="error-message">

            <h2>Salary Slip Load Failed</h2>

            <p>
                {{ $data['message'] ?? 'Unknown error occurred.' }}
            </p>

        </div>

    @else

        {{-- ====================================================== --}}
        {{-- HEADER --}}
        {{-- ====================================================== --}}

        <div class="top-section">

            <table class="top-table">

                <tr>

                    <td width="15%">

                        <img src="{{ asset('uploads/logo/black_logo.png') }}" class="logo" alt="Logo">

                    </td>

                    <td width="70%" class="header-center">

                        <h2>NEXORA HIGHER EDUCATION</h2>

                        <h3>Mirigama</h3>

                        <h3>Teacher Salary Slip</h3>

                    </td>

                    <td width="15%" class="date-box">

                        <strong>Date</strong><br>

                        {{ $dateGenerated }}

                    </td>

                </tr>

            </table>

        </div>

        {{-- ====================================================== --}}
        {{-- TEACHER INFO --}}
        {{-- ====================================================== --}}

        <table class="info-table">

            <tr>
                <th>Teacher ID</th>
                <td>{{ $teacherId }}</td>

                <th>Teacher Name</th>
                <td>{{ $teacherName }}</td>
            </tr>

            <tr>
                <th>Salary Period</th>
                <td>{{ $monthYearDisplay }}</td>

                <th>Payment Status</th>
                <td class="{{ $isSalaryPaid ? 'paid' : 'unpaid' }}">
                    {{ $isSalaryPaid ? 'PAID' : 'UNPAID' }}
                </td>
            </tr>

        </table>

        {{-- ====================================================== --}}
        {{-- EARNINGS + DEDUCTIONS --}}
        {{-- ====================================================== --}}

        <table class="main-table">

            <thead>

                <tr class="bold">

                    <th width="40%">
                        Earnings
                    </th>

                    <th width="15%" class="right">
                        Amount
                    </th>

                    <th width="30%">
                        Deductions
                    </th>

                    <th width="15%" class="right">
                        Amount
                    </th>

                </tr>

            </thead>

            <tbody>

                @php
                    $maxRows = max(count($earnings), count($deductions));
                @endphp

                @for($i = 0; $i < $maxRows; $i++)

                    <tr>

                        {{-- ========================================= --}}
                        {{-- EARNINGS --}}
                        {{-- ========================================= --}}

                        @if(isset($earnings[$i]))

                            <td>

                                <strong>
                                    {{ $earnings[$i]['description'] ?? '' }}
                                </strong>

                                <div class="small-text">
                                    {{ isset($earnings[$i]['class_total']) ? 'Class Total: Rs. ' . number_format($earnings[$i]['class_total'], 2) : '' }}<br>

                                    Teacher %: {{ $earnings[$i]['teacher_percentage'] ?? 0 }}% = Rs.
                                    {{ number_format($earnings[$i]['teacher_share'] ?? 0, 2) }}
                                </div>

                            </td>

                            <td class="right">

                                {{ number_format($earnings[$i]['amount'] ?? 0, 2) }}

                            </td>

                        @else

                            <td></td>
                            <td></td>

                        @endif

                        {{-- ========================================= --}}
                        {{-- DEDUCTIONS --}}
                        {{-- ========================================= --}}

                        @if(isset($deductions[$i]))

                            <td>

                                {{ $deductions[$i]['description'] ?? '' }}

                            </td>

                            <td class="right">

                                {{ number_format($deductions[$i]['amount'] ?? 0, 2) }}

                            </td>

                        @else

                            <td></td>
                            <td></td>

                        @endif

                    </tr>

                @endfor

                {{-- ========================================= --}}
                {{-- TOTALS --}}
                {{-- ========================================= --}}

                <tr class="bold">

                    <td>
                        Total Earnings
                    </td>

                    <td class="right">
                        {{ number_format($totalAddition, 2) }}
                    </td>

                    <td>
                        Total Deductions
                    </td>

                    <td class="right">
                        {{ number_format($totalDeductions, 2) }}
                    </td>

                </tr>

                <tr class="bold">

                    <td colspan="3">
                        Net Salary
                    </td>

                    <td class="right">
                        {{ number_format($netSalary, 2) }}
                    </td>

                </tr>

            </tbody>

        </table>

        {{-- ====================================================== --}}
        {{-- SUMMARY --}}
        {{-- ====================================================== --}}

        <table class="summary-table">

            <tr>

                <th>Total Class Income</th>

                <td>
                    Rs. {{ number_format($totalClassAmount, 2) }}
                </td>

                <th>Total Teacher Earnings</th>

                <td>
                    Rs. {{ number_format($totalTeacherEarnings, 2) }}
                </td>

            </tr>

            <tr>

                <th>Total Organizer</th>

                <td>
                    Rs. {{ number_format($totalOrganizeCut, 2) }}
                </td>

                <th>Total Institute</th>

                <td>
                    Rs. {{ number_format($totalInstitutionCut, 2) }}
                </td>

            </tr>

            <tr>

                <th>Payment Method</th>

                <td>
                    {{ $paymentMethod }}
                </td>

                <th>Salary Month</th>

                <td>
                    {{ $monthYearDisplay }}
                </td>

            </tr>

        </table>

        {{-- ====================================================== --}}
        {{-- SIGNATURE --}}
        {{-- ====================================================== --}}

        <div class="signature-area">

            <table class="signature-table">

                <tr>

                    <td>

                        <div class="signature-line">
                            Teacher Signature
                        </div>

                    </td>

                    <td>

                        <div class="signature-line">
                            Authorized Signature
                        </div>

                    </td>

                </tr>

            </table>

        </div>

    @endif

    <script>

        window.addEventListener('load', function () {

            const urlParams = new URLSearchParams(window.location.search);

            if (urlParams.get('autoPrint') === 'true') {

                setTimeout(() => {

                    window.print();

                }, 800);
            }
        });

    </script>

</body>

</html>