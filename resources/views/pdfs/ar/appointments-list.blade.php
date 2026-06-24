<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>قائمة المواعيد</title>

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
            vertical-align: middle;
            padding: 4px 0;
        }

        .header-top td {
            vertical-align: middle;
            padding: 2px 0;
        }

        .logo {
            max-height: 55px;
        }

        .right { text-align: right; }
        .left { text-align: left; }
        .center { text-align: center; }

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

        .subtitle {
            font-size: 14px;
            color: #555;
            margin-top: 2px;
            margin-bottom: 8px;
        }

        .filter-info {
            font-size: 12px;
            color: #555;
            margin-bottom: 12px;
            line-height: 1.8;
        }

        .filter-info strong {
            color: #1a3a5c;
        }

        .appointments-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 11px;
        }

        .appointments-table th {
            background-color: #1a3a5c;
            color: #fff;
            font-weight: 700;
            padding: 10px 8px;
            text-align: right;
            border: 1px solid #1a3a5c;
            font-size: 12px;
        }

        .appointments-table td {
            padding: 8px 6px;
            border: 1px solid #ddd;
            vertical-align: middle;
            font-size: 12px;
        }

        .appointments-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .appointments-table tr:hover {
            background-color: #f1f1f1;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .summary-box {
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            padding: 12px 18px;
            margin-bottom: 15px;
            border-radius: 4px;
        }

        .summary-box table {
            width: 100%;
            font-size: 12px;
        }

        .summary-box td {
            padding: 4px 10px 4px 0;
        }

        .summary-box .label {
            font-weight: 600;
            color: #555;
            width: 160px;
        }

        .summary-box .value {
            font-weight: 600;
            color: #1a1a1a;
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

        .location-info {
            padding: 12px 16px;
            border: 1px solid #d4d4d4;
            margin: 8px 0 15px 0;
            font-size: 12px;
            line-height: 1.8;
            background: #fafafa;
            border-radius: 4px;
        }

        .location-info strong {
            font-weight: 700;
            color: #1a3a5c;
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

            .appointments-table th {
                background-color: #1a3a5c !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .appointments-table tr:nth-child(even) {
                background-color: #f9f9f9 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .summary-box {
                background: #f8f9fa !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .location-info {
                background: #fafafa !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }

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

            .appointments-table {
                font-size: 9px;
            }

            .appointments-table th,
            .appointments-table td {
                padding: 4px;
                font-size: 9px;
            }

            .title {
                font-size: 18px;
            }

            .footer {
                flex-direction: column;
                gap: 3px;
                text-align: center;
            }

            .footer span {
                text-align: center !important;
            }

            .summary-box .label {
                width: 100px;
            }
        }
    </style>
</head>

<body>

    @php
        $itemsPerPage = 20;
        $pages = $appointments->chunk($itemsPerPage);

        if ($pages->isEmpty()) {
            $pages = collect([collect()]);
        }

        $totalPages = $pages->count();

        $locationName = $appointments->first()?->location_name ?? null;
        $locationAddress = $appointments->first()?->address ?? null;
    @endphp

    @foreach ($pages as $pageIndex => $items)
        @if ($pageIndex > 0)
            <div class="page-break" style="page-break-before: always;"></div>
        @endif

        <div class="page">
            {{-- الرأس --}}
            <table class="header-top">
                <tr>
                    <td width="20%" class="right">
                        @if (!empty($flag_path))
                            <img src="{{ public_path($flag_path) }}" class="logo" alt="العلم">
                        @else
                            <img src="{{ public_path('assets/core/icons/flag.png') }}" class="logo" alt="العلم">
                        @endif
                    </td>

                    <td width="60%" class="center" style="font-weight:600; font-size:13px; line-height:1.6;">
                        <div style="font-size:15px; font-weight:700; color:#1a3a5c;">الجمهورية الجزائرية الديمقراطية الشعبية</div>
                        <div>وزارة الصحة</div>
                        <div>مديرية الصحة والسكان لولاية تلمسان</div>
                    </td>

                    <td width="20%" class="left">
                        @if (!empty($logo_path))
                            <img src="{{ public_path($logo_path) }}" class="logo" alt="الشعار">
                        @else
                            <img src="{{ public_path('assets/app/images/Logo.png') }}" class="logo" alt="الشعار">
                        @endif
                    </td>
                </tr>
            </table>

            <div class="divider"></div>

            {{-- العنوان --}}
            <div class="title">
                قائمة المواعيد
            </div>

            {{-- العنوان الفرعي --}}
            <div class="subtitle">
                @if ($specialty)
                    التخصص: {{ $specialty }}
                    @if ($service)
                        |
                    @endif
                @endif
                @if ($service)
                    الخدمة: {{ $service }}
                @endif
                @if (!$specialty && !$service)
                    جميع المواعيد
                @endif
            </div>

            {{-- معلومات الموقع --}}
            @if ($locationName && $locationName !== '-')
                <div class="location-info">
                    <strong>مكان الموعد:</strong> {{ $locationName }}
                    @if ($locationAddress && $locationAddress !== '-')
                        <br><strong>العنوان:</strong> {{ $locationAddress }}
                    @endif
                </div>
            @endif

            {{-- الملخص --}}
            <div class="summary-box">
                <table>
                    <tr>
                        <td class="label">تاريخ القائمة</td>
                        <td class="value">{{ $datePart }}</td>
                        <td class="label">إجمالي المواعيد</td>
                        <td class="value">{{ $totalCount }}</td>
                    </tr>
                    <tr>
                        <td class="label">تم الإنشاء في</td>
                        <td class="value">{{ $generatedAt }}</td>
                        <td class="label">المؤسسة</td>
                        <td class="value">{{ $locationName ?? 'غير محدد' }}</td>
                    </tr>
                </table>
            </div>

            {{-- جدول المواعيد --}}
            <table class="appointments-table">
                <thead>
                    <tr>
                        <th width="17%">الرمز</th>
                        <th width="22%">المريض</th>
                        <th width="25%">الخدمة</th>
                        <th width="25%">التخصص</th>
                        <th width="12%">التاريخ</th>
                        <th width="9%">الوقت</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($items as $index => $appointment)
                        <tr>
                            <td>
                                {{ $appointment->patient_code ?? '-' }}
                            </td>

                            <td>
                                {{ $appointment->patient_name ?? '-' }}
                            </td>

                            <td>
                                {{ $appointment->service ?? '-' }}
                            </td>
                            <td>
                                {{ $appointment->specialty ?? '-' }}
                            </td>
                            <td>
                                {{ $appointment->day_at ? \Carbon\Carbon::parse($appointment->day_at)->format('d/m/Y') : '-' }}
                            </td>
                            <td class="text-center">
                                {{ $appointment->start_at ? \Carbon\Carbon::parse($appointment->start_at)->format('H:i') : '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center" style="padding: 20px;">
                                لا توجد مواعيد
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- التذييل --}}
            <div class="footer-line"></div>

            <div class="footer">
                <span>قائمة المواعيد</span>
                <span>تم الإنشاء: {{ now()->format('d/m/Y H:i') }} | الصفحة
                    {{ $pageIndex + 1 }}/{{ $totalPages }}</span>
            </div>
        </div>
    @endforeach

    {{-- ترقيم الصفحات --}}
    <script type="text/php">
    if (isset($pdf)) {
        $font = $fontMetrics->get_font("DejaVu Sans", "normal");
        $size = 9;
        $pageText = "الصفحة " . $PAGE_NUM . "/" . $PAGE_COUNT;

        $x = 510;
        $y = 820;

        $pdf->text($x, $y, $pageText, $font, $size);
    }
</script>

</body>

</html>
