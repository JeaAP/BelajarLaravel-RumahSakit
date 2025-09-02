<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Riwayat Pemeriksaan - Rumah Sakit Laravel</title>
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

    .status-under_treatment {
      background-color: rgba(52, 152, 219, 0.2);
      color: #2980b9;
    }

    .status-recovered {
      background-color: rgba(46, 204, 113, 0.2);
      color: #27ae60;
    }

    .status-referred {
      background-color: rgba(155, 89, 182, 0.2);
      color: #8e44ad;
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
          <li class="nav-item"><a class="nav-link text-white" href="{{ route('doctor') }}">Home</a></li>
          <li class="nav-item"><a class="nav-link text-white active"
              href="{{ route('examinations.index') }}">Riwayat</a></li>
          @auth
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button"
                data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-user me-2"></i>{{ Auth::user()->name }}
                <span class="fw-light text-lowercase" style="font-size: 0.8rem">({{ Auth::user()->role }})</span>
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
    <div class="alert alert-success alert-dismissible fade show mx-3 mt-3" role="alert">
      <strong>{{ session('success') }}</strong>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show mx-3 mt-3" role="alert">
      <strong>{{ session('error') }}</strong>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show mx-3 mt-3" role="alert">
      <strong>Whoops!</strong> Ada kesalahan.<br><br>
      <ul>
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  <!-- Dashboard Header -->
  <div class="dashboard-header">
    <div class="container">
      <h1 class="display-5 fw-bold"><i class="fas fa-history me-2"></i>Riwayat Pemeriksaan</h1>
      <p class="lead">Berikut adalah riwayat pemeriksaan pasien yang telah Anda lakukan.</p>
    </div>
  </div>

  <!-- Main Content -->
  <div class="container mb-5">
    <div class="table-container">
      <h3 class="mb-4"><i class="fas fa-list-alt me-2"></i>Daftar Pemeriksaan</h3>

      @if($examinations->count() > 0)
        <div class="alert alert-info">
          <i class="fas fa-info-circle me-2"></i>Menampilkan {{ $examinations->count() }} pemeriksaan.
        </div>

        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr class="text-center">
                <th>#</th>
                <th>Nama Pasien</th>
                <th>Diagnosis</th>
                <th>Tanggal Pemeriksaan</th>
                <th>Status Pasien</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach($examinations as $index => $examination)
                <tr>
                  <td>{{ $index + 1 }}</td>
                  <td>{{ $examination->visit->patient->user->name ?? 'Nama tidak tersedia' }}</td>
                  <td>{{ Str::limit($examination->diagnosis, 50) }}</td>
                  <td class="text-center">{{ $examination->created_at->format('d M Y H:i') }}</td>
                  <td class="text-center">
                    @php
                      $statusClass = 'status-under_treatment';
                      if ($examination->patient_status === 'recovered') {
                        $statusClass = 'status-recovered';
                      } elseif ($examination->patient_status === 'referred') {
                        $statusClass = 'status-referred';
                      }
                    @endphp
                    <span class="status-badge {{ $statusClass }}">
                      @if($examination->patient_status === 'under_treatment')
                        Dalam Perawatan
                      @elseif($examination->patient_status === 'recovered')
                        Sembuh
                      @else
                        Dirujuk
                      @endif
                    </span>
                  </td>
                  <td class="text-center">
                    <a href="{{ route('examinations.show', $examination) }}" class="btn btn-sm btn-primary action-btn"><i
                        class="fas fa-eye"></i> Detail</a>
                    <a href="{{ route('examinations.edit', $examination) }}" class="btn btn-sm btn-success action-btn"><i
                        class="fas fa-edit"></i> Edit</a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @else
        <div class="alert alert-info">
          <i class="fas fa-info-circle me-2"></i>Belum ada riwayat pemeriksaan.
        </div>
      @endif
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