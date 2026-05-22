<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Teacher Report</title>

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

        .small {
            font-size: 9px;
        }
    </style>
</head>
<body>

<h2>Teacher Report</h2>
<div class="sub">Generated on: {{ now()->format('Y-m-d H:i') }}</div>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Teacher</th>
            <th>Contact</th>
            <th>Personal</th>
            <th>Bank Details</th>
            <th>Qualification</th>
            <th>Status</th>
        </tr>
    </thead>

    <tbody>
        @foreach($teachers as $teacher)
            <tr>
                <td>{{ $loop->iteration }}</td>

                <td>
                    <strong>{{ $teacher->full_name }}</strong>
                    <div class="small">Initials: {{ $teacher->initials }}</div>
                    <div class="small">Custom ID: {{ $teacher->custom_id }}</div>
                    <div class="small">#{{ $teacher->id }}</div>
                </td>

                <td>
                    {{ $teacher->mobile }}
                    <div class="small">{{ $teacher->email }}</div>
                </td>

                <td>
                    <div>NIC: {{ $teacher->nic }}</div>
                    <div class="small">
                        Birthday: {{ optional($teacher->bday)->format('Y-m-d') ?? 'N/A' }}
                    </div>
                    <div class="small">
                        Gender: {{ $teacher->gender ? ucfirst($teacher->gender) : 'N/A' }}
                    </div>
                </td>

                <td>
                    <strong>{{ $teacher->bankBranch->bank->bank_name ?? 'N/A' }}</strong>
                    <div class="small">
                        Branch: {{ $teacher->bankBranch->branch_name ?? 'N/A' }}
                    </div>
                    <div class="small">
                        Account: {{ $teacher->account_number ?? 'N/A' }}
                    </div>
                </td>

                <td>
                    <div>
                        <strong>Graduation:</strong>
                        {{ $teacher->graduation_details ?? '-' }}
                    </div>
                    <div class="small">
                        <strong>Experience:</strong>
                        {{ $teacher->experience ?? '-' }}
                    </div>
                </td>

                <td>
                    @if($teacher->is_active)
                        <span class="active">Active</span>
                    @else
                        <span class="inactive">Inactive</span>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>