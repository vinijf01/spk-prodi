@extends('layouts/main')

@section('content')
    <!-- ======= Team Section ======= -->
    <section id="team" class="team section-bg">
        <div class="container" data-aos="fade-up">
            <div class="section-title">
                <h2>Pilih Program Studi</h2>
                {{-- <h3>Our Hardworking <span>Team</span></h3> --}}
                <p>Berikut Program Studi yang bisa dipilih dari jurusan sekolah {{ $sekolah->nama_jurusan }}</p>
            </div>

            <form action="{{ route('pertanyaan-prodi') }}" method="post">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card body">
                                    <form action="" method="post">
                                        @csrf
                                        <table>

                                            <head>
                                                <thead>
                                                    <th>Prodi</th>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $before = '';
                                                    @endphp
                                                    @foreach ($available as $item)
                                                        <tr>
                                                            <td>
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="id_prodi[]"
                                                                            value="{{ $item->id_prodi }}" />
                                                                        {{ $item->prodi->nama_prodi }}
                                                                    </label>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </head>
                                        </table>
                                        <hr>
                                        <input type="submit" class="btn btn-primary" value="Proses">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
            </form>
        </div>

        </div>
    </section><!-- End Team Section -->
@endsection
