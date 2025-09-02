<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Dokter - Rumah Sakit Laravel</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root {
      --hospital-blue: #1a77f2;
      --hospital-green: #2ecc71;
      --hospital-teal: #17a2b8;
      --hospital-purple: #9b59b6;
      --light-blue: #e8f4fd;
    }

    .navbar {
      background: linear-gradient(135deg, var(--hospital-blue), #0a58ca);
    }

    .dashboard-header {
      background: linear-gradient(135deg, var(--hospital-blue), #0a58ca);
      color: white;
      padding: 25px 0;
      margin-bottom: 30px;
    }

    .profile-card {
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
      overflow: hidden;
      margin-bottom: 30px;
    }

    .profile-header {
      background: linear-gradient(135deg, var(--hospital-blue), #0a58ca);
      color: white;
      padding: 20px;
      text-align: center;
    }

    .profile-img {
      width: 120px;
      height: 120px;
      border-radius: 50%;
      border: 4px solid white;
      margin: 0 auto 15px;
      object-fit: cover;
      background-color: #f8f9fa;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .profile-img i {
      font-size: 60px;
      color: white;
    }

    .profile-body {
      padding: 20px;
      background-color: white;
    }

    .info-item {
      display: flex;
      margin-bottom: 12px;
      border-bottom: 1px solid #f1f1f1;
      padding-bottom: 12px;
    }

    .info-item:last-child {
      border-bottom: none;
      margin-bottom: 0;
      padding-bottom: 0;
    }

    .info-icon {
      width: 24px;
      color: var(--hospital-blue);
      margin-right: 12px;
    }

    .info-content {
      flex: 1;
    }

    .section-title {
      color: #2c3e50;
      font-weight: 600;
      margin-bottom: 20px;
      padding-bottom: 12px;
      border-bottom: 2px solid #f8f9fa;
      display: flex;
      align-items: center;
    }

    .section-title i {
      background: linear-gradient(135deg, var(--hospital-blue), #0a58ca);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      margin-right: 10px;
      font-size: 1.2rem;
    }

    .table-container {
      background-color: white;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
      padding: 20px;
      margin-bottom: 30px;
      overflow: hidden;
    }

    .status-badge {
      padding: 6px 12px;
      border-radius: 20px;
      font-size: 0.85rem;
      font-weight: 500;
    }

    .status-approved {
      background-color: rgba(46, 204, 113, 0.2);
      color: #27ae60;
    }

    .status-pending {
      background-color: rgba(241, 196, 15, 0.2);
      color: #f39c12;
    }

    .action-btn {
      padding: 5px 10px;
      border-radius: 5px;
      font-size: 0.85rem;
      margin-right: 5px;
    }

    footer {
      background: linear-gradient(135deg, var(--hospital-blue), #0a58ca);
      margin-top: 30px;
    }

    @media (max-width: 768px) {
      .profile-img {
        width: 100px;
        height: 100px;
      }

      .profile-img i {
        font-size: 50px;
      }
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
          <li class="nav-item"><a class="nav-link text-white active" href="{{ route('doctor') }}">Home</a></li>
          <li class="nav-item"><a class="nav-link text-white" href="{{ route('examinations.index') }}">Riwayat</a></li>
          @auth
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button"
                data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-user me-2"></i>{{ Auth::user()->name ?? 'user ini' }}
                <span class="fw-light text-lowercase"
                  style="font-size: 0.8rem">({{ Auth::user()->role ?? 'user ini' }})</span>
              </a>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="#">Profile</a></li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <form action="{{ route('logout') }}" method="GET">
                  <button class="dropdown-item text-danger" type="submit">Logout</button>
                </form>
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

  @if(isset($error))
    <div class="alert alert-danger">
      <strong>{{ $error }}</strong>
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

  <!-- Dashboard Header -->
  <div class="dashboard-header">
    <div class="container">
      <h1 class="display-5 fw-bold"><i class="fas fa-tachometer-alt me-2"></i>Dashboard Dokter</h1>
      <p class="lead">Selamat datang di halaman dashboard dokter, {{ Auth::user()->name ?? 'user ini' }}. Berikut adalah
        ringkasan data jadwal kunjungan Anda.</p>
    </div>
  </div>

  <!-- Main Content -->
  <div class="container mb-5">
    <div class="row">
      <!-- Profile Section -->
      <div class="col-lg-4">
        <div class="profile-card">
          <div class="profile-header">
            <div class="profile-img">
              <i class="fas fa-user-md"></i>
            </div>
            <h4>Dr. {{ $doctor->user->name ?? Auth::user()->name }}</h4>
            <p class="mb-0">{{ $doctor->specialization ?? 'Dokter Spesialis' }}</p>
          </div>
          <div class="profile-body">
            <div class="info-item">
              <div class="info-icon">
                <i class="fas fa-briefcase-medical"></i>
              </div>
              <div class="info-content">
                <strong>Spesialisasi</strong>
                <p class="mb-0">{{ $doctor->specialization ?? 'Tidak tersedia' }}</p>
              </div>
            </div>
            <div class="info-item">
              <div class="info-icon">
                <i class="fas fa-map-marker-alt"></i>
              </div>
              <div class="info-content">
                <strong>Lokasi Praktik</strong>
                <p class="mb-0">{{ $doctor->practice_location ?? 'Tidak tersedia' }}</p>
              </div>
            </div>
            <div class="info-item">
              <div class="info-icon">
                <i class="fas fa-clock"></i>
              </div>
              <div class="info-content">
                <strong>Jam Praktik</strong>
                <p class="mb-0">{{ $doctor->practice_hours ?? 'Tidak tersedia' }}</p>
              </div>
            </div>
            <div class="info-item">
              <div class="info-icon">
                <i class="fas fa-phone"></i>
              </div>
              <div class="info-content">
                <strong>Telepon</strong>
                <p class="mb-0">{{ $doctor->phone_number ?? 'Tidak tersedia' }}</p>
              </div>
            </div>
            <div class="info-item">
              <div class="info-icon">
                <i class="fas fa-envelope"></i>
              </div>
              <div class="info-content">
                <strong>Email</strong>
                <p class="mb-0">{{ Auth::user()->email ?? 'Tidak tersedia' }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Patients Table Section -->
      <div class="col-lg-8">
        <div class="table-container">
          <h3 class="section-title"><i class="fas fa-user-injured me-2"></i>Daftar Pasien (Kunjungan Disetujui)</h3>

          @if(isset($approvedVisits) && $approvedVisits->count() > 0)
            <div class="alert alert-info">
              <i class="fas fa-info-circle me-2"></i>Menampilkan {{ $approvedVisits->count() }} kunjungan yang disetujui.
            </div>

            <div class="table-responsive">
              <table class="table table-hover">
                <thead>
                  <tr class="text-center">
                    <th>#</th>
                    <th>Nama Pasien</th>
                    <th>Keluhan</th>
                    <th>Tanggal & Waktu Kunjungan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($approvedVisits as $index => $visit)
                    <tr>
                      <td>{{ $index + 1 }}</td>
                      <td>{{ $visit->patient->user->name ?? 'Nama tidak tersedia' }}</td>
                      <td>{{ $visit->complaint }}</td>
                      <td class="text-center">{{ \Carbon\Carbon::parse($visit->requested_date)->format('d M Y') . ' - ' . \Carbon\Carbon::parse($visit->requested_time)->format('H:i') }}</td>
                      <td><span class="status-badge status-approved">{{ $visit->status }}</span></td>
                      <td class="text-center">
                        <button class="btn btn-sm btn-primary action-btn"><i class="fas fa-eye"></i></button>
                        <a href="{{ route('examinations.create', $visit->id) }}" class="btn btn-sm btn-success action-btn"><i class="fas fa-edit"></i></a>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          @else
            <div class="alert alert-info">
              <i class="fas fa-info-circle me-2"></i>Tidak ada kunjungan yang disetujui untuk saat ini.
            </div>
          @endif
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
</body>

</html>