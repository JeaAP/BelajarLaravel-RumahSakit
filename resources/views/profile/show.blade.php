@extends('template')

@section('content')
  <div class="container">
    <div class="row justify-content-center mt-4">
      <div class="col-md-10 col-lg-8">
        {{-- Kartu Profil Utama --}}
        <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
          <div class="card-body p-0">
            {{-- Header dengan background --}}
            <div class="bg-primary bg-opacity-10 py-4 px-5">
              <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                  {{-- Foto Profil --}}
                  <div class="me-4">
                    @if ($user->profile_picture)
                      <img src="{{ url('images/' . $user->profile_picture) }}" alt="profile picture"
                        class="rounded-circle border border-3 border-white shadow-sm" width="120" height="120"
                        style="object-fit: cover;">
                    @else
                      <div
                        class="rounded-circle border border-3 border-white bg-light d-flex align-items-center justify-content-center shadow-sm"
                        style="width: 120px; height: 120px;">
                        <i class="bi bi-person-circle text-primary fs-1"></i>
                      </div>
                    @endif
                  </div>

                  {{-- Informasi Dasar --}}
                  <div class="text-start">
                    <h3 class="mb-1 fw-bold text-dark">{{ $user->name }}</h3>
                    <p class="mb-1 text-muted">
                      <i class="fas fa-envelope me-2"></i>{{ $user->email }}
                    </p>
                    <span class="badge bg-primary rounded-pill text-capitalize px-3 py-2">
                      <i class="fas fa-user me-1"></i>
                      {{ $user->role == 'user' ? 'Pasien' : ucfirst($user->role) }}
                    </span>
                  </div>
                </div>

                <div>
                  <a href="{{ route('profile.edit', $patientDetails->id) }}" class="btn btn-outline-primary rounded-pill">
                    <i class="fas fa-edit me-2"></i>Edit Profil
                  </a>
                </div>
              </div>
            </div>

            {{-- Informasi Pasien --}}
            <div class="p-5">
              <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0 fw-bold text-primary">
                  <i class="fas fa-info-circle me-2"></i>Informasi Pasien
                </h4>
                <a href="{{ route('home') }}" class="btn btn-outline-secondary rounded-pill">
                  <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
              </div>

              @if ($patientDetails)
                <div class="row">
                  <div class="col-md-6">
                    <div class="card bg-light border-0 rounded-3 mb-4 shadow-sm">
                      <div class="card-body">
                        <h6 class="card-title text-primary fw-bold mb-3">
                          <i class="fas fa-user-circle me-2"></i>Data Pribadi
                        </h6>
                        <div class="d-flex mb-3">
                          <div class="text-muted col-5">
                            <i class="fas fa-birthday-cake me-2"></i>Tanggal Lahir:
                          </div>
                          <div class="col-7 fw-medium">
                            {{ $patientDetails->birth_date ? \Carbon\Carbon::parse($patientDetails->birth_date)->format('d-m-Y') : '-' }}
                          </div>
                        </div>
                        <div class="d-flex mb-3">
                          <div class="text-muted col-5">
                            <i class="fas fa-venus-mars me-2"></i>Jenis Kelamin:
                          </div>
                          <div class="col-7 fw-medium">
                            @if($patientDetails->gender)
                              {{ $patientDetails->gender == 'male' ? 'Laki-laki' : 'Perempuan' }}
                            @else
                              -
                            @endif
                          </div>
                        </div>
                        <div class="d-flex mb-3">
                          <div class="text-muted col-5">
                            <i class="fas fa-phone me-2"></i>No. Telepon:
                          </div>
                          <div class="col-7 fw-medium">
                            {{ $patientDetails->phone_number ?? '-' }}
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="card bg-light border-0 rounded-3 mb-4 shadow-sm">
                      <div class="card-body">
                        <h6 class="card-title text-primary fw-bold mb-3">
                          <i class="fas fa-address-card me-2"></i>Data Kontak
                        </h6>
                        <div class="d-flex mb-3">
                          <div class="text-muted col-5">
                            <i class="fas fa-home me-2"></i>Alamat:
                          </div>
                          <div class="col-7 fw-medium">
                            {{ $patientDetails->address ?? '-' }}
                          </div>
                        </div>
                        <div class="d-flex mb-3">
                          <div class="text-muted col-5">
                            <i class="fas fa-city me-2"></i>Kota:
                          </div>
                          <div class="col-7 fw-medium">
                            {{ $patientDetails->city ?? '-' }}
                          </div>
                        </div>
                        <div class="d-flex mb-3">
                          <div class="text-muted col-5">
                            <i class="fas fa-exclamation-circle me-2"></i>Kontak Darurat:
                          </div>
                          <div class="col-7 fw-medium">
                            {{ $patientDetails->emergency_contact ?? '-' }}
                          </div>
                        </div>
                        <div class="d-flex">
                          <div class="text-muted col-5">
                            <i class="fas fa-shield-alt me-2"></i>Asuransi:
                          </div>
                          <div class="col-7 fw-medium">
                            {{ $patientDetails->insurance_info ?? '-' }}
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                {{-- Medical Record --}}
                <div class="card bg-light border-0 rounded-3 shadow-sm">
                  <div class="card-body">
                    <h6 class="card-title text-primary fw-bold mb-3">
                      <i class="fas fa-file-medical me-2"></i>Rekam Medis
                    </h6>
                    <div class="d-flex">
                      <div class="text-muted col-3">
                        <i class="fas fa-id-card me-2"></i>No. Rekam Medis:
                      </div>
                      <div class="col-9 fw-medium">
                        {{ $patient->first()->medical_record_number ?? '-' }}
                      </div>
                    </div>
                  </div>
                </div>
              @else
                <div class="text-center py-4">
                  <i class="fas fa-info-circle fa-3x text-muted mb-3"></i>
                  <p class="text-muted">Belum ada detail pasien yang tersedia.</p>
                  <a href="{{ route('profile.edit', ['profile' => $patientDetails->id]) }}"
                    class="btn btn-primary rounded-pill mt-2">
                    <i class="fas fa-plus me-2"></i>Tambah Data Pasien
                  </a>
                </div>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('styles')
  <style>
    .card {
      transition: transform 0.3s ease;
    }

    .card:hover {
      transform: translateY(-5px);
    }

    .bg-primary.bg-opacity-10 {
      background-color: rgba(13, 110, 253, 0.1) !important;
    }

    .card.bg-light {
      background-color: #f8f9fa !important;
    }
  </style>
@endpush