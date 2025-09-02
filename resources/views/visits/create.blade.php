@extends('template')

@section('content')
  <div class="container mt-4">
    <div class="row justify-content-center">
      <div class="col-md-10">
        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
          <div>
            <h2 class="fw-bold text-purple mb-1" style="color: #9b59b6;">
              <i class="bi bi-plus-circle me-2"></i>Kunjungan Baru
            </h2>
            <p class="text-muted">Isi formulir berikut untuk membuat kunjungan baru</p>
          </div>
          <a href="{{ route('visits.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Kembali
          </a>
        </div>

        {{-- Card Form --}}
        <div class="card shadow-sm border-0">
          <div class="card-header text-white py-3" style="background-color: #9b59b6;">
            <h5 class="card-title mb-0">
              <i class="bi bi-calendar-check me-2"></i>Formulir Data Kunjungan
            </h5>
          </div>
          <div class="card-body p-4">
            <form action="{{ route('visits.store') }}" method="POST">
              @csrf

              {{-- Informasi Kunjungan --}}
              <div class="mb-4">
                <h5 class="border-bottom pb-2 mb-3" style="color: #9b59b6;">
                  <i class="bi bi-info-circle me-2"></i>Informasi Kunjungan
                </h5>
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label for="patient_id" class="form-label">Pasien <span class="text-danger">*</span></label>
                    <select class="form-select @error('patient_id') is-invalid @enderror" id="patient_id"
                      name="patient_id" required>
                      <option value="" disabled selected>Pilih Pasien</option>
                      @foreach ($patients as $patient)
                        <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                          {{ $patient->user->name }} - {{ $patient->medical_record_number }}
                        </option>
                      @endforeach
                    </select>
                    @error('patient_id')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="col-md-12 mb-3">
                    <label for="complaint" class="form-label">Keluhan <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('complaint') is-invalid @enderror" id="complaint"
                      name="complaint" rows="3" required
                      placeholder="Jelaskan keluhan pasien">{{ old('complaint') }}</textarea>
                    @error('complaint')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="col-md-12 mb-3">
                    <label for="treatment_request" class="form-label">Permintaan Perawatan <span
                        class="text-danger">*</span></label>
                    <textarea class="form-control @error('treatment_request') is-invalid @enderror" id="treatment_request"
                      name="treatment_request" rows="3" required
                      placeholder="Jelaskan permintaan perawatan">{{ old('treatment_request') }}</textarea>
                    @error('treatment_request')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="requested_date" class="form-label">Tanggal Permintaan <span
                        class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('requested_date') is-invalid @enderror"
                      id="requested_date" name="requested_date" value="{{ old('requested_date') }}" required>
                    @error('requested_date')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="requested_time" class="form-label">Waktu Permintaan <span
                        class="text-danger">*</span></label>
                    <input type="time" class="form-control @error('requested_time') is-invalid @enderror"
                      id="requested_time" name="requested_time" value="{{ old('requested_time') }}" required>
                    @error('requested_time')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
              </div>

              <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="reset" class="btn btn-outline-secondary me-md-2">
                  <i class="bi bi-arrow-clockwise me-1"></i> Reset
                </button>
                <button type="submit" class="btn text-white" style="background-color: #9b59b6;">
                  <i class="bi bi-save me-1"></i> Simpan Data
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <style>
    .form-label {
      font-weight: 500;
      margin-bottom: 0.5rem;
    }

    .card {
      border-radius: 0.5rem;
    }

    .card-header {
      border-radius: 0.5rem 0.5rem 0 0 !important;
    }

    .btn {
      border-radius: 0.375rem;
    }
  </style>
@endsection