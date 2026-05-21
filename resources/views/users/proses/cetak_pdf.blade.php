<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Helvetica, Arial, sans-serif;
            font-size: 10pt;
            color: #2c3e50;
            line-height: 1.5;
        }

        .wrapper {
            padding: 20px 30px;
        }

        /* HEADER SECTION */
        .kop-surat {
            border-bottom: 3px solid #2c3e50;
            padding-bottom: 15px;
            margin-bottom: 20px;
            position: relative;
        }

        .kop-surat::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 100%;
            height: 1px;
            background-color: #bdc3c7;
        }

        .kop-kiri {
            width: 70px;
            float: left;
            text-align: center;
        }

        .kop-kanan {
            margin-left: 85px;
            text-align: center;
        }

        .kop-kanan h1 {
            font-size: 16pt;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 3px;
            letter-spacing: 1px;
        }

        .kop-kanan h2 {
            font-size: 11pt;
            font-weight: normal;
            color: #7f8c8d;
            margin-bottom: 5px;
        }

        .kop-kanan p {
            font-size: 8pt;
            color: #95a5a6;
        }

        .clear {
            clear: both;
        }

        /* DOCUMENT INFO */
        .doc-info {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #ecf0f1;
            border-left: 4px solid #2c3e50;
        }

        .doc-info table {
            width: 100%;
            border: none;
        }

        .doc-info td {
            border: none;
            padding: 2px 5px;
            text-align: left;
            font-size: 9pt;
        }

        .doc-info td:first-child {
            width: 25%;
            font-weight: bold;
        }

        /* SECTION HEADERS */
        .section-title {
            font-size: 12pt;
            font-weight: bold;
            color: #2c3e50;
            margin: 20px 0 10px 0;
            padding-bottom: 5px;
            border-bottom: 2px solid #3498db;
        }

        /* RECOMMENDATION BOX */
        .recommendation-box {
            background-color: #e8f6f3;
            border: 2px solid #27ae60;
            border-radius: 5px;
            padding: 15px;
            margin: 15px 0;
            text-align: center;
        }

        .recommendation-box .label {
            font-size: 9pt;
            color: #7f8c8d;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .recommendation-box .value {
            font-size: 16pt;
            font-weight: bold;
            color: #27ae60;
        }

        /* TABLES */
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            font-size: 9pt;
        }

        table.data-table th {
            background-color: #2c3e50;
            color: #ffffff;
            padding: 8px 6px;
            text-align: center;
            font-weight: bold;
            border: 1px solid #2c3e50;
        }

        table.data-table td {
            padding: 6px;
            text-align: center;
            border: 1px solid #bdc3c7;
        }

        table.data-table tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        table.data-table tr:hover {
            background-color: #e8f4f8;
        }

        table.data-table td:first-child {
            width: 8%;
        }

        table.data-table td:nth-child(2) {
            text-align: left;
            padding-left: 10px;
        }

        /* RANKING BADGE */
        .rank-1 {
            background-color: #f9e79f !important;
            font-weight: bold;
        }

        .rank-2 {
            background-color: #e8daef !important;
        }

        .rank-3 {
            background-color: #d5f5e3 !important;
        }

        /* CONSISTENCY INFO */
        .consistency-info {
            background-color: #fef9e7;
            border: 1px solid #f39c12;
            padding: 10px;
            margin: 15px 0;
            font-size: 9pt;
        }

        .consistency-info .status {
            font-weight: bold;
            color: #27ae60;
        }

        .consistency-info .status.invalid {
            color: #e74c3c;
        }

        /* SIGNATURE SECTION */
        .signature-section {
            margin-top: 40px;
            page-break-inside: avoid;
        }

        .signature-box {
            float: right;
            width: 250px;
            text-align: center;
        }

        .signature-box p {
            margin: 5px 0;
            font-size: 9pt;
        }

        .signature-space {
            height: 60px;
        }

        .signature-name {
            font-weight: bold;
            text-decoration: underline;
            color: #2c3e50;
        }

        /* FOOTER */
        .footer {
            margin-top: 50px;
            padding-top: 10px;
            border-top: 1px solid #bdc3c7;
            text-align: center;
            font-size: 8pt;
            color: #95a5a6;
        }

        .footer strong {
            color: #2c3e50;
        }
    </style>
