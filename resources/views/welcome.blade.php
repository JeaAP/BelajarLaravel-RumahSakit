<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rumah Sakit Laravel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --hospital-blue: #1a77f2;
            --hospital-green: #2ecc71;
            --hospital-teal: #17a2b8;
            --light-blue: #e8f4fd;
        }

        .navbar {
            background: linear-gradient(135deg, var(--hospital-blue), #0a58ca);
        }

        .hero {
            background: linear-gradient(rgba(26, 119, 242, 0.85), rgba(23, 162, 184, 0.85)), url('https://images.unsplash.com/photo-1532938911079-1b06ac7ceec7?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1480&q=80');
            background-size: cover;
            background-position: center;
        }

        .service-card {
            transition: transform 0.3s ease;
        }

        .service-card:hover {
            transform: translateY(-5px);
        }

        .stat-card {
            border-radius: 12px;
            position: relative;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-card::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            transform: translate(30%, -30%);
        }

        .bg-doctors {
            background: linear-gradient(135deg, var(--hospital-blue), #3b89ff);
        }

        .bg-patients {
            background: linear-gradient(135deg, var(--hospital-green), #34d399);
        }

        .form-section,
        .table-container {
            border-radius: 12px;
        }

        footer {
            background: linear-gradient(135deg, var(--hospital-blue), #0a58ca);
        }

        .modal-header {
            background: linear-gradient(135deg, var(--hospital-blue), #0a58ca);
            color: white;
        }

        .visit-detail-row {
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }

        .detail-label {
            font-weight: 600;
            color: #555;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">
                <i class="fas fa-hospital me-2"></i>Rumah Sakit Laravel
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link text-white" href="{{ route('home') }}">Home</a></li>
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user me-2"></i>{{ Auth::user()->name }}
                                <span class="fw-light text-lowercase"
                                    style="font-size: 0.8rem">({{ Auth::user()->role }})</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                @if (Auth::user()->role == 'user')
                                    <li><a class="dropdown-item"
                                            href="{{ route('profile.show', Auth::user()->id) }}">Profile</a></li>
                                    <li>
                                @endif
                                    <form action="{{ route('logout') }}" method="GET">
                                        <button class="dropdown-item text-danger" type="submit">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item"><a class="nav-link text-white" href="{{ route('login') }}">Login</a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    @if(session('success'))
        <div class="alert alert-success">
            <strong>{{ session('success') }}</strong>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> Ada kesalahan.<br><br>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Hero Section -->
    <section class="hero text-white text-center py-5 mb-5">
        <div class="container py-5">
            <h1 class="display-4 fw-bold mb-4">Rumah Sakit Laravel</h1>
            <p class="lead mb-4">Memberikan pelayanan kesehatan terbaik dengan teknologi terkini dan tenaga medis
                profesional</p>
            @auth
                <a href="#appointment" class="btn btn-light btn-lg px-4 py-2">Buat Janji Temu</a>
            @else
                <a href="{{ route('login') }}" class="btn btn-light btn-lg px-4 py-2">Login untuk buat janji temu</a>
            @endauth
        </div>
    </section>

    <!-- Services Section -->
    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Layanan Kami</h2>
                <p class="text-muted">Berbagai layanan kesehatan profesional untuk kebutuhan medis Anda</p>
            </div>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card service-card h-100 text-center p-4 shadow-sm">
                        <div class="card-body">
                            <div class="text-primary mb-4" style="font-size: 3rem;">
                                <i class="fas fa-ambulance"></i>
                            </div>
                            <h4 class="card-title">IGD 24 Jam</h4>
                            <p class="card-text">Layanan gawat darurat siap melayani 24 jam dengan tenaga medis
                                profesional.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card service-card h-100 text-center p-4 shadow-sm">
                        <div class="card-body">
                            <div class="text-primary mb-4" style="font-size: 3rem;">
                                <i class="fas fa-user-md"></i>
                            </div>
                            <h4 class="card-title">Konsultasi Dokter</h4>
                            <p class="card-text">Konsultasi dengan dokter spesialis berpengalaman di bidangnya.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card service-card h-100 text-center p-4 shadow-sm">
                        <div class="card-body">
                            <div class="text-primary mb-4" style="font-size: 3rem;">
                                <i class="fas fa-procedures"></i>
                            </div>
                            <h4 class="card-title">Rawat Inap</h4>
                            <p class="card-text">Kamar rawat inap nyaman dengan fasilitas lengkap dan perawat standby.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <div class="stat-card bg-doctors text-white p-4 shadow-sm">
                        <i class="fas fa-user-md fs-1 mb-3 opacity-75"></i>
                        <h4>Total Dokter</h4>
                        <h2 class="fw-bold">{{ $totalDoctors }}</h2>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="stat-card bg-patients text-white p-4 shadow-sm">
                        <i class="fas fa-procedures fs-1 mb-3 opacity-75"></i>
                        <h4>Total Kamar</h4>
                        <h2 class="fw-bold">{{ $totalRooms }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Appointment Section -->
    @auth
        <section id="appointment" class="py-5">
            <div class="container">
                <div class="form-section bg-white p-4 shadow-sm mb-4">
                    <h3 class="text-primary border-bottom pb-2 mb-3"><i class="fas fa-calendar-check me-2"></i>Ajukan
                        Kunjungan</h3>
                    <form method="POST" action="{{  route('visits.store') }}">
                        @csrf

                        <input type="hidden" name="patient_id" value="{{ $patient->id }}">

                        <div class="mb-3">
                            <label for="complaint" class="form-label fw-semibold">Keluhan Penyakit</label>
                            <textarea class="form-control" id="complaint" name="complaint" rows="3" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="treatment_request" class="form-label fw-semibold">Permintaan Treatment</label>
                            <select class="form-select" id="treatment_request" name="treatment_request" required>
                                <option value="" disabled selected>Pilih</option>
                                <option value="Rawat Inap">Rawat Inap</option>
                                <option value="Rawat Jalan">Rawat Jalan</option>
                                <option value="Operasi">Operasi</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="visit_date" class="form-label fw-semibold">Tanggal Kunjungan</label>
                            <input type="date" class="form-control" name="requested_date" id="visit_date" required>
                        </div>

                        <div class="mb-3">
                            <label for="visit_time" class="form-label fw-semibold">Waktu Kunjungan</label>
                            <input type="time" class="form-control" name="requested_time" id="visit_time" required>
                        </div>
                        <button type="submit" class="btn btn-primary" @if(Auth::user()->role != 'user') disabled @endif><i
                                class="fas fa-paper-plane me-2"></i>Ajukan</button>
                    </form>
                </div>

                <!-- Kunjungan Saya -->
                <div class="table-container bg-white p-4 shadow-sm">
                    <h4 class="text-primary mb-3"><i class="fas fa-list me-2"></i>Daftar Kunjungan Saya</h4>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">Keluhan</th>
                                    <th scope="col">Tanggal, Waktu kunjungan</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($visits->isEmpty())
                                    <tr>
                                        <td colspan="4" class="text-center">Belum ada kunjungan yang diajukan.</td>
                                    </tr>
                                @endif
                                @foreach($visits as $visit)
                                    <tr class="{{ $visit->status == 'rejected' ? 'table-secondary' : '' }}">
                                        <td>{{ Str::limit($visit->complaint, 30) }}</td>
                                        <td>{{ \Carbon\Carbon::parse($visit->requested_date)->format('d-m-Y') }} -
                                            {{ \Carbon\Carbon::parse($visit->requested_time)->format('H:i') }}
                                        </td>
                                        <td>
                                            @if($visit->status == 'pending')
                                                <span class="badge rounded-pill bg-warning">Menunggu</span>
                                            @elseif($visit->status == 'approved')
                                                <span class="badge rounded-pill bg-success">Disetujui</span>
                                            @elseif($visit->status == 'rejected')
                                                <span class="badge rounded-pill bg-danger">Dibatalkan</span>
                                            @else
                                                <span class="badge rounded-pill bg-info">{{ $visit->status }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal"
                                                data-bs-target="#visitModal" data-complaint="{{ $visit->complaint }}"
                                                data-date="{{ \Carbon\Carbon::parse($visit->requested_date)->format('d-m-Y') }}"
                                                data-time="{{ \Carbon\Carbon::parse($visit->requested_time)->format('H:i') }}"
                                                data-treatment="{{ $visit->treatment_request }}"
                                                data-doc="{{ $visit->doctor ? $visit->doctor->user->name : 'Belum ada dokter' }}"
                                                data-status="{{ $visit->status }}" data-id="{{ $visit->id }}">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    @endauth

    <!-- Modal Detail Kunjungan -->
    <div class="modal fade" id="visitModal" tabindex="-1" aria-labelledby="visitModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="visitModalLabel">Detail Kunjungan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row visit-detail-row">
                        <div class="col-md-3 detail-label">Keluhan:</div>
                        <div class="col-md-9" id="modal-complaint"></div>
                    </div>
                    <div class="row visit-detail-row">
                        <div class="col-md-3 detail-label">Tanggal:</div>
                        <div class="col-md-9" id="modal-date"></div>
                    </div>
                    <div class="row visit-detail-row">
                        <div class="col-md-3 detail-label">Waktu:</div>
                        <div class="col-md-9" id="modal-time"></div>
                    </div>
                    <div class="row visit-detail-row">
                        <div class="col-md-3 detail-label">Permintaan Treatment:</div>
                        <div class="col-md-9" id="modal-treatment"></div>
                    </div>
                    <div class="row visit-detail-row">
                        <div class="col-md-3 detail-label">Dokter Penanggung Jawab:</div>
                        <div class="col-md-9" id="modal-doc"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 detail-label">Status:</div>
                        <div class="col-md-9">
                            <span id="modal-status"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div id="modal-actions"></div>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-white py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5>Rumah Sakit Laravel</h5>
                    <p>Memberikan pelayanan kesehatan terbaik dengan teknologi terkini dan tenaga medis profesional.</p>
                </div>
                <div class="col-md-4 mb-4">
                    <h5>Kontak Kami</h5>
                    <p><i class="fas fa-map-marker-alt me-2"></i> Jl. Kesehatan No. 123, Jakarta</p>
                    <p><i class="fas fa-phone me-2"></i> (021) 1234-5678</p>
                    <p><i class="fas fa-envelope me-2"></i> info@rslaravel.com</p>
                </div>
                <div class="col-md-4 mb-4">
                    <h5>Jam Operasional</h5>
                    <p>Senin - Jumat: 24 Jam</p>
                    <p>Sabtu - Minggu: 24 Jam</p>
                    <p>IGD: 24 Jam Setiap Hari</p>
                </div>
            </div>
            <hr class="my-4">
            <div class="text-center">
                <p>&copy; 2023 Rumah Sakit Laravel. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        visitModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;

            const complaint = button.getAttribute('data-complaint');
            const date = button.getAttribute('data-date');
            const time = button.getAttribute('data-time');
            const treatment = button.getAttribute('data-treatment');
            const status = button.getAttribute('data-status');
            const visitId = button.getAttribute('data-id');

            document.getElementById('modal-complaint').textContent = complaint;
            document.getElementById('modal-date').textContent = date;
            document.getElementById('modal-time').textContent = time;
            document.getElementById('modal-treatment').textContent = treatment;

            const statusElement = document.getElementById('modal-status');
            let badgeClass = '';
            let statusText = '';

            switch (status) {
                case 'pending':
                    badgeClass = 'bg-warning';
                    statusText = 'Menunggu';
                    break;
                case 'approved':
                    badgeClass = 'bg-success';
                    statusText = 'Disetujui';
                    break;
                case 'rejected':
                    badgeClass = 'bg-danger';
                    statusText = 'Dibatalkan';
                    break;
                default:
                    badgeClass = 'bg-info';
                    statusText = status;
            }

            statusElement.innerHTML = `<span class="badge rounded-pill ${badgeClass}">${statusText}</span>`;

            const actions = document.getElementById('modal-actions');
            if (status === 'pending') {
                actions.innerHTML = `
            <form action="/visits/${visitId}" method="POST" class="d-inline-block">
                @csrf
                @method('PUT')
                <input type="hidden" name="status" value="rejected">
                <button type="submit" class="btn btn-sm btn-danger btn-reject"
                    onclick="return confirm('Apakah Anda yakin ingin membatalkan kunjungan ini?')">
                    <i class="fas fa-times me-2"></i>Batal Kunjungan
                </button>
            </form>
        `;
            } else {
                actions.innerHTML = '';
            }
        });
    </script>
</body>

</html>