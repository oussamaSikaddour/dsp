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

        {{-- HEADER — same structure as template --}}
        <table class="header-top">
            <tr>
                <td width="20%" style="text-align:left;">
                    @if (!empty($flag_path))
                        <img src="{{ public_path($flag_path) }}" class="logo" alt="Drapeau">
                    @else
                        <img src="{{ public_path('assets/core/icons/flag.png') }}" class="logo" alt="Drapeau">
                    @endif
                </td>

                <td width="60%" style="text-align:center;">
                    <strong style="font-size: 15px; color: black;">République Algérienne Démocratique et Populaire</strong><br>
                    <strong style="font-size: 14.5px; color: black;">Ministère de la Santé</strong><br>
                    <strong style="font-size: 14px; color: black;">Direction de la Santé et de la Population de la Wilaya de Tlemcen</strong>
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
            Fiche Patient
        </div>

        {{-- PATIENT INFO --}}
        <div class="info-box">
            <strong>Informations du patient</strong><br><br>

            <span class="label">Nom :</span> <span class="value">{{ $patient_name ?? '-' }}</span><br>
            <span class="label">Code :</span> <span class="value">{{ $patient_code ?? '-' }}</span><br>
            <span class="label">Date de naissance :</span> <span class="value">{{ $birth_date ?? '-' }}</span><br>
            <span class="label">Sexe :</span> <span class="value">{{ $gender ?? '-' }}</span><br>
            <span class="label">Commune :</span> <span class="value">{{ $commune ?? '-' }}</span><br>
            <span class="label">Téléphone :</span> <span class="value">{{ $patient_tel ?? '-' }}</span><br>
            <span class="label">Email :</span> <span class="value">{{ $patient_email ?? '-' }}</span>
        </div>

        {{-- ★ PORTAL MESSAGE — explicit call to action --}}
        <div class="portal-message">
            <strong>🔐 Connectez-vous à votre compte personnel</strong><br>
            En vous connectant à notre plateforme de gestion des rendez-vous, vous pourrez :
            <ul style="margin: 6px 0 4px 20px; padding: 0;">
                <li>Consulter l’historique de vos rendez-vous et <span class="highlight">suivre vos rendez-vous de suivi</span>.</li>
                <li>Prendre de <span class="highlight">nouveaux rendez-vous</span> pour vous-même ou pour vos <span class="highlight">proches / personnes à charge</span>.</li>
                <li>Recevoir des rappels et gérer vos préférences en ligne.</li>
            </ul>
            <div style="margin-top: 8px; font-weight: 500;">
                👉 <span style="color: #1a73e8;">Utilisez vos identifiants ci-dessous pour accéder à tous ces services.</span>
            </div>
        </div>

        {{-- ACCOUNT ACCESS — same as before but with clearer message --}}
        <div class="account-box">

            <strong>Accès au compte personnel</strong><br><br>

            <span class="label">Plateforme :</span>
            <span class="value">Système de gestion des rendez-vous médicaux</span><br>
            <span class="label">Fonctionnalités :</span>
            <span class="value">
                Consultation des rendez-vous, réservation en ligne, suivi médical, gestion des proches
            </span><br><br>

            <strong>Informations de connexion :</strong><br><br>
            <span class="label">Nom d'utilisateur :</span>
            <span class="value">{{ $opened_by['name'] ?? '-' }}</span><br>
            <span class="label">Mot de passe temporaire :</span>
            <span class="value">12345678</span><br>

            <div class="warning">
                ⚠️ Veuillez changer votre mot de passe après votre première connexion.
            </div>

            {{-- additional reminder --}}
            <div style="margin-top: 8px; font-size: 12px; color: #2c3e50; border-top: 1px dashed #ccc; padding-top: 6px;">
                <strong>💡 Astuce :</strong> Une fois connecté, vous pourrez également ajouter des membres de votre famille pour gérer leurs rendez-vous.
            </div>

        </div>

        {{-- FOOTER — same style as template --}}
        <div class="footer-line"></div>

        <div class="footer">
            <span>Fiche patient</span>
            <span>Généré le : {{ now()->format('d/m/Y H:i') }} | Page 1/1</span>
        </div>

    </div>

</body>

</html>
