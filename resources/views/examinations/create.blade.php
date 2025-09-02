@extends('template')

@section('content')

  <div>
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

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow">
      <div class="container">
        <a class="navbar-brand fw-bold" href="#">
          <i class="fas fa-hospital me-2"></i>Rumah Sakit Laravel
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item"><a class="nav-link" href="{{ route('doctor') }}">Home</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Jadwal</a></li>
            <li class="nav-item"><a class="nav-link active" href="#">Pasien</a></li>
            @auth
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                  aria-expanded="false">
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
              <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
            @endauth
          </ul>
        </div>
      </div>
    </nav>

    <!-- Dashboard Header -->
    <div class="bg-primary text-white py-4 mb-4">
      <div class="container">
        <h1 class="display-5 fw-bold"><i class="fas fa-stethoscope me-2"></i>Form Pemeriksaan Pasien</h1>
        <p class="lead mb-0">Isi form berikut untuk mencatat hasil pemeriksaan pasien.</p>
      </div>
    </div>

    <!-- Main Content -->
    <div class="container mb-5">
      <div class="card shadow">
        <div class="card-body p-4">
          <h3 class="card-title mb-4 text-primary"><i class="fas fa-user-injured me-2"></i>Data Pasien</h3>

          <div class="row mb-4">
            <div class="col-md-6">
              <p><strong>Nama Pasien:</strong> {{ $visit->patient->user->name ?? 'Nama tidak tersedia' }}</p>
              <p><strong>Keluhan:</strong> {{ $visit->complaint }}</p>
            </div>
            <div class="col-md-6">
              <p><strong>Tanggal Kunjungan:</strong> {{ \Carbon\Carbon::parse($visit->requested_date)->format('d M Y') }}
              </p>
              <p><strong>Waktu Kunjungan:</strong> {{ \Carbon\Carbon::parse($visit->requested_time)->format('H:i') }}</p>
            </div>
          </div>

          <form action="{{ route('examinations.store', $visit) }}" method="POST">
            @csrf

            <h3 class="card-title mb-4 text-primary"><i class="fas fa-diagnoses me-2"></i>Diagnosis & Pengobatan</h3>

            <div class="mb-3">
              <label for="doctor_id" class="form-label">Dokter Pemeriksa *</label>
              <input type="hidden" id="doctor_id" name="doctor_id" value="{{ $visit->doctor->id }}" required>
              <input type="text" class="form-control" value="{{ $visit->doctor->user->name }} - {{ $visit->doctor->specialization }}" required readonly>
            </div>

            <div class="row mb-3">
              <div class="col-md-6">
                <label for="disease_name" class="form-label">Nama Penyakit *</label>
                <input type="text" class="form-control" id="disease_name" name="disease_name" required>
              </div>
              <div class="col-md-6">
                <label for="diagnosis_date" class="form-label">Tanggal Diagnosis *</label>
                <input type="date" class="form-control" id="diagnosis_date" name="diagnosis_date"
                  value="{{ date('Y-m-d') }}" required>
              </div>
            </div>

            <div class="mb-3">
              <label for="symptoms" class="form-label">Gejala yang Dikeluhkan</label>
              <textarea class="form-control" id="symptoms" name="symptoms" rows="2"></textarea>
            </div>

            <div class="mb-3">
              <label for="diagnosis" class="form-label">Diagnosis *</label>
              <textarea class="form-control" id="diagnosis" name="diagnosis" rows="2" required></textarea>
            </div>

            <div class="mb-3">
              <label for="treatment_plan" class="form-label">Rencana Pengobatan *</label>
              <textarea class="form-control" id="treatment_plan" name="treatment_plan" rows="2" required></textarea>
            </div>

            <div class="row mb-3">
              <div class="col-md-6">
                <label for="medications" class="form-label">Obat yang Diberikan</label>
                <textarea class="form-control" id="medications" name="medications" rows="2"></textarea>
              </div>
              <div class="col-md-6">
                <label for="dosage" class="form-label">Dosis & Aturan Pakai</label>
                <textarea class="form-control" id="dosage" name="dosage" rows="2"></textarea>
              </div>
            </div>

            <h3 class="card-title mt-4 mb-4 text-primary"><i class="fas fa-procedures me-2"></i>Status Perawatan</h3>

            <div class="row mb-3">
              <div class="col-md-6">
                <label for="patient_status" class="form-label">Status Pasien *</label>
                <select class="form-select" id="patient_status" name="patient_status" required>
                  <option value="under_treatment">Dalam Perawatan</option>
                  <option value="recovered">Sembuh</option>
                  <option value="referred">Dirujuk</option>
                </select>
              </div>
              <div class="col-md-6">
                <label for="disease_status" class="form-label">Status Penyakit *</label>
                <select class="form-select" id="disease_status" name="disease_status" required>
                  <option value="active">Aktif</option>
                  <option value="treated">Sedang Diobati</option>
                  <option value="chronic">Kronis</option>
                  <option value="cured">Sembuh</option>
                </select>
              </div>
            </div>

            <div class="mb-3">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="needs_hospitalization" name="needs_hospitalization"
                  value="1">
                <label class="form-check-label" for="needs_hospitalization">
                  Pasien perlu dirawat inap
                </label>
              </div>
            </div>

            <div id="hospitalizationFields" class="bg-light p-3 rounded mb-3" style="display: none;">
              <div class="row mb-3">
                <div class="col-md-6">
                  <label for="room_id" class="form-label">Ruangan Rawat Inap *</label>
                  <select class="form-select" id="room_id" name="room_id">
                    <option value="">Pilih Ruangan</option>
                    @foreach($rooms as $room)
                      <option value="{{ $room->id }}"
                        {{ $room->capacity <= $room->examinations_count ? 'disabled' : '' }}
                        {{ $room->capacity <= $room->examinations_count ? 'title=PENUH' : '' }}
                      >{{ $room->room_id }} - {{ $room->room_name }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-6">
                  <label for="admission_date" class="form-label">Tanggal Masuk Rawat Inap *</label>
                  <input type="date" class="form-control" id="admission_date" name="admission_date"
                    value="{{ date('Y-m-d') }}">
                </div>
              </div>

              <div class="mb-3">
                <label for="discharge_date" class="form-label">Tanggal Keluar Rawat Inap (jika sudah)</label>
                <input type="date" class="form-control" id="discharge_date" name="discharge_date">
              </div>
            </div>

            <div class="mb-3">
              <label for="notes" class="form-label">Catatan Tambahan</label>
              <textarea class="form-control" id="notes" name="notes" rows="2"></textarea>
            </div>

            <h3 class="card-title mt-4 mb-4 text-primary"><i class="fas fa-tasks me-2"></i>Tindakan</h3>

            <div class="mb-3">
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="action" id="actionComplete" value="complete" checked>
                <label class="form-check-label" for="actionComplete">Selesaikan Pemeriksaan</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="action" id="actionCancel" value="cancel">
                <label class="form-check-label" for="actionCancel">Batalkan Kunjungan</label>
              </div>
            </div>

            <div id="cancellationReason" class="bg-light p-3 rounded mb-3" style="display: none;">
              <div class="mb-3">
                <label for="cancellation_reason" class="form-label">Alasan Pembatalan *</label>
                <textarea class="form-control" id="cancellation_reason" name="cancellation_reason" rows="2"></textarea>
              </div>
            </div>

            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
              <a href="{{ url()->previous() }}" class="btn btn-secondary me-md-2">Kembali</a>
              <button type="submit" class="btn btn-primary">Simpan Hasil Pemeriksaan</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Footer -->
    <footer class="bg-primary text-white py-4 mt-5">
      <div class="container">
        <div class="text-center">
          <p class="mb-0">&copy; 2023 Rumah Sakit Laravel. All rights reserved.</p>
        </div>
      </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
      // Toggle hospitalization fields
      document.getElementById('needs_hospitalization').addEventListener('change', function () {
        const hospitalizationFields = document.getElementById('hospitalizationFields');
        hospitalizationFields.style.display = this.checked ? 'block' : 'none';

        if (this.checked) {
          document.getElementById('room_id').setAttribute('required', 'required');
          document.getElementById('admission_date').setAttribute('required', 'required');
        } else {
          document.getElementById('room_id').removeAttribute('required');
          document.getElementById('admission_date').removeAttribute('required');
        }
      });

      // Toggle cancellation reason
      document.querySelectorAll('input[name="action"]').forEach(radio => {
        radio.addEventListener('change', function () {
          const cancellationReason = document.getElementById('cancellationReason');
          cancellationReason.style.display = this.value === 'cancel' ? 'block' : 'none';

          if (this.value === 'cancel') {
            document.getElementById('cancellation_reason').setAttribute('required', 'required');
          } else {
            document.getElementById('cancellation_reason').removeAttribute('required');
          }
        });
      });
    </script>
  </div>

@endsection