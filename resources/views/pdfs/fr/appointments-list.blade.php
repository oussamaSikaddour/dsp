<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Liste des Rendez-vous</title>

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            color: #000;
            margin: 0;
            padding: 0;
            background: #fff;
        }

        .page {
            padding: 25px 30px;
            max-width: 100%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .header-table {
            width: 100%;
        }

        .header-table td {
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

        .right {
            text-align: right;
        }

        .left {
            text-align: left;
        }

        .center {
            text-align: center;
        }

        .divider {
            border-top: 1px solid #333;
            margin: 10px 0 12px 0;
        }

        .title {
            font-size: 20px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 2px solid #2c3e50;
        }

        .subtitle {
            font-size: 13px;
            color: #555;
            margin-top: 2px;
        }

        .filter-info {
            font-size: 12px;
            color: #555;
            margin-bottom: 12px;
            line-height: 1.8;
        }

        .filter-info strong {
            color: #2c3e50;
        }

        .appointments-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 11px;
        }

        .appointments-table th {
            background-color: #2c3e50;
            color: #fff;
            font-weight: bold;
            padding: 8px 6px;
            text-align: left;
            border: 1px solid #2c3e50;
        }

        .appointments-table td {
            padding: 6px;
            border: 1px solid #ddd;
            vertical-align: middle;
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
            padding: 10px 15px;
            margin-bottom: 15px;
        }

        .summary-box table {
            width: 100%;
            font-size: 12px;
        }

        .summary-box td {
            padding: 3px 8px 3px 0;
        }

        .summary-box .label {
            font-weight: 600;
            color: #555;
            width: 180px;
        }

        .summary-box .value {
            font-weight: 600;
            color: #000;
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
            padding: 10px 14px;
            border: 1px solid #ccc;
            margin: 8px 0 15px 0;
            font-size: 12px;
            line-height: 1.7;
            background: #fafafa;
        }

        .location-info strong {
            font-weight: bold;
            color: #000;
        }

        @media print {
            body {
                background: #fff;
                padding: 0;
            }

            .page {
                padding: 20px 25px;
            }

            .appointments-table th {
                background-color: #2c3e50 !important;
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
                text-align: left !important;
            }

            .right {
                text-align: left !important;
                margin-top: 10px;
            }

            .appointments-table {
                font-size: 9px;
            }

            .appointments-table th,
            .appointments-table td {
                padding: 4px;
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
            {{-- EN-TÊTE --}}
            <table class="header-top">
                <tr>
                    <td width="20%" class="left">
                        @if (!empty($flag_path))
                            <img src="{{ public_path($flag_path) }}" class="logo" alt="Drapeau">
                        @else
                            <img src="{{ public_path('assets/core/icons/flag.png') }}" class="logo" alt="Drapeau">
                        @endif
                    </td>

                    <td width="60%" class="center">
                        <strong style="font-size: 15px; color: black;">
                            République Algérienne Démocratique et Populaire
                        </strong>
                        <br />
                        <strong style="font-size: 14.5px; color: black;">
                            Ministère de la Santé
                        </strong>
                        <br />
                        <strong style="font-size: 14px; color: black;">
                            Direction de la Santé et de la Population de la Wilaya de Tlemcen
                        </strong>
                        <br />
                    </td>

                    <td width="20%" class="right">
                        @if (!empty($logo_path))
                            <img src="{{ public_path($logo_path) }}" class="logo" alt="Logo">
                        @else
                            <img src="{{ public_path('assets/app/images/Logo.png') }}" class="logo" alt="Logo">
                        @endif
                    </td>
                </tr>
            </table>

            <div class="divider"></div>

            {{-- TITRE --}}
            <div class="title">
                Liste des Rendez-vous
            </div>

            {{-- SOUS-TITRE --}}
            <div class="subtitle">
                @if ($specialty)
                    Spécialité : {{ $specialty }}
                    @if ($service)
                        |
                    @endif
                @endif
                @if ($service)
                    Service : {{ $service }}
                @endif
                @if (!$specialty && !$service)
                    Tous les rendez-vous
                @endif
            </div>

            {{-- INFORMATIONS LIEU --}}
            @if ($locationName && $locationName !== '-')
                <div class="location-info">
                    <strong>Lieu de rendez-vous :</strong> {{ $locationName }}
                    @if ($locationAddress && $locationAddress !== '-')
                        <br><strong>Adresse :</strong> {{ $locationAddress }}
                    @endif
                </div>
            @endif

            {{-- RÉCAPITULATIF --}}
            <div class="summary-box">
                <table>
                    <tr>
                        <td class="label">Date de la liste</td>
                        <td class="value">{{ $datePart }}</td>
                        <td class="label">Total des rendez-vous</td>
                        <td class="value">{{ $totalCount }}</td>
                    </tr>
                    <tr>
                        <td class="label">Généré le</td>
                        <td class="value">{{ $generatedAt }}</td>
                        <td class="label">Établissement</td>
                        <td class="value">{{ $locationName ?? 'Non spécifié' }}</td>
                    </tr>
                </table>
            </div>

            {{-- TABLEAU DES RENDEZ-VOUS --}}
            <table class="appointments-table">
                <thead>
                    <tr>
                        <th width="17%">Code</th>
                        <th width="22%">Patient</th>
                        <th width="25%">Service</th>
                        <th width="25%">Spécialité</th>
                        <th width="12%">Date</th>
                        <th width="9%">Heure</th>
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
                                Aucun rendez-vous trouvé
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- PIED DE PAGE --}}
            <div class="footer-line"></div>

            <div class="footer">
                <span>Liste des rendez-vous</span>
                <span>Généré le : {{ now()->format('d/m/Y H:i') }} | Page
                    {{ $pageIndex + 1 }}/{{ $totalPages }}</span>
            </div>
        </div>
    @endforeach

    {{-- Numérotation des pages --}}
    <script type="text/php">
    if (isset($pdf)) {
        $font = $fontMetrics->get_font("Arial", "normal");
        $size = 9;
        $pageText = "Page " . $PAGE_NUM . "/" . $PAGE_COUNT;

        $x = 510;
        $y = 820;

        $pdf->text($x, $y, $pageText, $font, $size);
    }
</script>

</body>

</html>
