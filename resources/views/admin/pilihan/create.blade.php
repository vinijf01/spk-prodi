@extends('layouts.main_admin')
@section('content')
    <h1>Tambah {{ $title }} Prodi</h1>
    <div class="card mb-5">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-8">
                    <h5>{{ $title }} Program Studi untuk Jurusan {{ $jurusansekolah->nama_jurusan }}</h5>
                </div>
            </div>
        </div>

        <div class="table-responsive text-nowrap p-3">
            <div class="row">
                <form action="" method="POST" style="margin:1em">
                    @csrf
                    <div class="row p-3 text-uppercase fw-bold text-center mb-3">
                        <div class="col-md-1">
                            No
                        </div>
                        <div class="col-md-6">
                            Pilihan Program Studi
                        </div>
                    </div>
                    @foreach ($prodis as $index => $item)
                        <div class="row px-5">
                            <div class="col-md-2 form-group">
                                <h5 class="card-title">{{ $index + 1 }}</h5>
                            </div>
                            <div class="col-md-8 ps-5">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="pilihan[{{ $arrayIndex++ }}]"
                                            value="{{ $item->id }}"
                                            @if (App\Models\Pilihan::whereIdSekolah($idJurusanSekolah)->whereIdProdi($item->id)->count() != 0) {{ 'checked' }} @endif>
                                        {{ $item->nama_prodi }}
                                    </label>
                                </div>
                            </div>
                        </div>
                        <hr>
                    @endforeach
                    <div class="d-flex justify-content-center">
                        <input type="submit" class="btn btn-primary " value="Simpan">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
