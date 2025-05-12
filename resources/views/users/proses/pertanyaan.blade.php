@extends('layouts/main')
@section('content')
    <section id="team" class="team section-bg">
        <div class="container" data-aos="fade-up">

            <div class="section-title">
                <h2>Program Studi Pilihan</h2><br><br><br>
                <h4>Cek Minat, Bakat, dan Hobi terhadap Program Studi</h4>
                <p>Jawablah pertanyaan berikut sesuai dengan preferensi pribadi Anda.</p>
            </div>


            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">

                            <div class="card-header row">
                                <div class="col-md-4">
                                    <div class="">{{ __('Program Study') }}</div>
                                </div>
                                <div class="col-md-4">
                                    <div class="">{{ __('Minat') }}</div>
                                </div>
                            </div>
                            <div class="card body">
                                <form action="/hasilpilihan" method="post" style="margin:1em">
                                    @csrf
                                    @foreach ($prodi as $index => $pilih)
                                        <div class="row">
                                            <div class="col-md-4 form-group">
                                                <h5 class="card-title">{{ $pilih->nama_prodi }}</h5>
                                            </div>
                                            <div class="col-md-8">
                                                @php
                                                    $subKri = 0;
                                                @endphp
                                                @foreach ($kriteria as $kri)
                                                    <br>
                                                    <div class="checkbox">
                                                        <label for="customRange3" class="form-label">
                                                            {{ $kri->nama_kriteria }}</label>
                                                    </div>
                                                    @php
                                                        $subIndex = 0;
                                                    @endphp
                                                    @foreach ($pertanyaan as $question)
                                                        @if ($question->id_prodi == $pilih->id && $question->id_kriteria == $kri->id)
                                                            <li>
                                                                {{ $question->pertanyaan }}
                                                                <input type="range"
                                                                    name="data[{{ $index }}][p{{ $kri->id }}]"
                                                                    class="form-range" min="1" id="vol"
                                                                    max="5" step="1" onClick="hey()"
                                                                    id="[{{ $kri->nama_kriteria }}]" id="customRange3">
                                                            </li>
                                                            @php
                                                                $subIndex++;
                                                            @endphp
                                                        @endif
                                                    @endforeach
                                                @endforeach
                                                <input type="hidden" name="data[{{ $index }}][nama]"
                                                    value="{{ $prodi[$index]->nama_prodi }}">
                                            </div>

                                        </div>

                                        <br>
                                        <hr>
                                        @php
                                            $subIndex = 0;
                                            $index++;
                                        @endphp
                                    @endforeach
                                    <hr>
                                    <input type="submit" class="btn btn-primary" value="Simpan">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section><!-- End Team Section -->
@endsection
