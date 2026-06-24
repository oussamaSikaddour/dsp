<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Patient Profile</title>

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

        .header-top td {
            vertical-align: middle;
            padding: 2px 0;
        }

        .logo {
            max-height: 55px;
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

        .label {
            font-weight: 600;
            color: #555;
        }

        .value {
            font-weight: 600;
            color: #000;
        }

        .info-box {
            padding: 10px 14px;
            border: 1px solid #ccc;
            margin: 10px 0;
            background: #fafafa;
        }

        .account-box {
            padding: 10px 14px;
            border: 1px solid #ddd;
            margin: 10px 0;
            background: #fcfcfc;
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
            border-left: 4px solid #1a73e8;
            padding: 12px 16px;
            margin: 12px 0;
            font-size: 13px;
            line-height: 1.6;
            border-radius: 2px;
        }

        .portal-message strong {
            color: #1a3c6e;
        }

        .portal-message .highlight {
            color: #1a73e8;
            font-weight: bold;
        }

        @media print {
            body {
                background: #fff;
                padding: 0;
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
        }
    </style>
</head>

<body>

    <div class="page">

        {{-- HEADER — same structure as template (English titles kept official) --}}
        <table class="header-top">
            <tr>
                <td width="20%" style="text-align:left;">
                    @if (!empty($flag_path))
                        <img src="{{ public_path($flag_path) }}" class="logo" alt="Flag">
                    @else
                        <img src="{{ public_path('assets/core/icons/flag.png') }}" class="logo" alt="Flag">
                    @endif
                </td>

                <td width="60%" style="text-align:center;">
                    <strong style="font-size: 15px; color: black;">People's Democratic Republic of Algeria</strong><br>
                    <strong style="font-size: 14.5px; color: black;">Ministry of Health</strong><br>
                    <strong style="font-size: 14px; color: black;">Directorate of Health and Population of the Wilaya of Tlemcen</strong>
                </td>

                <td width="20%" style="text-align:right;">
                    @if (!empty($logo_path))
                        <img src="{{ public_path($logo_path) }}" class="logo" alt="Logo">
                    @else
                        <img src="{{ public_path('assets/app/images/Logo.png') }}" class="logo" alt="Logo">
                    @endif
                </td>
            </tr>
        </table>

        <div class="divider"></div>

        {{-- TITLE --}}
        <div class="title">
            Patient Profile
        </div>

        {{-- PATIENT INFO --}}
        <div class="info-box">
            <strong>Patient Information</strong><br><br>

            <span class="label">Name :</span> <span class="value">{{ $patient_name ?? '-' }}</span><br>
            <span class="label">Code :</span> <span class="value">{{ $patient_code ?? '-' }}</span><br>
            <span class="label">Date of birth :</span> <span class="value">{{ $birth_date ?? '-' }}</span><br>
            <span class="label">Gender :</span> <span class="value">{{ $gender ?? '-' }}</span><br>
            <span class="label">Municipality :</span> <span class="value">{{ $commune ?? '-' }}</span><br>
            <span class="label">Phone :</span> <span class="value">{{ $patient_tel ?? '-' }}</span><br>
            <span class="label">Email :</span> <span class="value">{{ $patient_email ?? '-' }}</span>
        </div>

        {{-- ★ PORTAL MESSAGE — explicit call to action (English) --}}
        <div class="portal-message">
            <strong>🔐 Log in to your personal account</strong><br>
            By logging in to our appointment management platform, you will be able to:
            <ul style="margin: 6px 0 4px 20px; padding: 0;">
                <li>View your appointment history and <span class="highlight">track your follow-up appointments</span>.</li>
                <li>Book <span class="highlight">new appointments</span> for yourself or for your <span class="highlight">relatives / dependents</span>.</li>
                <li>Receive reminders and manage your preferences online.</li>
            </ul>
            <div style="margin-top: 8px; font-weight: 500;">
                👉 <span style="color: #1a73e8;">Use your credentials below to access all these services.</span>
            </div>
        </div>

        {{-- ACCOUNT ACCESS — English version --}}
        <div class="account-box">

            <strong>Personal account access</strong><br><br>

            <span class="label">Platform :</span>
            <span class="value">Medical appointment management system</span><br>
            <span class="label">Features :</span>
            <span class="value">
                View appointments, online booking, medical follow-up, management of relatives
            </span><br><br>

            <strong>Login information :</strong><br><br>
            <span class="label">Username :</span>
            <span class="value">{{ $opened_by['name'] ?? '-' }}</span><br>
            <span class="label">Temporary password :</span>
            <span class="value">12345678</span><br>

            <div class="warning">
                ⚠️ Please change your password after your first login.
            </div>

            {{-- additional reminder --}}
            <div style="margin-top: 8px; font-size: 12px; color: #2c3e50; border-top: 1px dashed #ccc; padding-top: 6px;">
                <strong>💡 Tip :</strong> Once logged in, you can also add family members to manage their appointments.
            </div>

        </div>

        {{-- FOOTER — same style as template --}}
        <div class="footer-line"></div>

        <div class="footer">
            <span>Patient profile</span>
            <span>Generated on : {{ now()->format('d/m/Y H:i') }} | Page 1/1</span>
        </div>

    </div>

</body>

</html>
