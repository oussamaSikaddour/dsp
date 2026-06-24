<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Appointment Confirmation</title>

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

        .barcode {
            width: 80px;
            margin-bottom: 5px;
        }


        .logo {
            max-height: 55px;
        }

        .private {
            font-weight: bold;
            font-size: 10px;
            text-transform: uppercase;
            color: #c0392b;
            margin: 3px 0;
        }

        .patient-info {
            line-height: 1.7;
            font-size: 12px;
        }

        .patient-info strong {
            font-size: 13px;
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

        .service-info {
            font-size: 12px;
            line-height: 1.7;
        }

        .reference-info {
            margin-top: 8px;
            font-size: 12px;
            line-height: 1.7;
        }

        .divider {
            border-top: 1px solid #333;
            margin: 10px 0 12px 0;
        }

        .greeting {
            margin-bottom: 8px;
            font-size: 13px;
            font-weight: bold;
        }

        .title {
            font-size: 20px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 2px solid #2c3e50;
        }

        .content {
            font-size: 12px;
            line-height: 1.7;
            margin-bottom: 10px;
        }

        .appointment-type {
            margin: 8px 0 10px 0;
            padding: 6px 12px;
            background: #f0f0f0;
            border-left: 3px solid #2c3e50;
            font-size: 13px;
            font-weight: bold;
        }

        .details-table {
            margin: 8px 0 10px 0;
            width: 100%;
        }

        .details-table tr {
            border-bottom: 1px solid #e8e8e8;
        }

        .details-table tr:last-child {
            border-bottom: none;
        }

        .details-table td {
            padding: 5px 0;
            vertical-align: top;
            font-size: 12px;
        }

        .details-table .label {
            width: 150px;
            font-weight: 600;
            color: #555;
        }

        .details-table .value {
            font-weight: 600;
            color: #000;
        }

        .info-box {
            padding: 10px 14px;
            border: 1px solid #ccc;
            margin: 8px 0;
            font-size: 12px;
            line-height: 1.7;
            background: #fafafa;
        }

        .info-box strong {
            font-weight: bold;
        }

        .notes-box {
            padding: 8px 12px;
            border: 1px solid #ddd;
            margin: 8px 0;
            font-size: 12px;
            line-height: 1.7;
            background: #fcfcfc;
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

        /* Print Styles */
        @media print {
            body {
                background: #fff;
                padding: 0;
            }

            .page {
                padding: 20px 25px;
            }

            .appointment-type {
                background: #f0f0f0 !important;
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
                text-align: left !important;
            }

            .right {
                text-align: left !important;
                margin-top: 10px;
            }

            .details-table .label {
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

        {{-- HEADER --}}
        <table class="header-top">
            <tr>
                <td width="20%" class="left">
                    @if (!empty($flag_path))
                        <img src="{{ public_path($flag_path) }}" class="logo" alt="Flag">
                    @else
                        <img src="{{ public_path('assets/core/icons/flag.png') }}" class="logo" alt="Flag">
                    @endif
                </td>
                <td width="60%" class="center">

                    <strong style="font-size: 15px; color: black;"> People's Democratic Republic of Algeria</strong>
                    <br />
                    <strong style="font-size: 14.5px; color: black;">
                        Ministry of Health</strong>
                    <br />
                    <strong style="font-size: 14px; color: black;">
                        Directorate of Health and Population of the Wilaya of Tlemcen</strong>
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

        {{-- PATIENT & SERVICE INFO --}}
        <table class="header-bottom">
            <tr>
                <td width="50%" class="left" style="vertical-align:top; padding-top:5px;">
                    @if (!empty($barcode_path))
                        <img src="{{ public_path($barcode_path) }}" class="barcode" alt="Barcode">
                    @endif

                    <div class="private">Private and Confidential</div>

                    <div class="patient-info">
                        <strong>{{ $patient_name ?? '-' }}</strong>
                        <br>
                        <strong>Patient Code:</strong> {{ $patient_code ?? '-' }}
                        <br>
                        <strong>Birth Date:</strong> {{ $birth_date ?? '-' }}
                        <br>
                        <strong>Gender:</strong> {{ $gender ?? '-' }}
                    </div>
                </td>

                <td width="50%" class="right" style="vertical-align:top; padding-top:5px;">
                    <div class="service-info">
                        <strong>{{ $service_name ?? '-' }}</strong>
                        <br>
                        @if (!empty($specialty_name) && $specialty_name !== '-')
                            {{ $specialty_name }}
                            <br>
                        @endif

                        @if (!empty($service_phone) && $service_phone !== '-')
                            <strong>Phone:</strong> {{ $service_phone }}
                            <br>
                        @endif

                        @if (!empty($service_fax) && $service_fax !== '-')
                            <strong>Fax:</strong> {{ $service_fax }}
                        @endif
                    </div>

                    <div class="reference-info">
                        <strong>Date:</strong> {{ now()->format('d/m/Y') }}
                        <br>
                        <strong>Appointment ID:</strong> {{ $id ?? '-' }}
                        @if (!empty($queue_number))
                            <br>
                            <strong>Queue:</strong> {{ $queue_number }}
                        @endif
                    </div>
                </td>
            </tr>
        </table>

        <div class="divider"></div>

        {{-- GREETING --}}
        <div class="greeting">
            Dear {{ $patient_name ?? 'Patient' }},
        </div>

        {{-- TITLE --}}
        <div class="title">
            Appointment Confirmation
        </div>

        {{-- INTRODUCTION --}}
        <div class="content">
            We are pleased to confirm your appointment with the
            <strong>{{ $service_name ?? 'medical' }}</strong> service.
            Please review the appointment details below and arrive
            a few minutes before your scheduled appointment.
        </div>

        {{-- APPOINTMENT TYPE --}}
        <div class="appointment-type">
            Appointment Type: {{ $appointment_type ?? 'Consultation' }}
        </div>

        {{-- DETAILS TABLE --}}
        <table class="details-table">
            <tr>
                <td class="label">Patient Name</td>
                <td class="value">{{ $patient_name ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Patient Code</td>
                <td class="value">{{ $patient_code ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Birth Date</td>
                <td class="value">{{ $birth_date ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Gender</td>
                <td class="value">{{ $gender ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Service</td>
                <td class="value">{{ $service_name ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Specialty</td>
                <td class="value">{{ $specialty_name ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Appointment Type</td>
                <td class="value">{{ $appointment_type ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Appointment Date</td>
                <td class="value">
                    @if (!empty($day_name))
                        {{ $day_name }},
                    @endif
                    {{ $formatted_date ?? '-' }}
                </td>
            </tr>
            <tr>
                <td class="label">Appointment Time</td>
                <td class="value">
                    {{ $formatted_time ?? '-' }}
                    @if (!empty($formatted_end_time) && $formatted_end_time !== '-')
                        - {{ $formatted_end_time }}
                    @endif
                </td>
            </tr>
            <tr>
                <td class="label">Location</td>
                <td class="value">{{ $location ?? '-' }}</td>
            </tr>
            @if (!empty($doctor_name))
                <tr>
                    <td class="label">Doctor</td>
                    <td class="value">{{ $doctor_name }}</td>
                </tr>
            @endif
            @if (!empty($service_phone) && $service_phone !== '-')
                <tr>
                    <td class="label">Contact Phone</td>
                    <td class="value">{{ $service_phone }}</td>
                </tr>
            @endif
            @if (!empty($service_fax) && $service_fax !== '-')
                <tr>
                    <td class="label">Fax</td>
                    <td class="value">{{ $service_fax }}</td>
                </tr>
            @endif
            @if (!empty($queue_number))
                <tr>
                    <td class="label">Queue Number</td>
                    <td class="value">{{ $queue_number }}</td>
                </tr>
            @endif
        </table>

        {{-- INFORMATION BOX --}}
        <div class="info-box">
            <strong>Important Information:</strong>
            Please bring any relevant medical documents, prescriptions, referral letters,
            laboratory results, or imaging reports.
            <br>
            <strong>Cancellation Policy:</strong>
            Cancel at least <strong>three (3) days before</strong> the scheduled date.
        </div>

        {{-- NOTES --}}
        @if (!empty($notes))
            <div class="notes-box">
                <strong>Notes:</strong> {{ $notes }}
            </div>
        @endif

        {{-- FOOTER --}}
        <div class="footer-line"></div>

        <div class="footer">
            <span>Appointment Confirmation</span>
            <span>Generated: {{ now()->format('d/m/Y H:i') }} | Page 1/1</span>
        </div>

    </div>

</body>

</html>
