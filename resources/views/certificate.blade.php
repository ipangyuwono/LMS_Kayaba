<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            width: 100%;
            height: 100%;
            /* max-height: 100%; */
            overflow: hidden;
            font-family: 'DejaVu Sans', sans-serif;
            background: #fff;
        }

        .cert {
            width: 100%;
            height: 709px;
            max-height: 100%;
            overflow: hidden;
            border: 12px solid #8B0000;
            padding: 30px 60px;
            position: relative;
            text-align: center;
        }

        .cert::before {
            content: '';
            position: absolute;
            inset: 6px;
            border: 2px solid #E62727;
        }

        .logo {
            font-size: 32px;
            font-weight: 900;
            color: #8B0000;
            letter-spacing: 4px;
        }

        .subtitle {
            font-size: 11px;
            color: #888;
            letter-spacing: 3px;
            text-transform: uppercase;
            margin-top: 4px;
        }

        .divider {
            width: 80px;
            height: 3px;
            background: #E62727;
            margin: 14px auto;
        }

        .title {
            font-size: 14px;
            color: #555;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-top: 14px;
        }

        .given {
            font-size: 12px;
            color: #888;
            margin-top: 8px;
        }

        .name {
            font-size: 38px;
            font-weight: 900;
            color: #1a1a1a;
            margin: 8px 0;
            border-bottom: 2px solid #E62727;
            display: inline-block;
            padding-bottom: 4px;
        }

        .desc {
            font-size: 12px;
            color: #555;
            margin-top: 12px;
            line-height: 1.6;
        }

        .info {
            font-size: 12px;
            color: #333;
            font-weight: bold;
            margin-top: 4px;
        }

        .date {
            font-size: 11px;
            color: #888;
            margin-top: 10px;
        }

        .footer {
            margin-top: 20px;
            display: table;
            width: 100%;
        }

        .sign {
            display: table-cell;
            text-align: center;
            width: 50%;
        }

        .sign-line {
            width: 160px;
            height: 1px;
            background: #333;
            margin: 30px auto 6px;
        }

        .sign-name {
            font-size: 12px;
            font-weight: bold;
            color: #333;
        }

        .sign-title {
            font-size: 10px;
            color: #888;
        }
    </style>
</head>

<body>
    <div class="cert">
        <div class="logo">KYB</div>
        <div class="subtitle">Kayaba Training Center</div>
        <div class="divider"></div>
        <div class="title">Sertifikat Penyelesaian</div>
        <div class="given">Diberikan kepada</div>
        <div class="name">{{ $nama }}</div>
        <div class="desc">Telah berhasil menyelesaikan seluruh materi pelatihan pada program</div>
        <div class="info">{{ $kelas }} &nbsp;·&nbsp; {{ $departemen }}</div>
        <div class="date">{{ $tanggal }}</div>

        <div class="footer">
            <div class="sign">
                <div class="sign-line"></div>
                <div class="sign-name">Training Manager</div>
                <div class="sign-title">KYB Manufacturing Indonesia</div>
            </div>
            <div class="sign">
                <div class="sign-line"></div>
                <div class="sign-name">HR Manager</div>
                <div class="sign-title">KYB Manufacturing Indonesia</div>
            </div>
        </div>
    </div>
</body>

</html>
