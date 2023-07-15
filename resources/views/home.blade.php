@php
    use Carbon\Carbon; 

    $totalAlumni = count($alumni); // Total jumlah alumni

    $negeriCount = $alumni->where('perusahaan', 'Negeri')->count(); // Jumlah alumni dengan pekerjaan 'Negeri'
    $swastaCount = $alumni->where('perusahaan', 'Swasta')->count(); // Jumlah alumni dengan pekerjaan 'Swasta'

    if ($totalAlumni !== 0) {
        $negeriPercentage = ($negeriCount / $totalAlumni) * 100;
        $swastaPercentage = ($swastaCount / $totalAlumni) * 100;
    } else {
        $negeriPercentage = 0;
        $swastaPercentage = 0;
    }
@endphp

@extends('main')

@section('body')
    {{-- HEADER --}}
    <header>

        <!-- TITLE HEADER -->
        <div class="title-header text-center text-light ms-auto">
            <h3 class="subtitle-header">Sistem Informasi Data Alumni</h3>
            <h4 class="subtitle-header">Politeknik Negeri Banjarmasin</h4>
        </div>
        <!-- END TITLE HEADER -->

        <!-- BERITA -->
        <div class="container berita text-light pb-5">
            <div id="carouselExampleIndicators" class="carousel slide">
                <div class="carousel-indicators mb-0">
                    @foreach ($posts as $key => $post)
                        <button type="button" data-bs-target="#carouselExampleIndicators"
                            data-bs-slide-to="{{ $key }}" class="{{ $loop->first ? 'active' : '' }}"
                            aria-current="{{ $loop->first ? 'true' : 'false' }}"
                            aria-label="Slide {{ $key + 1 }}"></button>
                    @endforeach
                </div>
                <div class="carousel-inner bg-opacity-25 py-4" style="border-radius: 16px;">
                    @foreach ($posts as $key => $post)
                        <div class="carousel-item{{ $loop->first ? ' active' : '' }}">
                            <div class="container mx-lg-5 mx-sm-2">
                                <div class="row justify-content-center">
                                    <div class="col-lg-4 col-11 mb-lg-0 mb-2">
                                        <div class="gambar-post d-flex justify-content-center">
                                            <img src="/storage/{{ $post->foto_post }}" alt="{{ $post->judul_post }}"
                                                class="shadow img-fluid" style="height: 35vh; border-radius: 15px; max-width: 100%">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-11 mx-lg-0 mx-md-3 mx-sm-1">
                                        <div class="body-post">
                                            <h4 class="fw-bold mb-2">{{ $post->judul_post }}</h4>
                                            <h6 class="fst-italic mb-2">
                                                Diposting pada {{ \Carbon\Carbon::parse($post->created_at)->format('j F Y') }} oleh {{ Str::limit($post->user->name, 20) }}
                                                {{ ($post->user->name === "Admin") ? "" : "- ".$post->user->alumni->prodi->nama_prodi }}
                                                {{ ($post->user->name === "Admin") ? "" : $post->user->alumni->angkatan->tahun_angkatan }}
                                            </h6>
                                            <div class="d-flex align-items-center my-2">
                                                <div class="d-flex align-items-center @if($post->kategori === 'Event') bg-primary @elseif($post->kategori === 'Feedback') bg-success @elseif($post->kategori === 'Loker') bg-warning @endif" style="border-radius: 9px; height: 22px;">
                                                    <h6 class="p-2 mt-1 text-light">{{ $post->kategori }}</h6>
                                                </div>                                 
                                            </div>                                                                           
                                            <div class="isi text-justify overflow-y-hidden" style="height: 9vh;">
                                                <p>{{ $post->isi }}</p>
                                            </div>
                                            <button type="button" class="btn btn-primary my-2" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal-{{ $post->id }}">Detail</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Modal --}}
                        <div class="modal fade text-dark" id="exampleModal-{{ $post->id }}" tabindex="-1"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content" style="width: 50vw;">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5 fw-bold" id="exampleModalLabel">{{ $post->judul_post }}
                                            <br></h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body overflow-y-scroll" style="height: 65vh;">
                                        <p class="fw-bold fst-italic mb-2">
                                            Diposting pada {{ \Carbon\Carbon::parse($post->created_at)->format('j F Y') }} oleh {{ $post->user->name }}
                                            {{ ($post->user->name === "Admin") ? "" : "- ".$post->user->alumni->prodi->nama_prodi }}
                                            {{ ($post->user->name === "Admin") ? "" : $post->user->alumni->angkatan->tahun_angkatan }}
                                        </p>
                                        <div class="d-flex align-items-center my-2">
                                            <div class="d-flex align-items-center @if($post->kategori === 'Event') bg-primary @elseif($post->kategori === 'Feedback') bg-success @elseif($post->kategori === 'Loker') bg-warning @endif" style="border-radius: 9px; height: 22px;">
                                                <h6 class="p-2 mt-1 text-light">{{ $post->kategori }}</h6>
                                            </div>                                 
                                        </div>   
                                        <img src="/storage/{{ $post->foto_post }}" alt="{{ $post->judul_post }}"
                                            style="width:100%;">
                                        <p class="text-justify mt-3">{{ $post->isi }}</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- END MODAL --}}
                    @endforeach
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                        data-bs-slide="prev" style="width: 5%;">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                        data-bs-slide="next" style="width: 5%;">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
        <!-- END BERITA -->
    </header>
    {{-- END HEADER --}}

    {{-- MAIN --}}
    <main class="container-fluid" style="padding-top: 10vh">

        <h4 class="subtitle-header text-center mb-5" id="data-alumni">Data Alumni</h4>

        <!-- CARD -->
        <div class="container">
            <div class="row">
                <!-- Jumlah Alumni -->
                <div class="col-lg col-md-6 col-sm-12 mb-3 mb-sm-0 my-2">
                    <div class="card shadow" style="border-radius: 16px;">
                        <div class="card-body" style="min-height: 150px;">
                            <div class="title-card pt-2">
                                <p class="card-title">Jumlah Alumni</p>
                            </div>
                            <div class="value-card container text-center" style="height:70px;">
                                <div class="row align-items-end h-100 pb-2">
                                    <div class="col d-flex justify-content-center">
                                        <h4 class="card-text">{{ $alumni->count() }}</h4>
                                    </div>
                                    <div class="col-4">
                                        <i class="fas fa-user-graduate"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Jumlah Alumni -->

                <!-- Jumlah Berdasarkan Gender -->
                <div class="col-lg col-md-6 col-sm-12 mb-3 mb-sm-0 my-2">
                    <div class="card shadow" style="border-radius: 16px;">
                        <div class="card-body" style="min-height: 150px;">
                            <div class="title-card pt-2">
                                <p class="card-title">Jumlah Alumni Berdasarkan Gender</p>
                            </div>
                            <div class="value-card container">
                                <div class="row align-items-end h-100 pb-2">
                                    <div class="col-lg-3 col-md-6 col-sm-6 col-6 d-flex justify-content-center mb-lg-0 mb-1">
                                        <h5 class="card-text">{{ $alumni->where('gender', 'Laki-laki')->count() }}</h5>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-6 col-6 d-flex justify-content-center mb-lg-0 mb-1">
                                        <i class="fas fa-male"></i>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-6 col-6 d-flex justify-content-center mb-lg-0">
                                        <h5 class="card-text">{{ $alumni->where('gender', 'Perempuan')->count() }}</h5>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-6 col-6 d-flex justify-content-center mb-lg-0">
                                        <i class="fas fa-female"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END Jumlah Berdasarkan Gender -->

                <!-- Rata-rata IPK -->
                <div class="col-lg col-md-6 col-sm-12 mb-3 mb-sm-0 my-2">
                    <div class="card shadow" style="border-radius: 16px;">
                        <div class="card-body" style="min-height: 150px;">
                            <div class="title-card pt-2">
                                <p class="card-title">Rata-rata IPK</p>
                            </div>
                            <div class="value-card container text-center">
                                <div class="row align-items-end pb-2">
                                    <div class="col d-flex justify-content-center">
                                        <h4 class="card-text">{{ number_format($alumni->avg('ipk'), 2) }}</h4>
                                    </div>
                                    <div class="col-4">
                                        <i class="fas fa-book"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END Rata-rata IPK -->

                <!-- Pekerjaan -->
                <div class="col-lg-4 col-md-6 col-sm-12 mb-3 mb-sm-0 my-2">
                    <div class="card shadow" style="border-radius: 16px;">
                        <div class="card-body" style="min-height: 150px;">
                            <div class="title-card pt-2">
                                <p class="card-title">Pekerjaan</p>
                            </div>
                            <div class="value-card container">
                                <div class="row align-items-end pb-2">
                                    <div class="col fw-bold">
                                        <p class="card-text mb-0">Negeri: {{ number_format($negeriPercentage, 2) }}%</p>
                                        <p class="card-text">Swasta: {{ number_format($swastaPercentage, 2) }}%</p>
                                    </div>
                                    <div class="col-4">
                                        <i class="fas fa-briefcase"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END Pekerjaan -->

            </div>
        </div>
        <!-- END CARD -->


        <!-- Tabel Data Alumni -->
        <div class="container" style="margin-top: 10vh">
            <div class="row">
                <div class="col">
                    <div class="card shadow">
                        <div class="card-body">
                            <h5 class="subtitle-header text-center mt-3 mb-4" id="data-alumni">Tabel Data Alumni</h5>
                            <div class="table-responsive">
                                <table id="alumni" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Foto</th>
                                            <th>Nama</th>
                                            <th>NIM</th>
                                            <th>Email</th>
                                            <th>Jurusan</th>
                                            <th>Program Studi</th>
                                            <th>Tahun Angkatan</th>
                                            <th>Judul TA</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($alumni as $alumnus)
                                            <tr>
                                                <td>
                                                    <img src="/storage/{{ $alumnus->foto }}" alt="" width="80px"
                                                        height="107px" class="ms-auto" style="border-radius: 9px;">
                                                </td>
                                                <td style="vertical-align: middle">{{ $alumnus->nama_alumni }}</td>
                                                <td style="vertical-align: middle">{{ $alumnus->nim }}</td>
                                                <td style="vertical-align: middle">{{ $alumnus->email_alumni }}</td>
                                                <td style="vertical-align: middle">{{ $alumnus->jurusan->nama_jurusan }}
                                                </td>
                                                <td style="vertical-align: middle">{{ $alumnus->prodi->nama_prodi }}</td>
                                                <td style="vertical-align: middle">{{ $alumnus->angkatan->tahun_angkatan }}
                                                </td>
                                                <td style="vertical-align: middle">{{ $alumnus->judul_ta }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Tabel Data Alumni -->

         <!-- Tabel Data Narahubung -->
         <div class="container" style="margin-top: 10vh">
            <div class="row">
                <div class="col">
                    <div class="card shadow">
                        <div class="card-body">
                            <h5 class="subtitle-header text-center mt-3 mb-4" id="data-alumni">Tabel Data Narahubung</h5>
                            <div class="table-responsive">
                                <table id="narahubung" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Tahun Angkatan</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($narahubung as $nh)
                                            <tr>
                                                <td style="vertical-align: middle">{{ $nh->angkatan->tahun_angkatan }}</td>
                                                <td style="vertical-align: middle">{{ $nh->nama_narahubung }}</td>
                                                <td style="vertical-align: middle"><a href="mailto:{{ $nh->email_narahubung }}" target="_blank">{{ $nh->email_narahubung }}</a></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Tabel Data Narahubung -->

    </main>
    {{-- END MAIN --}}
@endsection
