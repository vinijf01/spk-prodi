<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10pt;
            color: #333;
            margin: 0;
            padding: 0;
            line-height: 1.5;
        }

        .wrapper {
            min-height: 90vh;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
        }

        .header img {
            width: 60px;
        }

        .judul-laporan {
            font-size: 16pt;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .subjudul {
            font-size: 10pt;
            color: #555;
        }

        .meta {
            text-align: right;
            font-size: 9pt;
            color: #666;
            margin-bottom: 10px;
        }

        h2 {
            font-size: 13pt;
            margin: 20px 0 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        th,
        td {
            border: 1px solid #999;
            padding: 6px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .highlight {
            text-align: center;
            font-size: 14pt;
            color: green;
            font-weight: bold;
            margin: 15px 0;
        }

        .footer {
            margin-top: 50px;
            padding-top: 10px;
            border-top: 1px solid #ccc;
            text-align: center;
            font-size: 9pt;
            color: #aaa;
        }
    </style>
</head>

<body>

    <div class="wrapper">
        {{-- HEADER --}}
        <div class="header">
            <img src="{{ public_path('assets/img/logo_dummy.png') }}" alt="Logo">
            <div class="judul-laporan">{{ $title }}</div>
            <div class="subjudul">Sistem Pendukung Keputusan Pemilihan Program Studi</div>
        </div>

        {{-- META INFO --}}
        <div class="meta">
            <strong>Nama:</strong> {{ $user }}<br>
            <strong>Tanggal:</strong> {{ \Carbon\Carbon::now()->format('d M Y, H:i') }}
        </div>

        {{-- REKOMENDASI TERBAIK --}}
        <h2>1. Rekomendasi Program Studi Terbaik</h2>
        <div class="highlight">{{ strtoupper($result['prodi_max'] ?? '-') }}</div>

        {{-- TABEL ALTERNATIF --}}
        <h2>2. Data Alternatif (Prodi dan Penilaian)</h2>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Prodi</th>
                    @foreach ($result['id'] ?? [] as $id)
                        <th>P{{ $id }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($result['data'] as $i => $item)
                    <tr>
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
            <h2>3. Nilai Preferensi</h2>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Prodi</th>
                        <th>Nilai Preferensi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($result['preferensi'] as $index => $nilai)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $result['data'][$index]['nama'] ?? '-' }}</td>
                            <td>{{ round($nilai, 4) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    {{-- FOOTER --}}
    <div class="footer">
        Halaman {{ '{PAGE_NUM}' }} dari {{ '{PAGE_COUNT}' }} | Dicetak oleh sistem SPK Prodi Universitas Metamedia
    </div>

</body>

</html>
