<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - Rumah Sakit Laravel</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

    .stat-card {
      border-radius: 12px;
      position: relative;
      overflow: hidden;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      color: white;
      height: 100%;
    }

    .stat-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
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
      background: linear-gradient(135deg, var(--hospital-teal), #19b5fe);
    }

    .bg-rooms {
      background: linear-gradient(135deg, var(--hospital-green), #34d399);
    }

    .bg-visits {
      background: linear-gradient(135deg, var(--hospital-purple), #8e44ad);
    }

    .chart-container {
      background-color: white;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
      padding: 20px;
      margin-bottom: 20px;
      height: 400px;
      position: relative;
    }

    .chart-title {
      color: #2c3e50;
      font-weight: 600;
      margin-bottom: 20px;
      padding-bottom: 12px;
      border-bottom: 2px solid #f8f9fa;
      display: flex;
      align-items: center;
    }

    .chart-title i {
      background: linear-gradient(135deg, var(--hospital-blue), #0a58ca);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      margin-right: 10px;
      font-size: 1.2rem;
    }

    .dashboard-header {
      background: linear-gradient(135deg, var(--hospital-blue), #0a58ca);
      color: white;
      padding: 25px 0;
      margin-bottom: 30px;
    }

    footer {
      background: linear-gradient(135deg, var(--hospital-blue), #0a58ca);
      margin-top: 30px;
    }

    .row-equal {
      display: flex;
      flex-wrap: wrap;
    }

    .row-equal>[class*='col-'] {
      display: flex;
      flex-direction: column;
    }

    /* Custom scrollbar for charts with many items */
    .chart-scroll-container {
      overflow-x: auto;
      padding-bottom: 10px;
    }

    .chart-scroll-container::-webkit-scrollbar {
      height: 8px;
    }

    .chart-scroll-container::-webkit-scrollbar-track {
      background: #f1f1f1;
      border-radius: 10px;
    }

    .chart-scroll-container::-webkit-scrollbar-thumb {
      background: #c5c5c5;
      border-radius: 10px;
    }

    .chart-scroll-container::-webkit-scrollbar-thumb:hover {
      background: #a8a8a8;
    }

    /* Animation for chart loading */
    @keyframes chartFadeIn {
      from {
        opacity: 0;
        transform: translateY(10px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .chart-container canvas {
      animation: chartFadeIn 0.8s ease-out;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
      .chart-container {
        height: 350px;
      }

      .chart-title {
        font-size: 1.1rem;
      }
    }

    @media (max-width: 576px) {
      .chart-container {
        height: 300px;
        padding: 15px;
      }

      .chart-title {
        font-size: 1rem;
      }
    }
  </style>
</head>

<body>
  @unless (Auth::check() && Auth::user()->role == 'operator')
    <div class="alert alert-danger text-center" role="alert">
      Anda tidak memiliki akses ke halaman ini. Silakan <a href="{{ route('home') }}">kembali ke halaman utama</a>.
    </div>
    @php
  return;
    @endphp
  @endunless

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
          <li class="nav-item"><a class="nav-link text-white" href="{{ route('dashboard') }}">Home</a></li>
          @if (Auth::check())
            @if (Auth::user()->role != 'user')
              <li class="nav-item"><a class="nav-link text-white" href="{{ route('doctors.index') }}">Dokter</a></li>
              <li class="nav-item"><a class="nav-link text-white" href="{{ route('patients.index') }}">Pasien</a></li>
              <li class="nav-item"><a class="nav-link text-white" href="{{ route('rooms.index') }}">Ruangan</a></li>
              <li class="nav-item"><a class="nav-link text-white" href="{{ route('visits.index') }}">Kunjungan</a></li>
            @endif
          @endif
          @auth
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button"
                  data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="fas fa-user me-2"></i>{{ Auth::user()->name ?? 'user ini' }}
                  <span class="fw-light text-lowercase"
                    style="font-size: 0.8rem">({{ Auth::user()->role ?? 'user ini' }})</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
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

  <!-- Dashboard Header -->
  <div class="dashboard-header bg-light py-5">
    <div class="container">
      <h1 class="display-5 fw-bold"><i class="fas fa-tachometer-alt me-2"></i>Dashboard Rumah Sakit Laravel</h1>
      <p class="lead">Selamat datang di halaman dashboard Rumah Sakit Laravel, {{ Auth::user()->name ?? 'user ini' }}.
        Berikut adalah ringkasan data rumah sakit yang terdiri dari jumlah dokter, pasien, kamar, dan kunjungan. Silakan
        klik pada menu yang tersedia untuk melihat lebih detail.</p>
    </div>
  </div>

  <!-- Stats Section -->
  <section class="container mb-5">
    <div class="row row-equal">
      <div class="col-md-3 col-sm-6 mb-4">
        <div class="stat-card bg-doctors p-4 text-center shadow-sm" style="cursor: pointer;"
          onclick="location.href='{{ route('doctors.index') }}'">
          <i class="fas fa-user-md fs-1 mb-3 opacity-75"></i>
          <h4>Total Dokter</h4>
          <h2 class="fw-bold">{{ $totalDoctors }}</h2>
        </div>
      </div>
      <div class="col-md-3 col-sm-6 mb-4">
        <div class="stat-card bg-patients p-4 text-center shadow-sm" style="cursor: pointer;"
          onclick="location.href='{{ route('patients.index') }}'">
          <i class="fas fa-procedures fs-1 mb-3 opacity-75"></i>
          <h4>Total Pasien</h4>
          <h2 class="fw-bold">{{ $totalPatients }}</h2>
        </div>
      </div>
      <div class="col-md-3 col-sm-6 mb-4">
        <div class="stat-card bg-rooms p-4 text-center shadow-sm" style="cursor: pointer;"
          onclick="location.href='{{ route('rooms.index') }}'">
          <i class="fas fa-bed fs-1 mb-3 opacity-75"></i>
          <h4>Total Kamar</h4>
          <h2 class="fw-bold">{{ $totalRooms }}</h2>
        </div>
      </div>
      <div class="col-md-3 col-sm-6 mb-4">
        <div class="stat-card bg-visits p-4 text-center shadow-sm" style="cursor: pointer;"
          onclick="location.href='{{ route('visits.index') }}'">
          <i class="fas fa-notes-medical fs-1 mb-3 opacity-75"></i>
          <h4>Total Kunjungan</h4>
          <h2 class="fw-bold">{{ $totalVisits }}</h2>
        </div>
      </div>
    </div>

    <div class="row row-equal mt-4">
      <!-- Pie Chart - Patients by Room -->
      <div class="col-md-6 mb-4">
        <div class="chart-container">
          <h3 class="chart-title"><i class="fas fa-chart-pie"></i>Distribusi Pasien Berdasarkan Kamar</h3>
          <div class="chart-scroll-container">
            <canvas id="roomChart"></canvas>
          </div>
        </div>
      </div>

      <!-- Bar Chart - Patients by Disease -->
      <div class="col-md-6 mb-4">
        <div class="chart-container">
          <h3 class="chart-title"><i class="fas fa-chart-bar"></i>Jumlah Pasien Berdasarkan Penyakit</h3>
          <div class="chart-scroll-container">
            <canvas id="diseaseChart"></canvas>
          </div>
        </div>
      </div>

      <!-- Line Chart - Patients by Gender -->
      <div class="col-md-12 mb-4">
        <div class="chart-container">
          <h3 class="chart-title"><i class="fas fa-chart-line"></i>Distribusi Pasien Berdasarkan Jenis Kelamin</h3>
          <div class="chart-scroll-container">
            <canvas id="genderChart"></canvas>
          </div>
        </div>
      </div>
    </div>
  </section>

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
    document.addEventListener('DOMContentLoaded', function () {
      const roomCtx = document.getElementById('roomChart').getContext('2d');
      const roomChart = new Chart(roomCtx, {
        type: 'pie',
        data: {
          labels: {!! json_encode($patientsByRoom->pluck('room_name')) !!},
          datasets: [{
            data: {!! json_encode($patientsByRoom->pluck('count')) !!},
            backgroundColor: [
              '#1a77f2', '#2ecc71', '#17a2b8', '#9b59b6', '#f1c40f',
              '#e74c3c', '#34495e', '#95a5a6', '#d35400', '#16a085',
              '#8e44ad', '#27ae60', '#f39c12', '#d35400', '#7f8c8d'
            ],
            borderWidth: 2,
            borderColor: '#fff',
            hoverOffset: 15
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              position: 'right',
              labels: {
                boxWidth: 15,
                padding: 15,
                usePointStyle: true,
                pointStyle: 'circle'
              }
            },
            tooltip: {
              callbacks: {
                label: function (context) {
                  const label = context.label || '';
                  const value = context.raw || 0;
                  const total = context.dataset.data.reduce((a, b) => a + b, 0);
                  const percentage = Math.round((value / total) * 100);
                  return `${label}: ${value} (${percentage}%)`;
                }
              }
            }
          },
          animation: {
            animateScale: true,
            animateRotate: true
          }
        }
      });

      const diseaseCtx = document.getElementById('diseaseChart').getContext('2d');

      const gradient = diseaseCtx.createLinearGradient(0, 0, 0, 400);
      gradient.addColorStop(0, 'rgba(26, 119, 242, 0.8)');
      gradient.addColorStop(1, 'rgba(26, 119, 242, 0.2)');

      const diseaseChart = new Chart(diseaseCtx, {
        type: 'bar',
        data: {
          labels: {!! json_encode($patientsByDisease->pluck('disease_name')) !!},
          datasets: [{
            label: 'Jumlah Pasien',
            data: {!! json_encode($patientsByDisease->pluck('count')) !!},
            backgroundColor: gradient,
            borderColor: '#1a77f2',
            borderWidth: 1,
            borderRadius: 6,
            hoverBackgroundColor: '#0a58ca'
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          scales: {
            y: {
              beginAtZero: true,
              grid: {
                drawBorder: false
              },
              title: {
                display: true,
                text: 'Jumlah Pasien',
                font: {
                  weight: 'bold'
                }
              }
            },
            x: {
              grid: {
                display: false
              },
              title: {
                display: true,
                text: 'Jenis Penyakit',
                font: {
                  weight: 'bold'
                }
              },
              ticks: {
                maxRotation: 45,
                minRotation: 45
              }
            }
          },
          plugins: {
            legend: {
              display: false
            }
          }
        }
      });

      const genderCtx = document.getElementById('genderChart').getContext('2d');

      const genderData = {!! json_encode($patientsByGender) !!};
      const dates = Object.keys(genderData);

      const maleCounts = dates.map(date => {
        return genderData[date]['Laki-laki'] || 0;
      });

      const femaleCounts = dates.map(date => {
        return genderData[date]['Perempuan'] || 0;
      });

      const maleGradient = genderCtx.createLinearGradient(0, 0, 0, 400);
      maleGradient.addColorStop(0, 'rgba(26, 119, 242, 0.4)');
      maleGradient.addColorStop(1, 'rgba(26, 119, 242, 0.05)');

      const femaleGradient = genderCtx.createLinearGradient(0, 0, 0, 400);
      femaleGradient.addColorStop(0, 'rgba(231, 76, 60, 0.4)');
      femaleGradient.addColorStop(1, 'rgba(231, 76, 60, 0.05)');

      const genderChart = new Chart(genderCtx, {
        type: 'line',
        data: {
          labels: dates,
          datasets: [
            {
              label: 'Laki-laki',
              data: maleCounts,
              borderColor: '#1a77f2',
              backgroundColor: maleGradient,
              fill: true,
              tension: 0.4,
              pointBackgroundColor: '#1a77f2',
              pointBorderColor: '#fff',
              pointBorderWidth: 2,
              pointRadius: 5,
              pointHoverRadius: 7
            },
            {
              label: 'Perempuan',
              data: femaleCounts,
              borderColor: '#e74c3c',
              backgroundColor: femaleGradient,
              fill: true,
              tension: 0.4,
              pointBackgroundColor: '#e74c3c',
              pointBorderColor: '#fff',
              pointBorderWidth: 2,
              pointRadius: 5,
              pointHoverRadius: 7
            }
          ]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          scales: {
            y: {
              beginAtZero: true,
              grid: {
                drawBorder: false
              },
              title: {
                display: true,
                text: 'Jumlah Pasien',
                font: {
                  weight: 'bold'
                }
              }
            },
            x: {
              grid: {
                display: false
              },
              title: {
                display: true,
                text: 'Tanggal',
                font: {
                  weight: 'bold'
                }
              }
            }
          },
          plugins: {
            legend: {
              position: 'top',
              labels: {
                boxWidth: 15,
                usePointStyle: true,
                padding: 20
              }
            }
          }
        }
      });

      window.addEventListener('resize', function () {
        roomChart.resize();
        diseaseChart.resize();
        genderChart.resize();
      });
    });
  </script>
</body>

</html>
