<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #fff;
        }

        .id-card {
            width: 800px;
            height: 500px;
            border-radius: 24px;
            overflow: hidden;
            background: #ffffff;
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
            border: 1px solid #e5e7eb;
        }

        .id-card-header {
            background: linear-gradient(135deg, #0d6efd, #084298);
            padding: 30px;
            text-align: center;
            color: #fff;
        }

        .id-card-header h4 {
            margin: 0;
            font-size: 30px;
            font-weight: 700;
            letter-spacing: 1px;
        }

        .id-card-header p {
            margin: 8px 0 0;
            font-size: 16px;
        }

        .id-card-body {
            padding: 35px 25px;
            text-align: center;
        }

        .student-image {
            width: 140px;
            height: 140px;
            object-fit: cover;
            border-radius: 50%;
            border: 5px solid #0d6efd;
            background: #fff;
            margin-bottom: 20px;
        }

        .no-image {
            width: 140px;
            height: 140px;
            margin: 0 auto 20px;
            border-radius: 50%;
            background: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6c757d;
            font-size: 18px;
        }

        .student-name {
            font-size: 30px;
            font-weight: 700;
            color: #212529;
            margin-bottom: 8px;
        }

        .student-id {
            font-size: 20px;
            color: #6c757d;
            margin-bottom: 18px;
        }

        .student-address {
            background: #f8f9fa;
            border-radius: 14px;
            padding: 14px 18px;
            font-size: 18px;
            color: #495057;
            line-height: 1.6;
            display: inline-block;
            min-width: 60%;
        }

        .id-card-footer {
            background: #f8f9fa;
            text-align: center;
            padding: 12px;
            font-size: 14px;
            color: #6c757d;
            border-top: 1px solid #dee2e6;
        }
    </style>
</head>
<body>
    <div class="id-card">
        <div class="id-card-header">
            <h4>STUDENT ID CARD</h4>
            <p>Student Management System</p>
        </div>

        <div class="id-card-body">
            @if($studentIdCard->student->img_url ?? false)
                <img
                    src="{{ asset('storage/' . $studentIdCard->student->img_url) }}"
                    class="student-image"
                    alt="Student Image"
                >
            @else
                <div class="no-image">No Image</div>
            @endif

            <div class="student-name">
                {{ $studentIdCard->student->initial_name ?? '-' }}
            </div>

            <div class="student-id">
                {{ $studentIdCard->student->custom_id ?? '-' }}
            </div>

            <div class="student-address">
                <strong>Address</strong><br>
                {{ $studentIdCard->student->address1 ?? '' }}
                {{ $studentIdCard->student->address2 ?? '' }}
                {{ $studentIdCard->student->address3 ?? '' }}
            </div>
        </div>

        <div class="id-card-footer">
            Generated Student Identification Card
        </div>
    </div>
</body>
</html>