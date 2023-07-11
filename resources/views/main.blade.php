<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet"
        href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <title>{{ $title }}</title>
</
head>

<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="/">SI Data Alumni</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ ($title === "Berita | SI Data Alumni") ? 'active fw-bold' : '' }}" href="/posts">Berita</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ ($title === "Team | SI Data Alumni") ? 'active fw-bold' : '' }}" href="/team">Team</a>
                    </li>
                </ul>
                @php
                    use Illuminate\Support\Str;
                @endphp
                @if (Auth::check())
                    <div class="dropdown">
                        <button class="btn btn-outline-dark dropdown-toggle" type="button" id="dropdownMenuButton"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width:125px ;">
                            {{ Str::limit(Auth::user()->name, 5) }}
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="/dashboard">Dashboard</a>
                            <a class="dropdown-item" href="/logout">Keluar</a>
                        </div>
                    </div>
                @else
                    <a href="/dashboard"><button class="btn btn-outline-dark" style="width:125px ;">Masuk</button></a>
                @endif
            </div>
        </div>
    </nav>
    <!-- END NAVBAR -->

    @yield('body')

    {{-- FOOTER --}}
    <footer>
        <div class="informasi container mt-5 py-3">
            <div class="row">
                <div class="col">
                    <div class="logo-poliban text-center">
                        <img src="img/logo-poliban-transparan.png" alt="" height="150px" class="img-fluid m-auto">
                    </div>
                    <div class="contact mt-3">
                        <div class="row mb-0">
                            <div class="col-1">
                                <i class="fas fa-location-arrow text-danger"></i>
                            </div>
                            <div class="col">
                                <p>Jl. Brigjen H. Hasan Basri, Kayu Tangi, Banjarmasin 70123</p>
                            </div>
                        </div>
                        <div class="row mb-0">
                            <div class="col-1">
                                <i class="fas fa-phone-alt text-danger"></i>
                            </div>
                            <div class="col">
                                <p>Phone / Fax: (0511) 330 5052</p>
                            </div>
                        </div>
                        <div class="row mb-0">
                            <div class="col-1">
                                <i class="fas fa-envelope-open-text text-danger"></i>
                            </div>
                            <div class="col">
                                <p>Email: info@poliban.ac.id</p>
                            </div>
                        </div>
                    </div>
                    <div class="sosmed container mt-3">
                        <div class="row">
                            <div class="col-3">
                                <a href="https://www.facebook.com/poliban.ac.id" target="_blank">
                                    <div class="icon" style="background-color: #3b5998;">
                                        <i class="fab fa-facebook text-light"></i>
                                    </div>
                                </a>
                            </div>
                            <div class="col-3">
                                <a href="https://twitter.com/humaspoliban" target="_blank">
                                    <div class="icon" style="background-color: #1da1f2;">
                                        <i class="fab fa-twitter text-light"></i>
                                    </div>
                                </a>
                            </div>
                            <div class="col-3">
                                <a href="https://www.instagram.com/poliban_official/" target="_blank">
                                    <div class="icon" style="background-color: #cc11a6;">
                                        <i class="fab fa-instagram text-light"></i>
                                    </div>
                                </a>
                            </div>
                            <div class="col-3">
                                <a href="https://www.youtube.com/channel/UC5CfzvUTqEUPXhwwSLvP53Q" target="_blank">
                                    <div class="icon" style="background-color: #cd201f;">
                                        <i class="fab fa-youtube text-light"></i>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="title">
                        <h6>UNIT</h6>
                    </div>
                    <ul>
                        <li><a href="tik.poliban.ac.id" target="_blank">UPT TIK</a></li>
                        <li><a href="poliban.ac.id" target="_blank">P3M</a></li>
                    </ul>
                </div>
                <div class="col">
                    <div class="title">
                        <h6>INFORMASI</h6>
                    </div>
                    <ul>
                        <li><a href="simpadu.poliban.ac.id" target="_blank">SIMPADU</a></li>
                        <li><a href="elearning.poliban.ac.id" target="_blank">E-Learning</a></li>
                        <li><a href="porseni.poliban.ac.id" target="_blank">PORSENI 2022</a></li>
                        <li><a href="sipma.poliban.ac.id/publik" target="_blank">Sistem Informasi Penelitian dan Pengabdian Kepada Masyarakat</a></li>
                    </ul>
                </div>
                <div class="col">
                    <div class="title">
                        <h6>LAYANAN</h6>
                    </div>
                    <ul>
                        <li><a href="poliban.ac.id" target="_blank">SIPMA</a></li>
                        <li><a href="ejurnal.poliban.ac.id" target="_blank">E-JURNAL</a></li>
                        <li><a href="sijari.poliban.ac.id/Auth" target="_blank">Sistem Informasi Kinerja Riset</a></li>
                        <li><a href="repository.poliban.ac.id" target="_blank">Repository</a></li>
                        <li><a href="e-prosiding.poliban.ac.id" target="_blank">E-Proceding</a></li>
                        <li><a href="press.poliban.ac.id" target="_blank">Poliban Press</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="copyright container-fluid text-center bg-dark text-white mt-5">
            <p class="m-auto">Copyright @2023 All Right Reserved – Politeknik Negeri Banjarmasin</p>
        </div>
    </footer>
    {{-- END FOOTER --}}

    <!-- Javascript -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
    </script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="js/script.js"></script>
</body>

</html>
