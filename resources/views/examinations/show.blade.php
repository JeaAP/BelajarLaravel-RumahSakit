@extends('template')

@section('content')
  <div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2 class="mb-0"><i class="bi bi-file-medical me-2"></i>Detail Pemeriksaan</h2>
      <div>
        @if(Auth::user()->role == 'user')
          <a href="{{ route('home') }}" class="btn btn-outline-secondary me-2">
            <i class="bi bi-arrow-left me-1"></i>Kembali
          </a>
        @elseif(Auth::user()->role != 'user')
          <a href="{{ route('examinations.index') }}" class="btn btn-outline-secondary me-2">
            <i class="bi bi-arrow-left me-1"></i>Kembali
          </a>
          <a href="{{ route('examinations.edit', $examination) }}" class="btn btn-primary">
            <i class="bi bi-pencil me-1"></i>Edit
          </a>
        @endif
      </div>
    </div>

    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ session('success') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    @if(session('error'))
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>{{ session('error') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    <div class="card shadow-sm mb-4">
      <div class="card-header bg-primary text-white">
        <h5 class="card-title mb-0"><i class="bi bi-person me-2"></i>Data Pasien</h5>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-6">
            <div class="mb-3">
              <strong>Nama Pasien</strong>
              <p class="mb-0">{{ $visits->patient->user->name ?? 'Nama tidak tersedia' }}</p>
            </div>
            <div class="mb-3">
              <strong>Keluhan Awal</strong>
              <p class="mb-0">{{ $visits->complaint }}</p>
            </div>
            <div class="mb-3">
              <strong>Tanggal Kunjungan</strong>
              <p class="mb-0">{{ \Carbon\Carbon::parse($visits->requested_date)->format('d M Y') }}</p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <strong>Waktu Kunjungan</strong>
              <p class="mb-0">{{ \Carbon\Carbon::parse($visits->requested_time)->format('H:i') }}</p>
            </div>
            <div class="mb-3">
              <strong>Dokter Pemeriksa</strong>
              <p class="mb-0">{{ $examination->doctor->user->name }} - {{ $examination->doctor->specialization }}</p>
            </div>
            <div class="mb-3">
              <strong>Tanggal Pemeriksaan</strong>
              <p class="mb-0">{{ $examination->created_at->format('d M Y H:i') }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="card shadow-sm mb-4">
      <div class="card-header bg-primary text-white">
        <h5 class="card-title mb-0"><i class="bi bi-clipboard2-pulse me-2"></i>Diagnosis & Pengobatan</h5>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-6">
            <div class="mb-3">
              <strong>Nama Penyakit</strong>
              <p class="mb-0">{{ $diseaseRecord->disease_name ?? 'Tidak tersedia' }}</p>
            </div>
            <div class="mb-3">
              <strong>Gejala</strong>
              <p class="mb-0">{{ $diseaseRecord->symptoms ?? 'Tidak tersedia' }}</p>
            </div>
            <div class="mb-3">
              <strong>Diagnosis</strong>
              <p class="mb-0">{{ $examination->diagnosis }}</p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <strong>Rencana Pengobatan</strong>
              <p class="mb-0">{{ $examination->treatment_plan }}</p>
            </div>
            <div class="mb-3">
              <strong>Obat yang Diberikan</strong>
              <p class="mb-0">{{ $examination->medications ?? 'Tidak ada' }}</p>
            </div>
            <div class="mb-3">
              <strong>Dosis & Aturan Pakai</strong>
              <p class="mb-0">{{ $examination->dosage ?? 'Tidak tersedia' }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="card shadow-sm mb-4">
      <div class="card-header bg-primary text-white">
        <h5 class="card-title mb-0"><i class="bi bi-heart-pulse me-2"></i>Status Perawatan</h5>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-6">
            <div class="mb-3">
              <strong>Status Pasien</strong>
              <p class="mb-0">
                @php
                  $statusClass = 'badge bg-info';
                  if ($examination->patient_status === 'recovered') {
                    $statusClass = 'badge bg-success';
                  } elseif ($examination->patient_status === 'referred') {
                    $statusClass = 'badge bg-warning';
                  }
                @endphp
                <span class="{{ $statusClass }}">
                  @if($examination->patient_status === 'under_treatment')
                    Dalam Perawatan
                  @elseif($examination->patient_status === 'recovered')
                    Sembuh
                  @else
                    Dirujuk
                  @endif
                </span>
              </p>
            </div>
            <div class="mb-3">
              <strong>Status Penyakit</strong>
              <p class="mb-0">
                @php
                  $diseaseStatus = $diseaseRecord->status ?? 'Tidak tersedia';
                  $diseaseStatusText = 'Tidak tersedia';

                  if ($diseaseStatus === 'active')
                    $diseaseStatusText = 'Aktif';
                  elseif ($diseaseStatus === 'treated')
                    $diseaseStatusText = 'Sedang Diobati';
                  elseif ($diseaseStatus === 'chronic')
                    $diseaseStatusText = 'Kronis';
                  elseif ($diseaseStatus === 'cured')
                    $diseaseStatusText = 'Sembuh';
                @endphp
                {{ $diseaseStatusText }}
              </p>
            </div>
          </div>
          <div class="col-md-6">
            @if($examination->needs_hospitalization)
              <div class="mb-3">
                <strong>Rawat Inap</strong>
                <p class="mb-0">Ya</p>
              </div>
              @if($examination->room)
                <div class="mb-3">
                  <strong>Ruangan</strong>
                  <p class="mb-0">{{ $examination->room->room_name }} ({{ $examination->room->room_id }})</p>
                </div>
              @endif
              @if($examination->admission_date)
                <div class="mb-3">
                  <strong>Tanggal Masuk</strong>
                  <p class="mb-0">{{ \Carbon\Carbon::parse($examination->admission_date)->format('d M Y') }}</p>
                </div>
              @endif
              @if($examination->discharge_date)
                <div class="mb-3">
                  <strong>Tanggal Keluar</strong>
                  <p class="mb-0">{{ \Carbon\Carbon::parse($examination->discharge_date)->format('d M Y') }}</p>
                </div>
              @endif
            @else
              <div class="mb-3">
                <strong>Rawat Inap</strong>
                <p class="mb-0">Tidak</p>
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>

    @if($examination->notes)
      <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
          <h5 class="card-title mb-0"><i class="bi bi-sticky me-2"></i>Catatan Tambahan</h5>
        </div>
        <div class="card-body">
          <p class="mb-0">{{ $examination->notes }}</p>
        </div>
      </div>
    @endif
  </div>
@endsection