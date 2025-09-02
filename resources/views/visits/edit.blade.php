@extends('template')

@section('content')
  <div class="container mt-4">
    <div class="row justify-content-center">
      <div class="col-md-10">
        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
          <div>
            <h2 class="fw-bold text-purple mb-1" style="color: #9b59b6;">
              <i class="bi bi-pencil-square me-2"></i>Kelola Kunjungan
            </h2>
            <p class="text-muted">Kelola kunjungan pasien dan tentukan dokter penanggung jawab</p>
          </div>
          <a href="{{ route('visits.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Kembali
          </a>
        </div>

        {{-- Card Form --}}
        <div class="card shadow-sm border-0">
          <div class="card-header text-white py-3" style="background-color: #9b59b6;">
            <h5 class="card-title mb-0">
              <i class="bi bi-calendar-check me-2"></i>Formulir Kelola Kunjungan
            </h5>
          </div>
          <div class="card-body p-4">
            <form action="{{ route('visits.update', $visit->id) }}" method="POST">
              @csrf
              @method('PUT')

              {{-- Informasi Pasien --}}
              <div class="mb-4">
                <h5 class="border-bottom pb-2 mb-3" style="color: #9b59b6;">
                  <i class="bi bi-person me-2"></i>Informasi Pasien
                </h5>

                <input type="hidden" name="visit_id" value="{{ $visit->id }}">

                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Pasien</label>
                    <input type="text" class="form-control" value="{{ $visit->patient->user->name ?? '-' }}" readonly>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label class="form-label">No. Rekam Medis</label>
                    <input type="text" class="form-control" value="{{ $visit->patient->medical_record_number ?? '-' }}"
                      readonly>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label class="form-label">Tanggal Permintaan</label>
                    <input type="text" class="form-control"
                      value="{{ $visit->requested_date ? \Carbon\Carbon::parse($visit->requested_date)->format('d/m/Y') : '-' }}"
                      readonly>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label class="form-label">Waktu Permintaan</label>
                    <input type="text" class="form-control"
                      value="{{ $visit->requested_time ? \Carbon\Carbon::parse($visit->requested_time)->format('H:i') : '-' }}"
                      readonly>
                  </div>
                  <div class="col-md-12 mb-3">
                    <label class="form-label">Keluhan</label>
                    <textarea class="form-control" rows="2" readonly>{{ $visit->complaint }}</textarea>
                  </div>
                </div>
              </div>

              {{-- Kelola Kunjungan --}}
              <div class="mb-4">
                <h5 class="border-bottom pb-2 mb-3" style="color: #9b59b6;">
                  <i class="bi bi-gear me-2"></i>Kelola Kunjungan
                </h5>
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label for="doctor_id" class="form-label">Dokter Penanggung Jawab <span
                        class="text-danger">*</span></label>
                    <select class="form-select @error('doctor_id') is-invalid @enderror" id="doctor_id" name="doctor_id"
                      required>
                      <option value="">Pilih Dokter</option>
                      @foreach($doctors as $doctor)
                        <option value="{{ $doctor->id }}" {{ (old('doctor_id', $visit->doctor_id) == $doctor->id) ? 'selected' : '' }}>
                          {{ $doctor->user->name }} - {{ $doctor->specialization }}
                        </option>
                      @endforeach
                    </select>
                    @error('doctor_id')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="status" class="form-label">Status Kunjungan <span class="text-danger">*</span></label>
                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                      <option value="pending" {{ old('status', $visit->status) == 'pending' ? 'selected' : '' }}>Menunggu
                      </option>
                      <option value="approved" {{ old('status', $visit->status) == 'approved' ? 'selected' : '' }}>Disetujui
                      </option>
                      <option value="completed" {{ old('status', $visit->status) == 'completed' ? 'selected' : '' }}>Selesai
                      </option>
                      <option value="cancelled" {{ old('status', $visit->status) == 'cancelled' ? 'selected' : '' }}>
                        Dibatalkan</option>
                    </select>
                    @error('status')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="col-md-12 mb-3" id="cancellation_reason_field"
                    style="{{ (old('status', $visit->status) == 'cancelled') ? '' : 'display: none;' }}">
                    <label for="cancellation_reason" class="form-label">Alasan Pembatalan <span
                        class="text-danger">*</span></label>
                    <textarea class="form-control @error('cancellation_reason') is-invalid @enderror"
                      id="cancellation_reason" name="cancellation_reason" rows="2"
                      placeholder="Masukkan alasan pembatalan">{{ old('cancellation_reason', $visit->cancellation_reason) }}</textarea>
                    @error('cancellation_reason')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
              </div>

              <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="{{ route('visits.index') }}" class="btn btn-outline-secondary me-md-2">
                  <i class="bi bi-x-circle me-1"></i> Batal
                </a>
                <button type="submit" class="btn text-white" style="background-color: #9b59b6;">
                  <i class="bi bi-save me-1"></i> Simpan Perubahan
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const statusSelect = document.getElementById('status');
      const cancellationReasonField = document.getElementById('cancellation_reason_field');

      function toggleCancellationReason() {
        if (statusSelect.value === 'cancelled') {
          cancellationReasonField.style.display = 'block';
          document.getElementById('cancellation_reason').setAttribute('required', 'required');
        } else {
          cancellationReasonField.style.display = 'none';
          document.getElementById('cancellation_reason').removeAttribute('required');
        }
      }

      statusSelect.addEventListener('change', toggleCancellationReason);
      toggleCancellationReason(); // Initial check
    });
  </script>

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