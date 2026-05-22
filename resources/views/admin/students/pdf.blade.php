<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Students Report</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
        }

        h2 {
            text-align: center;
            margin-bottom: 5px;
        }

        .sub {
            text-align: center;
            margin-bottom: 10px;
            font-size: 9px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #333;
            padding: 5px;
            text-align: left;
        }

        th {
            background: #f2f2f2;
            font-weight: bold;
        }

        .active { color: green; font-weight: bold; }
        .inactive { color: gray; }
        .deleted { color: red; font-weight: bold; }

        .badge {
            padding: 2px 4px;
            border-radius: 3px;
        }

        .paid { background: #d1ecf1; }
        .pending { background: #f8d7da; }

        .small {
            font-size: 9px;
        }
    </style>
</head>
<body>

<h2>Students Report</h2>
<div class="sub">Generated on: {{ now()->format('Y-m-d H:i') }}</div>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>ID</th>
            <th>QR</th>
            <th>Name</th>
            <th>Contact</th>
            <th>Grade</th>
            <th>Class</th>
            <th>Guardian</th>
            <th>Status</th>
        </tr>
    </thead>

    <tbody>
        @foreach($students as $student)
            <tr>

                <td>{{ $loop->iteration }}</td>

                <td>
                    {{ $student->custom_id }}
                    <div class="small">#{{ $student->id }}</div>
                </td>

                <td>
                    @if($student->permanent_qr_active)
                        <strong>{{ $student->custom_id }}</strong>
                        <div class="small">Permanent</div>
                    @else
                        <strong>{{ $student->temporary_qr_code }}</strong>
                        <div class="small">
                            @php
                                $expire = $student->temporary_qr_code_expire_date;
                                $days = $expire ? now()->diffInDays($expire, false) : null;
                            @endphp

                            @if($days === null)
                                No expiry
                            @elseif($days < 0)
                                Expired {{ abs($days) }}d
                            @elseif($days == 0)
                                Expires today
                            @else
                                {{ $days }} days left
                            @endif
                        </div>
                    @endif
                </td>

                <td>
                    <strong>{{ $student->full_name }}</strong>
                    <div class="small">{{ $student->initial_name }}</div>
                    <div class="small">{{ $student->nic ?? '' }}</div>
                </td>

                <td>
                    {{ $student->mobile }}
                    <div class="small">{{ $student->whatsapp_mobile }}</div>
                    <div class="small">{{ $student->email }}</div>
                </td>

                <td>
                    {{ $student->grade->grade_name ?? 'N/A' }}
                </td>

                <td>
                    {{ ucfirst($student->class_type) }}
                </td>

                <td>
                    {{ $student->guardian_mobile }}
                    <div class="small">
                        {{ $student->guardian_fname }} {{ $student->guardian_lname }}
                    </div>
                </td>

                <td>
                    @if($student->trashed())
                        <span class="deleted">Deleted</span>
                    @elseif($student->is_active)
                        <span class="active">Active</span>
                    @else
                        <span class="inactive">Inactive</span>
                    @endif

                    <div class="small">
                        @if($student->admission)
                            <span class="paid">Paid</span>
                        @else
                            <span class="pending">Pending</span>
                        @endif
                    </div>
                </td>

            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>