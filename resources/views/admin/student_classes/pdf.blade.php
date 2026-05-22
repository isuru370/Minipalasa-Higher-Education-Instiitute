<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Student Classes Report</title>

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
            vertical-align: top;
        }

        th {
            background: #f2f2f2;
            font-weight: bold;
        }

        .active {
            color: green;
            font-weight: bold;
        }

        .inactive {
            color: gray;
            font-weight: bold;
        }

        .ongoing {
            color: blue;
            font-weight: bold;
        }

        .small {
            font-size: 9px;
        }
    </style>
</head>
<body>

<h2>Student Classes Report</h2>
<div class="sub">Generated on: {{ now()->format('Y-m-d H:i') }}</div>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Class</th>
            <th>Teacher</th>
            <th>Grade / Subject</th>
            <th>Payment</th>
            <th>Organizer</th>
            <th>Effective Dates</th>
            <th>Status</th>
        </tr>
    </thead>

    <tbody>
        @foreach($classes as $class)
            <tr>
                <td>{{ $loop->iteration }}</td>

                <td>
                    <strong>{{ $class->class_name }}</strong>
                    <div class="small">{{ ucfirst($class->class_type) }} / {{ $class->medium }}</div>
                </td>

                <td>
                    {{ $class->teacher->full_name ?? 'N/A' }}
                    <div class="small">{{ $class->teacher->custom_id ?? '' }}</div>
                </td>

                <td>
                    <strong>{{ $class->grade->grade_name ?? 'N/A' }}</strong>
                    <div class="small">{{ $class->subject->subject_name ?? 'N/A' }}</div>
                </td>

                <td>
                    <div class="small">Teacher: {{ $class->paymentConfig->teacher_percentage ?? '0.00' }}%</div>
                    <div class="small">Organizer: {{ $class->paymentConfig->organizer_percentage ?? '0.00' }}%</div>
                    <div class="small">Institution: {{ $class->paymentConfig->institution_percentage ?? '0.00' }}%</div>
                </td>

                <td>
                    {{ $class->paymentConfig->organizer->name ?? 'None' }}
                </td>

                <td>
                    <div class="small">
                        From: {{ optional($class->paymentConfig?->effective_from)->format('Y-m-d') ?? 'N/A' }}
                    </div>
                    <div class="small">
                        To: {{ optional($class->paymentConfig?->effective_to)->format('Y-m-d') ?? 'N/A' }}
                    </div>
                </td>

                <td>
                    @if($class->is_active)
                        <span class="active">Active</span>
                    @else
                        <span class="inactive">Inactive</span>
                    @endif

                    <div class="small">
                        @if($class->is_ongoing)
                            <span class="ongoing">Ongoing</span>
                        @else
                            Not Ongoing
                        @endif
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>