<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>تأكيد الموعد</title>

    <style>
        body {
            font-family: 'DejaVu Sans', 'Cairo', 'Tajawal', 'Almarai', 'Helvetica Neue', Arial, sans-serif;
            font-size: 12px;
            color: #1a1a1a;
            margin: 0;
            padding: 0;
            background: #fff;
            direction: rtl;
            text-align: right;
            line-height: 1.8;
        }

        .page {
            padding: 25px 30px;
            max-width: 100%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            direction: rtl;
        }

        td {
            vertical-align: top;
        }

        .logo {
            max-height: 55px;
        }

        .barcode {
            width: 80px;
            margin-bottom: 5px;
        }

        .private {
            font-weight: bold;
            font-size: 10px;
            color: #c0392b;
            margin: 3px 0;
            letter-spacing: 0.5px;
        }

        .patient-info {
            line-height: 1.8;
            font-size: 12px;
        }

        .patient-info strong {
            font-size: 13px;
            font-weight: 700;
        }

        .right { text-align: right; }
        .left { text-align: left; }
        .center { text-align: center; }

        .service-info,
        .reference-info {
            font-size: 12px;
            line-height: 1.8;
        }

        .service-info strong,
        .reference-info strong {
            font-weight: 600;
        }

        .divider {
            border-top: 1px solid #333;
            margin: 10px 0 12px 0;
        }

        .greeting {
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 600;
        }

        .title {
            font-size: 22px;
            font-weight: 700;
            color: #1a3a5c;
            margin-bottom: 12px;
            border-bottom: 2px solid #1a3a5c;
            padding-bottom: 6px;
            letter-spacing: 0.5px;
        }

        .content {
            font-size: 12px;
            line-height: 1.8;
            margin-bottom: 10px;
        }

        .appointment-type {
            margin: 8px 0 10px 0;
            padding: 8px 14px;
            background: #f0f4f8;
            border-right: 4px solid #1a3a5c;
            font-size: 14px;
            font-weight: 600;
            color: #1a3a5c;
            border-radius: 0 4px 4px 0;
        }

        .details-table {
            margin: 8px 0 10px 0;
        }

        .details-table tr {
            border-bottom: 1px solid #e8e8e8;
        }

        .details-table tr:last-child {
            border-bottom: none;
        }

        .details-table td {
            padding: 6px 0;
            font-size: 12px;
        }

        .label {
            width: 150px;
            font-weight: 600;
            color: #555;
        }

        .value {
            font-weight: 500;
        }

        .info-box {
            padding: 12px 16px;
            border: 1px solid #d4d4d4;
            margin: 8px 0;
            background: #fafafa;
            line-height: 1.8;
            border-radius: 4px;
        }

        .info-box strong {
            font-weight: 600;
            color: #1a3a5c;
        }

        .notes-box {
            padding: 10px 14px;
            border: 1px solid #ddd;
            margin: 8px 0;
            background: #fcfcfc;
            border-radius: 4px;
        }

        .notes-box strong {
            font-weight: 600;
            color: #1a3a5c;
        }

        .footer-line {
            margin-top: 15px;
            border-top: 1px solid #333;
        }

        .footer {
            margin-top: 6px;
            font-size: 10px;
            color: #666;
            display: flex;
            justify-content: space-between;
        }

        @media print {
            body {
                background: #fff;
                direction: rtl;
                font-family: 'DejaVu Sans', 'Cairo', 'Tajawal', 'Helvetica Neue', Arial, sans-serif;
            }

            .appointment-type {
                background: #f0f4f8 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .info-box {
                background: #fafafa !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .notes-box {
                background: #fcfcfc !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }

        /* Responsive */
        @media (max-width: 600px) {
            .page {
                padding: 15px;
            }

            .header-top td,
            .header-bottom td {
                display: block;
                width: 100% !important;
                text-align: right !important;
            }

            .left {
                text-align: right !important;
            }

            .label {
                width: 100px;
            }

            .footer {
                flex-direction: column;
                gap: 3px;
                text-align: center;
            }

            .footer span {
                text-align: center !important;
            }
        }
    </style>
</head>

<body>

<div class="page">

    {{-- الترويسة --}}
    <table class="header-top">
        <tr>
            <td width="20%" class="right">
                @if (!empty($logo_path))
                    <img src="{{ public_path($logo_path) }}" class="logo" alt="الشعار">
                @else
                    <img src="{{ public_path('assets/app/images/Logo.png') }}" class="logo" alt="الشعار">
                @endif
            </td>

            <td width="60%" class="center" style="font-weight:600; font-size:13px; line-height:1.6;">
                <div style="font-size:15px; font-weight:700; color:#1a3a5c;">الجمهورية الجزائرية الديمقراطية الشعبية</div>
                <div>وزارة الصحة</div>
                <div>مديرية الصحة والسكان لولاية تلمسان</div>
            </td>

            <td width="20%" class="left">
                @if (!empty($flag_path))
                    <img src="{{ public_path($flag_path) }}" class="logo" alt="العلم">
                @else
                    <img src="{{ public_path('assets/core/icons/flag.png') }}" class="logo" alt="العلم">
                @endif
            </td>
        </tr>
    </table>

    <div class="divider"></div>

    {{-- معلومات المريض والخدمة --}}
    <table class="header-bottom">
        <tr>

            {{-- PATIENT --}}
            <td width="50%" class="right">

                @if (!empty($barcode_path))
                    <img src="{{ public_path($barcode_path) }}" class="barcode" alt="باركود">
                @endif

                <div class="private">سري وخاص</div>

                <div class="patient-info">
                    <strong>{{ $patient_name ?? '-' }}</strong><br>
                    <strong>رمز المريض:</strong> {{ $patient_code ?? '-' }}<br>
                    <strong>تاريخ الميلاد:</strong> {{ $birth_date ?? '-' }}<br>
                    <strong>الجنس:</strong> {{ $gender ?? '-' }}
                </div>

            </td>

            {{-- SERVICE --}}
            <td width="50%" class="right">

                <div class="service-info">
                    <strong>{{ $service_name ?? '-' }}</strong><br>

                    @if (!empty($specialty_name) && $specialty_name !== '-')
                        {{ $specialty_name }}<br>
                    @endif

                    @if (!empty($service_phone) && $service_phone !== '-')
                        <strong>الهاتف:</strong> {{ $service_phone }}<br>
                    @endif

                    @if (!empty($service_fax) && $service_fax !== '-')
                        <strong>الفاكس:</strong> {{ $service_fax }}
                    @endif
                </div>

                <div class="reference-info">
                    <strong>التاريخ:</strong> {{ now()->format('d/m/Y') }}<br>
                    <strong>رقم الموعد:</strong> {{ $id ?? '-' }}

                    @if (!empty($queue_number))
                        <br>
                        <strong>رقم الانتظار:</strong> {{ $queue_number }}
                    @endif
                </div>

            </td>
        </tr>
    </table>

    <div class="divider"></div>

    {{-- التحية --}}
    <div class="greeting">
        عزيزي/عزيزتي {{ $patient_name ?? 'المريض' }},
    </div>

    {{-- العنوان --}}
    <div class="title">
        تأكيد الموعد
    </div>

    {{-- المقدمة --}}
    <div class="content">
        يسعدنا تأكيد موعدك مع خدمة
        <strong>{{ $service_name ?? 'الطبية' }}</strong>.
        يرجى الحضور قبل الموعد المحدد بدقائق قليلة.
    </div>

    {{-- نوع الموعد --}}
    <div class="appointment-type">
        نوع الموعد: {{ $appointment_type ?? 'استشارة' }}
    </div>

    {{-- التفاصيل --}}
    <table class="details-table">

        <tr><td class="label">اسم المريض</td><td class="value">{{ $patient_name ?? '-' }}</td></tr>
        <tr><td class="label">رمز المريض</td><td class="value">{{ $patient_code ?? '-' }}</td></tr>
        <tr><td class="label">تاريخ الميلاد</td><td class="value">{{ $birth_date ?? '-' }}</td></tr>
        <tr><td class="label">الجنس</td><td class="value">{{ $gender ?? '-' }}</td></tr>
        <tr><td class="label">الخدمة</td><td class="value">{{ $service_name ?? '-' }}</td></tr>
        <tr><td class="label">التخصص</td><td class="value">{{ $specialty_name ?? '-' }}</td></tr>
        <tr><td class="label">نوع الموعد</td><td class="value">{{ $appointment_type ?? '-' }}</td></tr>

        <tr>
            <td class="label">تاريخ الموعد</td>
            <td class="value">
                @if (!empty($day_name)) {{ $day_name }}, @endif
                {{ $formatted_date ?? '-' }}
            </td>
        </tr>

        <tr>
            <td class="label">وقت الموعد</td>
            <td class="value">
                {{ $formatted_time ?? '-' }}
                @if (!empty($formatted_end_time) && $formatted_end_time !== '-')
                    - {{ $formatted_end_time }}
                @endif
            </td>
        </tr>

        <tr><td class="label">المكان</td><td class="value">{{ $location ?? '-' }}</td></tr>

        @if (!empty($doctor_name))
            <tr><td class="label">الطبيب</td><td class="value">{{ $doctor_name }}</td></tr>
        @endif

        @if (!empty($service_phone) && $service_phone !== '-')
            <tr><td class="label">الهاتف</td><td class="value">{{ $service_phone }}</td></tr>
        @endif

        @if (!empty($service_fax) && $service_fax !== '-')
            <tr><td class="label">الفاكس</td><td class="value">{{ $service_fax }}</td></tr>
        @endif

        @if (!empty($queue_number))
            <tr><td class="label">رقم الانتظار</td><td class="value">{{ $queue_number }}</td></tr>
        @endif

    </table>

    {{-- معلومات --}}
    <div class="info-box">
        <strong>معلومات مهمة:</strong>
        يرجى إحضار الوثائق الطبية اللازمة.
        <br>
        <strong>سياسة الإلغاء:</strong>
        يجب الإلغاء قبل <strong>3 أيام</strong> على الأقل من تاريخ الموعد.
    </div>

    {{-- ملاحظات --}}
    @if (!empty($notes))
        <div class="notes-box">
            <strong>ملاحظات:</strong> {{ $notes }}
        </div>
    @endif

    <div class="footer-line"></div>

    <div class="footer">
        <span>تأكيد الموعد</span>
        <span>{{ now()->format('d/m/Y H:i') }} | الصفحة 1/1</span>
    </div>

</div>

</body>
</html>
