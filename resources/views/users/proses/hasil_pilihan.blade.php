@extends('layouts/main')
@section('content')
    <section id="team" class="team section-bg">
        <div class="card mb-3">
            <div class="card-header">
                <div class="row">
                    <div class="col-lg-8">
                        <h2>Hasil Rekomendasi Program Studi</h3>
                    </div>
                    <div class="col-lg-4 text-end mb-3">

                        <a href="{{ route('createPDF') }}" class="btn btn-success"><i class='bx bx-download'
                                style="font-size: 1.5em"></i> Unduh Hasil </a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <h3>Halo, {{ session('name') }}</h3>
                        <h3>Rekomendasi Program Studi Terbaik untuk Anda adalah :<br><br> <span
                                style="color:rgb(14, 150, 45)">{{ $result['prodi_max'] }}</span></h3>
                        <br>
                        <p>
                            <button class="btn btn-primary" type="button" data-bs-toggle="collapse"
                                data-bs-target="#proses" aria-expanded="false" aria-controls="proses">
                                Lihat Proses Perhitungan
                            </button>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div id="proses" class="collapse container">
            <div class="card mb-3">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-12">
                            <h2 class="text-center">Proses Perhitungan</h2>
                            <h5>Tabel Perbandingan Kriteria dan Alternatif</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <table class="table table-bordered">
                            <thead>
                                <strong>
                                    <tr>
                                        <th scope="col">Nama Prodi</th>
                                        @foreach ($result['nama'] as $index => $item)
                                            <th scope="col">{{ $item }}</th>
                                        @endforeach
                                    </tr>
                                </strong>
                            </thead>
                            <tbody>
                                @foreach ($result['data'] as $index => $item)
                                    <tr>
                                        <th>{{ $item['nama'] }}</th>
                                        @foreach ($result['id'] as $value)
                                            <td>
                                                {{ $item['p' . $value] }}
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                            {{-- <tfoot>
                            <tr class="fw-bold">
                                <td>Max</td>
                                @foreach ($result['ttlnilai'] as $item)
                                    <td>{{ $item }}</td>
                                @endforeach

                            </tr>
                        </tfoot> --}}
                        </table>
                    </div>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-12">
                            <h5>Tabel Kuadrat</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <table class="table table-bordered">
                            <thead>
                                <strong>
                                    <tr>
                                        <th scope="col">Nama Prodi</th>
                                        @foreach ($result['nama'] as $index => $item)
                                            <th scope="col">{{ $item }}</th>
                                        @endforeach
                                    </tr>
                                </strong>
                            </thead>
                            <tbody>
                                @php
                                    $normal = [];
                                    $id = 0;
                                @endphp
                                @foreach ($result['data'] as $index => $item)
                                    <tr>
                                        <th>{{ $item['nama'] }}</th>
                                        @foreach ($result['tabel_tn'] as $index => $item)
                                            <td>{{ round($item[$id], 2) }}</td>
                                        @endforeach
                                        @php
                                            $id = $id + 1;
                                        @endphp
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="fw-bold">
                                    <td>Total</td>
                                    @foreach ($result['ttlnilai'] as $item)
                                        <td>{{ $item }}</td>
                                    @endforeach

                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-8">
                            <h5>Tabel Normalisasi</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">Nama Prodi</th>
                                    @foreach ($result['nama'] as $index => $item)
                                        <th scope="col">{{ $item }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $normal = [];
                                    $id = 0;
                                @endphp
                                @foreach ($result['data'] as $item)
                                    <tr>
                                        <th>{{ $item['nama'] }}</th>

                                        @foreach ($result['normalisasi'] as $index => $item)
                                            <td>{{ round($item[$id], 2) }}</td>
                                        @endforeach
                                        @php
                                            $id = $id + 1;
                                        @endphp
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-8">
                            <h5>Tabel Normalisasi Terbobot</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">Nama Prodi</th>
                                    @foreach ($result['nama'] as $index => $item)
                                        <th scope="col">{{ $item }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $normal = [];
                                    $id = 0;
                                @endphp
                                @foreach ($result['data'] as $item)
                                    <tr>
                                        <th>{{ $item['nama'] }}</th>

                                        @foreach ($result['normalisasi_terbobot'] as $index => $item)
                                            <td>{{ round($item[$id], 2) }}</td>
                                        @endforeach
                                        @php
                                            $id = $id + 1;
                                        @endphp
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-8">
                            <h5>Tabel Matrik Solusi Ideal</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    @foreach ($result['nama'] as $index => $item)
                                        <th scope="col">{{ $item }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $normal = [];
                                    $id = 0;
                                @endphp
                                <tr>
                                    <th>Positif</th>
                                    @foreach ($result['positif'] as $index => $item)
                                        <th scope="col" style="font-weight: normal;">{{ round($item, 2) }}</th>
                                    @endforeach

                                </tr>
                                <tr>
                                    <th>Negatif</th>
                                    @foreach ($result['negatif'] as $index => $item)
                                        <th scope="col" style="font-weight: normal;">{{ round($item, 2) }}</th>
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-8">
                            <h5>Tabel Jarak Solusi Ideal</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">Nama Prodi</th>
                                    <th scope="col">Positif</th>
                                    <th scope="col">Negatif</th>

                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $id = 0;
                                @endphp
                                @foreach ($result['data'] as $item)
                                    <tr>
                                        <th>{{ $item['nama'] }}</th>
                                        <th style="font-weight: normal;">{{ round($result['jr_positif'][$id], 2) }}</th>
                                        <th style="font-weight: normal;">{{ round($result['jr_negatif'][$id], 2) }}</th>
                                    </tr>
                                    @php
                                        $id++;
                                    @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-8">
                            <h5>Tabel Perangkingan</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">Nama Prodi</th>
                                    <th scope="col">Nilai</th>
                                    <th scope="col">Peringkat</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $rank = 1;
                                @endphp
                                @foreach ($result['change_preferensi'] as $namaProdi => $nilai)
                                    <tr @if ($rank == 1) style="background: rgb(192, 221, 255);" @endif>
                                        <td>{{ $namaProdi }}</td>
                                        <td>{{ round($nilai[0], 2) }}</td>
                                        <td>{{ $rank }}</td>
                                    </tr>
                                    @php
                                        $rank++;
                                    @endphp
                                @endforeach

                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
        <hr>
    </section><!-- End Team Section -->
@endsection