</head>

<body>

    <div class="wrapper">
        {{-- KOP SURAT --}}
        <div class="kop-surat">
            <div class="kop-kanan">
                <h1>{{ $title }}</h1>
                <h2>Sistem Pendukung Keputusan Pemilihan Program Studi</h2>
                <p>Universitas Metamedia | Metode AHP-TOPSIS</p>
            </div>
            <div class="clear"></div>
        </div>

        {{-- INFORMASI DOKUMEN --}}
        <div class="doc-info">
            <table>
                <tr>
                    <td>Nama Pemohon</td>
                    <td>: {{ $user }}</td>
                </tr>
                <tr>
                    <td>Tanggal Cetak</td>
                    <td>: {{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM Y, HH:mm') }} WIB</td>
                </tr>
                <tr>
                    <td>No. Dokumen</td>
                    <td>: SPK/{{ now()->format('Ymd') }}/{{ strtoupper(substr(md5($user), 0, 8)) }}</td>
                </tr>
            </table>
        </div>

        {{-- REKOMENDASI TERBAIK --}}
        <div class="section-title">1. Hasil Rekomendasi Program Studi</div>
        <div class="recommendation-box">
            <div class="label">Program Studi yang Direkomendasikan</div>
            <div class="value">{{ strtoupper($result['prodi_max'] ?? '-') }}</div>
        </div>

        {{-- TABEL ALTERNATIF --}}
        <div class="section-title">2. Data Alternatif dan Penilaian</div>
        <table class="data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Program Studi</th>
                    @foreach ($result['id'] ?? [] as $id)
                        <th>K{{ $id }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($result['data'] as $i => $item)
                    <tr class="{{ $i < 3 ? 'rank-' . ($i + 1) : '' }}">
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $item['nama'] }}</td>
                        @foreach ($result['id'] ?? [] as $id)
                            <td>{{ $item['p' . $id] ?? '-' }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- TABEL NILAI PREFERENSI --}}
        @if (isset($result['preferensi']))
            <div class="section-title">3. Ranking Berdasarkan Nilai Preferensi</div>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Rank</th>
                        <th>Program Studi</th>
                        <th>Nilai Preferensi</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($result['preferensi'] as $index => $nilai)
                        <tr class="{{ $index < 3 ? 'rank-' . ($index + 1) : '' }}">
                            <td>{{ $index + 1 }}</td>
                            <td style="text-align: left; padding-left: 10px;">{{ $result['data'][$index]['nama'] ?? '-' }}</td>
                            <td>{{ round($nilai, 4) }}</td>
                            <td>{{ $index === 0 ? 'TERPILIH' : ($index === 1 ? 'Alternatif 1' : ($index === 2 ? 'Alternatif 2' : 'Alternatif')) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        {{-- KONSISTENSI AHP --}}
        @if (isset($result['cr']))
            <div class="section-title">4. Uji Konsistensi AHP</div>
            <div class="consistency-info">
                <table style="width: 100%; border: none;">
                    <tr>
                        <td style="border: none; width: 40%;"><strong>Consistency Ratio (CR)</strong></td>
                        <td style="border: none; width: 60%;">: {{ round($result['cr'] * 100, 2) }}%</td>
                    </tr>
                    <tr>
                        <td style="border: none;"><strong>Consistency Index (CI)</strong></td>
                        <td style="border: none;">: {{ round($result['ci'] * 100, 2) }}%</td>
                    </tr>
                    <tr>
                        <td style="border: none;"><strong>Status</strong></td>
                        <td style="border: none;">
                            : <span class="status {{ $result['cr'] > 0.1 ? 'invalid' : '' }}">
                                {{ $result['cr'] <= 0.1 ? 'KONSISTEN (CR ≤ 10%)' : 'TIDAK KONSISTEN (CR > 10%)' }}
                              </span>
                        </td>
                    </tr>
                </table>
            </div>
        @endif

    </div>

    {{-- FOOTER --}}
    <div class="footer">
        <strong>Dokumen ini dicetak secara otomatis oleh Sistem SPK Prodi</strong><br>
        Universitas Metamedia &copy; {{ date('Y') }}
    </div>

</body>

</html>
