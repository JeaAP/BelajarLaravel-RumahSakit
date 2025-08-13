<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Home</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />

    <style>
        .profile-picture {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        .hero-section {
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),
                url('https://images.unsplash.com/photo-1579684385127-1ef15d508118?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
            margin-bottom: 30px;
        }

        .hero-title {
            font-size: 3rem;
            font-weight: bold;
        }

        .feature-card {
            transition: transform 0.3s;
            margin-bottom: 20px;
            height: 100%;
        }

        .feature-card:hover {
            transform: translateY(-10px);
        }

        .feature-icon {
            font-size: 2.5rem;
            margin-bottom: 15px;
            color: #0d6efd;
        }
    </style>
</head>

<body>
    @auth
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Rumah Sakit</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">IGD</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('doctors.index') }}">Dokter</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Pasien</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Ruangan Rawat Inap</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Pendaftaran</a>
                        </li>
                    </ul>

                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        @auth
                            <li class="nav-item dropdown">
                                <a class="nav-link d-flex align-items-center dropdown-toggle" href="#" id="userDropdown"
                                    role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="{{ auth()->user()->profile_picture ? asset('images/' . auth()->user()->profile_picture) : url('https://via.placeholder.com/150') }}"
                                        alt="Profile Picture" class="profile-picture" />
                                </a>

                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                    <li>
                                        <h6 class="dropdown-header">{{ auth()->user()->role }}</h6>
                                    </li>
                                    <li><a class="dropdown-item" href="{{ route('profile') }}">Tambahkan foto profil</a></li>
                                    <li>
                                        <hr class="dropdown-divider" />
                                    </li>
                                    <li>
                                        <form action="{{ route('logout') }}" method="GET">
                                            @csrf
                                            <button type="submit" class="dropdown-item">Logout</button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Login</a>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container-fluid px-0">
            <!-- Hero Section -->
            <div class="hero-section">
                <div>
                    <h1 class="hero-title">Sistem Informasi Rumah Sakit</h1>
                    <p class="lead">Pelayanan kesehatan terbaik untuk Anda dan keluarga</p>
                </div>
            </div>

            <!-- Features Section -->
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card feature-card">
                            <div class="card-body text-center">
                                <div class="feature-icon">
                                    <i class="fas fa-user-md"></i>
                                </div>
                                <h5 class="card-title">Dokter Profesional</h5>
                                <p class="card-text">Tim dokter berpengalaman siap memberikan pelayanan terbaik.</p>
                                <a href="{{ route('doctors.index') }}" class="btn btn-primary">Lihat Dokter</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card feature-card">
                            <div class="card-body text-center">
                                <div class="feature-icon">
                                    <i class="fas fa-procedures"></i>
                                </div>
                                <h5 class="card-title">Ruangan Nyaman</h5>
                                <p class="card-text">Fasilitas rawat inap dengan kenyamanan terbaik untuk pasien.</p>
                                <a href="#" class="btn btn-primary">Lihat Ruangan</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card feature-card">
                            <div class="card-body text-center">
                                <div class="feature-icon">
                                    <i class="fas fa-ambulance"></i>
                                </div>
                                <h5 class="card-title">IGD 24 Jam</h5>
                                <p class="card-text">Pelayanan gawat darurat siap membantu Anda kapan saja.</p>
                                <a href="#" class="btn btn-primary">Info IGD</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        @if (request()->is('/'))
            {{ redirect()->intended(route('login'))->send() }}
        @endif
    @endauth

    <!-- Font Awesome for icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
</body>

</html>