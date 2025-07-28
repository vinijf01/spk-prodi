@extends('layouts.main')
@section('content')
    <!-- ======= Hero Section ======= -->
    <section id="hero" class="hero">
    </section>
    <!-- End Hero -->

    <main id="main">

        <!-- ======= Featured Services Section ======= -->
        <section class="featured-services">
            <div class="container" data-aos="fade-up">
                <div class="section-title">
                    <h2>Panduan</h2>
                    <h3>Faktor-Faktor <span>Utama</span></h3>
                </div>

                <div class="row">
                    <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0">
                        <div class="icon-box" data-aos="fade-up" data-aos-delay="100">
                            <div class="icon"><i class="bx bxl-dribbble"></i></div>
                            <h4 class="title"><a href="">Minat Pribadi</a></h4>
                            <p class="description">Perhatikan minat pribadi dalam subjek atau bidang ilmu tertentu.
                                Pilih program studi yang sesuai dengan minat, karena ini akan memotivasi untuk belajar
                                dengan lebih baik.</p>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0">
                        <div class="icon-box" data-aos="fade-up" data-aos-delay="200">
                            <div class="icon"><i class="bx bx-file"></i></div>
                            <h4 class="title"><a href="">Bakat dan Keahlian</a></h4>
                            <p class="description">Pertimbangkan bakat dan keahlian alami yang dimiliki. Program studi
                                yang memanfaatkan bakat dan keahlian tersebut berkemungkinan besar lebih sesuai.</p>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0">
                        <div class="icon-box" data-aos="fade-up" data-aos-delay="300">
                            <div class="icon"><i class="bx bx-tachometer"></i></div>
                            <h4 class="title"><a href="">Kecendrungan Akademik</a></h4>
                            <p class="description">Pertimbangkan mata pelajaran yang dikuasai dengan baik. Hal ini
                                dapat membantu dalam pemilihan program studi yang sejalan dengan kecendrungan akademik.
                            </p>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0">
                        <div class="icon-box" data-aos="fade-up" data-aos-delay="400">
                            <div class="icon"><i class="bx bx-star"></i></div>
                            <h4 class="title"><a href="">Tujuan Karir</a></h4>
                            <p class="description">Pertimbangkan tujuan karir, Pilih program studi yang relevan dengan
                                tujuan karir, karena beberapa profesi memerlukan pendidikan khusus.</p>
                        </div>
                    </div>
                    <div class="row justify-content-center" id="panduan">
                        <div class="col-md-6 col-lg-6 d-flex align-items-stretch top5">
                            <div class="icon-box" data-aos="fade-up" data-aos-delay="400">
                                <div class="icon"><i class="bx bx-world"></i></div>
                                <h4 class="title"><a href="">Panduan dalam Pemilihan</a></h4>
                                <p class="description">Faktor-faktor di atas merupakan hal-hal utama yang tidak boleh
                                    dilewatkan saat memilih program studi. Mari kami pandu, silakan klik tombol di bawah
                                    ini.</p>
                                <a href="#check" class="btn-get-started">Ayo Mulai !!</a>
                            </div>
                        </div>
                    </div>


                </div>

            </div>
        </section><!-- End Featured Services Section -->

        <!-- ======= About Section ======= -->
        <section id="about" class="about section-bg">
            <div class="container" data-aos="fade-up">
                <form action="{{ route('pilihan-prodi') }}" method="post">
                    @csrf
                    <div class="section-title" id="cek">
                        <h2>Cek Program Jurusan Sekolah Asal</h2>
                        <p>Membantu Menemukan Program Studi di Universitas Metamedia Berdasarkan Jurusan Sekolah Asal.
                        </p>
                    </div>

                    <div class="row">
                        <div class="col-lg-6" data-aos="fade-right" data-aos-delay="100">
                            <img src="{{ asset('assets/img/about.png') }}" class="img-fluid" style="height: 80%"
                                alt="">
                        </div>
                        <div class="col-lg-6 pt-4 pt-lg-0 content d-flex flex-column justify-content-center"
                            data-aos="fade-up" data-aos-delay="100">
                            <h3>Lengkapi Data Dibawah Ini</h3>
                            <p class="font-italic">
                                Isikan Sesuai Data Anda.
                            </p>
                            <ul>
                                <li>
                                    <i class="bx bx-label" style="margin-top: -5%"></i>
                                    <div class="col form-group" style="margin-top: -8%">
                                        <h5>Nama</h5>
                                        <input type="text" name="name" class="form-control" id="name"
                                            placeholder="Masukkan Nama" data-rule="minlen:4"
                                            data-msg="Please enter at least 4 chars" required />
                                        <div class="validate"></div>
                                    </div>
                                </li>
                                {{-- <li>
                                    <i class="bx bxl-gmail" style="margin-top: -5%"></i>
                                    <div class="col form-group" style="margin-top: -8%">
                                        <h5>Email</h5>
                                        <input type="text" name="email" class="form-control" id="email"
                                            placeholder="Masukkan email" data-rule="minlen:4"
                                            data-msg="Please enter your email address" required />
                                        <div class="validate"></div>
                                    </div>
                                </li> --}}
                                <li>
                                    <i class="bx bxs-school" style="margin-top: -5%"></i>
                                    <div class="form-group row" style="margin-top: -8%">
                                        <h5>Asal Jurusan Sekolah</h5>
                                        <div class="col-md-6">
                                            <select name="jurusansekolah_id" id="jurusansekolah_id" class="form-control">
                                                @foreach ($jurusanSekolah as $jurusan)
                                                    <option value="{{ $jurusan->id }}">
                                                        {{ $jurusan->nama_jurusan }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </li>
                                <div>
                                    <div class="form-group row">
                                        <div>
                                            <button class="btn btn-cek-prodi" type="submit">Cek Program
                                                Studi</button>
                                        </div>
                                    </div>
                                </div>
                                <li>

                                </li>
                            </ul>

                        </div>
                    </div>
                </form>
            </div>
        </section><!-- End About Section -->

        <!-- ======= Services Section ======= -->
        <section id="tujuan" class="services">
            <div class="container" data-aos="fade-up">

                <div class="section-title">
                    <h2>Tujuan Karir</h2>
                    <h3>Prospek Lulusan <span>Program Studi</span></h3>
                </div>

                <div class="row">
                    <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="100">
                        <div class="icon-box">
                            <div class="icon"><i class="bx bx-laptop"></i></div>
                            <h4><a href="">S1 Sistem Informasi</a></h4>
                            <ul>
                                <li>Konsultan IT</li>
                                <li>System Analys</li>
                                <li>Project Manager IT</li>
                                <li>Database Administrator</li>
                                <li>Profesional di Bidang Infrastruktur keamanan, dan jaringan komputer</li>
                                <li>Software Development</li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-md-0" data-aos="zoom-in"
                        data-aos-delay="200">
                        <div class="icon-box">
                            <div class="icon"><i class="bx bx-laptop"></i></div>
                            <h4><a href="">S1 Informatika</a></h4>
                            <ul>
                                <li>Network Engineer dan Administrator</li>
                                <li>Security Engineer</li>
                                <li>Intelligent Sistem Developer</li>
                                <li>System Engineer</li>
                                <li>Technopreneur</li>
                                <li>Database Engineer</li>
                                <li>web Developer</li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-lg-0" data-aos="zoom-in"
                        data-aos-delay="300">
                        <div class="icon-box">
                            <div class="icon"><i class="bx bx-laptop"></i></div>
                            <h4><a href="">S1 Bisnis Digital</a></h4>
                            <ul>
                                <li>Analis Data Bisnis</li>
                                <li>Konsultan Bisnis Digital</li>
                                <li>Ahli Fintech</li>
                                <li>Praktisi Bisnis Digital</li>
                                <li>Social Media Officer</li>
                            </ul>
                        </div>
                    </div>
                    <div class="row justify-content-center" style="margin-top: 3%">
                        <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4" data-aos="zoom-in"
                            data-aos-delay="200" style="width: 55%">
                            <div class="icon-box">
                                <div class="icon"><i class="bx bx-slideshow"></i></div>
                                <h4><a href="">S1 Manajemen Ritel</a></h4>
                                <div class="list-container">
                                    <div class="list-box">
                                        <ul>
                                            <li>Project Manager</li>
                                            <li>Pricing Analyst</li>
                                            <li>Market Analyst</li>
                                            <li>Operation Manager</li>
                                            <li>Quality Assurance</li>
                                        </ul>
                                    </div>
                                    <div class="list-box">
                                        <ul>
                                            <li>Distribution Manager</li>
                                            <li>Business Manager</li>
                                            <li>Human Resource Manager</li>
                                            <li>Business Startup</li>
                                            <li>Store manager</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4" data-aos="zoom-in"
                            data-aos-delay="100">
                            <div class="icon-box">
                                <div class="icon"><i class="bx bx-slideshow"></i></div>
                                <h4><a href="">S1 Desain Komunikasi Visual</a></h4>
                                <ul>
                                    <li>Grafik Desainer</li>
                                    <li>Visual Komunikator</li>
                                    <li>Animator</li>
                                    <li>Creator Visual</li>
                                    <li>Sinematografer</li>
                                    <li>Video Editor</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section><!-- End Services Section -->

    </main><!-- End #main -->
@endsection
