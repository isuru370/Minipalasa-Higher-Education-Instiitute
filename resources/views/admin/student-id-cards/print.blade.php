<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ID Card Print</title>

    <style>
        @font-face {
            font-family: 'Monbaiti';
            src: url('{{ asset('fonts/monbaiti.ttf') }}') format('truetype');
            font-weight: normal;
            font-style: normal;
            font-display: swap;
        }

        html, body {
            margin: 0;
            padding: 0;
            background: transparent;
        }

        .student-id-card {
            width: 86mm;
            height: 54mm;
            background: url('{{ asset('storage/id/idcard_bg.png') }}') no-repeat center;
            background-size: cover;
            border-radius: 3mm;
            padding: 3mm;
            position: relative;
            overflow: hidden;
            font-family: 'Monbaiti', serif !important;
        }

        .id-card-profile-box {
            width: 18mm;
            height: 22mm;
            border: 0.3mm solid #ccc;
            border-radius: 1mm;
            overflow: hidden;
            background: #fff;
        }

        .id-card-profile-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .id-card-student-id {
            font-family: 'Monbaiti', serif !important;
            font-size: 4.5mm;
            font-weight: bold;
            line-height: 1.1;
            color: #000;
        }

        .id-card-student-name {
            font-family: 'Monbaiti', serif !important;
            font-size: 4.3mm;
            line-height: 1.2;
            color: #000;
            margin-top: 0.5mm;
        }

        .id-card-address {
            font-family: 'Monbaiti', serif !important;
            font-size: 3mm;
            line-height: 1.2;
            color: #000;
            margin-top: 0.5mm;
            max-width: 45mm;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            word-wrap: break-word;
        }

        .id-card-qr-img {
            width: 18mm;
            height: 18mm;
            background: #fff;
            padding: 1mm;
            border-radius: 1mm;
        }

        .id-card-logo {
            width: 30mm;
        }
    </style>
</head>
<body>
    @php
        $student = $studentIdCard->student;

        $address = collect([
            $student?->address1,
            $student?->address2,
            $student?->address3,
        ])->filter()->implode(', ');

        $studentKey = $student?->custom_id ?? $studentIdCard->card_no ?? $studentIdCard->id;

        $defaultImage = asset('storage/logo/black_logo3.png');
        $studentImage = $student?->img_url ? $student->img_url : $defaultImage;

        if ($studentImage && !str_starts_with($studentImage, 'http')) {
            if (str_starts_with($studentImage, 'storage/')) {
                $studentImage = asset($studentImage);
            } elseif (str_starts_with($studentImage, 'uploads/')) {
                $studentImage = asset($studentImage);
            } else {
                $studentImage = asset('storage/' . ltrim($studentImage, '/'));
            }
        }

        $qrData = $student?->custom_id ?? $studentIdCard->card_no ?? 'N/A';
        $qrUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=600x600&data=' . urlencode($qrData);
    @endphp

    <div class="student-id-card">
        <div style="display:flex; flex-direction:row; width:100%; height:100%;">
            <div style="width:70%; display:flex; flex-direction:column; align-items:flex-start;">
                <div class="id-card-profile-box" style="margin-top:1mm; margin-left:1mm;">
                    <img src="{{ $studentImage }}" alt="Student Photo">
                </div>

                <div style="margin-left:1mm; margin-top:3mm; text-align:left;">
                    <div class="id-card-student-id">
                        {{ $studentKey }}
                    </div>

                    <div class="id-card-student-name" style="margin-top:1mm;">
                        {{ $student?->initial_name ?? '' }}
                    </div>

                    <div class="id-card-address" style="margin-top:1mm; max-width:45mm; overflow:hidden;">
                        {{ $address ?: 'Address not available' }}
                    </div>
                </div>
            </div>

            <div style="width:30%; display:flex; flex-direction:column; align-items:center;">
                <img src="{{ $qrUrl }}"
                     class="id-card-qr-img"
                     alt="QR Code"
                     style="margin-top:1mm;">

                <img src="{{ asset('storage/logo/black_logo3.png') }}"
                     class="id-card-logo"
                     alt="Logo"
                     style="margin-top:auto; margin-bottom:1mm;">
            </div>
        </div>
    </div>
</body>
</html>