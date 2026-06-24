<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>ملف المريض</title>

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

        .divider {
            border-top: 1px solid #333;
            margin: 10px 0 12px 0;
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

        .label {
            font-weight: 600;
            color: #555;
            width: 150px;
        }

        .value {
            font-weight: 500;
        }

        .info-box {
            padding: 12px 16px;
            border: 1px solid #d4d4d4;
            margin: 10px 0;
            background: #fafafa;
            line-height: 1.8;
            border-radius: 4px;
        }

        .info-box strong {
            font-weight: 600;
            color: #1a3a5c;
        }

        .account-box {
            padding: 12px 16px;
            border: 1px solid #ddd;
            margin: 10px 0;
            background: #fcfcfc;
            border-radius: 4px;
        }

        .account-box strong {
            font-weight: 600;
            color: #1a3a5c;
        }

        .warning {
            color: #c0392b;
            font-weight: bold;
            margin-top: 8px;
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
            align-items: center;
        }

        .portal-message {
            background: #e8f0fe;
            border-right: 4px solid #1a73e8;
            padding: 12px 16px;
            margin: 12px 0;
            font-size: 13px;
            line-height: 1.8;
            border-radius: 2px;
        }

        .portal-message strong {
            color: #1a3c6e;
        }

        .portal-message .highlight {
            color: #1a73e8;
            font-weight: bold;
        }

        .portal-message ul {
            margin: 6px 20px 4px 0;
            padding: 0;
        }

        .portal-message ul li {
            margin-bottom: 2px;
        }

        @media print {
            body {
                background: #fff;
                direction: rtl;
                font-family: 'DejaVu Sans', 'Cairo', 'Tajawal', 'Helvetica Neue', Arial, sans-serif;
            }
            .page {
                padding: 20px 25px;
            }
            .info-box {
                background: #fafafa !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .account-box {
                background: #fcfcfc !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .portal-message {
                background: #e8f0fe !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }

        @media (max-width: 600px) {
            .page {
                padding: 15px;
            }
            .header-top td {
                display: block;
                width: 100% !important;
                text-align: center !important;
            }
            .header-top td:first-child,
            .header-top td:last-child {
                text-align: center !important;
            }
            .footer {
                flex-direction: column;
                gap: 3px;
                text-align: center;
            }
            .label {
                width: 100px;
            }
        }
    </style>
</head>

<body>

    <div class="page">

        {{-- الترويسة / HEADER (كما في نموذج تأكيد الموعد) --}}
        <table class="header-top">
            <tr>
                <td width="20%" style="text-align:right;">
                    @if (!empty($logo_path))
                        <img src="{{ public_path($logo_path) }}" class="logo" alt="الشعار">
                    @else
                        <img src="{{ public_path('assets/app/images/Logo.png') }}" class="logo" alt="الشعار">
                    @endif
                </td>

                <td width="60%" style="text-align:center; font-weight:600; font-size:13px; line-height:1.6;">
                    <div style="font-size:15px; font-weight:700; color:#1a3a5c;">الجمهورية الجزائرية الديمقراطية الشعبية</div>
                    <div>وزارة الصحة</div>
                    <div>مديرية الصحة والسكان لولاية تلمسان</div>
                </td>

                <td width="20%" style="text-align:left;">
                    @if (!empty($flag_path))
                        <img src="{{ public_path($flag_path) }}" class="logo" alt="العلم">
                    @else
                        <img src="{{ public_path('assets/core/icons/flag.png') }}" class="logo" alt="العلم">
                    @endif
                </td>
            </tr>
        </table>

        <div class="divider"></div>

        {{-- العنوان --}}
        <div class="title">
            ملف المريض
        </div>

        {{-- معلومات المريض --}}
        <div class="info-box">
            <strong>معلومات المريض</strong><br><br>

            <span class="label">الاسم :</span> <span class="value">{{ $patient_name ?? '-' }}</span><br>
            <span class="label">الرمز :</span> <span class="value">{{ $patient_code ?? '-' }}</span><br>
            <span class="label">تاريخ الميلاد :</span> <span class="value">{{ $birth_date ?? '-' }}</span><br>
            <span class="label">الجنس :</span> <span class="value">{{ $gender ?? '-' }}</span><br>
            <span class="label">البلدية :</span> <span class="value">{{ $commune ?? '-' }}</span><br>
            <span class="label">الهاتف :</span> <span class="value">{{ $patient_tel ?? '-' }}</span><br>
            <span class="label">البريد الإلكتروني :</span> <span class="value">{{ $patient_email ?? '-' }}</span>
        </div>

        {{-- ★ رسالة البوابة — دعوة صريحة لتسجيل الدخول --}}
        <div class="portal-message">
            <strong>🔐 سجّل الدخول إلى حسابك الشخصي</strong><br>
            من خلال تسجيل الدخول إلى منصة إدارة المواعيد، ستتمكن من:
            <ul>
                <li>الاطلاع على تاريخ مواعيدك و <span class="highlight">متابعة مواعيد المتابعة</span>.</li>
                <li>حجز <span class="highlight">مواعيد جديدة</span> لنفسك أو لأقاربك / المعالين.</li>
                <li>استلام التذكيرات وإدارة تفضيلاتك عبر الإنترنت.</li>
            </ul>
            <div style="margin-top: 8px; font-weight: 500;">
                👉 <span style="color: #1a73e8;">استخدم بيانات الدخول أدناه للوصول إلى جميع هذه الخدمات.</span>
            </div>
        </div>

        {{-- بيانات الدخول --}}
        <div class="account-box">

            <strong>الوصول إلى الحساب الشخصي</strong><br><br>

            <span class="label">المنصة :</span>
            <span class="value">نظام إدارة المواعيد الطبية</span><br>
            <span class="label">الميزات :</span>
            <span class="value">
                استشارة المواعيد، الحجز عبر الإنترنت، المتابعة الطبية، إدارة الأقارب
            </span><br><br>

            <strong>معلومات تسجيل الدخول :</strong><br><br>
            <span class="label">اسم المستخدم :</span>
            <span class="value">{{ $opened_by['name'] ?? '-' }}</span><br>
            <span class="label">كلمة المرور المؤقتة :</span>
            <span class="value">12345678</span><br>

            <div class="warning">
                ⚠️ يرجى تغيير كلمة المرور بعد أول تسجيل دخول.
            </div>

            {{-- تذكير إضافي --}}
            <div style="margin-top: 8px; font-size: 12px; color: #2c3e50; border-top: 1px dashed #ccc; padding-top: 6px;">
                <strong>💡 نصيحة :</strong> بمجرد تسجيل الدخول، يمكنك أيضاً إضافة أفراد عائلتك لإدارة مواعيدهم.
            </div>

        </div>

        {{-- التذييل --}}
        <div class="footer-line"></div>

        <div class="footer">
            <span>ملف المريض</span>
            <span>تاريخ الإنشاء : {{ now()->format('d/m/Y H:i') }} | الصفحة 1/1</span>
        </div>

    </div>

</body>

</html>
