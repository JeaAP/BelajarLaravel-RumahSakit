@extends('template')

@section('content')
  <div class="container mt-4">
    <div class="row justify-content-center">
      <div class="col-md-10">
        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
          <div>
            <h2 class="fw-bold text-success mb-1">
              <i class="bi bi-plus-circle me-2"></i>Tambah Ruangan Baru
            </h2>
            <p class="text-muted">Isi formulir berikut untuk menambahkan ruangan baru</p>
          </div>
          <a href="{{ route('rooms.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Kembali
          </a>
        </div>

        {{-- Card Form --}}
        <div class="card shadow-sm border-0">
          <div class="card-header bg-success text-white py-3">
            <h5 class="card-title mb-0">
              <i class="bi bi-building me-2"></i>Formulir Data Ruangan
            </h5>
          </div>
          <div class="card-body p-4">
            <form action="{{ route('rooms.store') }}" method="POST">
              @csrf

              {{-- Informasi Ruangan --}}
              <div class="mb-4">
                <h5 class="border-bottom pb-2 text-success mb-3">
                  <i class="bi bi-info-circle me-2"></i>Informasi Ruangan
                </h5>
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label for="room_id" class="form-label">ID Ruangan <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('room_id') is-invalid @enderror" id="room_id"
                      name="room_id" value="{{ old('room_id') }}" required placeholder="Contoh: R001">
                    @error('room_id')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="room_name" class="form-label">Nama Ruangan <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('room_name') is-invalid @enderror" id="room_name"
                      name="room_name" value="{{ old('room_name') }}" required placeholder="Contoh: Ruang Operasi 1">
                    @error('room_name')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="capacity" class="form-label">Kapasitas <span class="text-danger">*</span></label>
                    <input type="number" class="form-control @error('capacity') is-invalid @enderror" id="capacity"
                      name="capacity" value="{{ old('capacity') }}" required min="1" placeholder="Contoh: 4">
                    @error('capacity')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="location" class="form-label">Lokasi <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('location') is-invalid @enderror" id="location"
                      name="location" value="{{ old('location') }}" required placeholder="Contoh: Lantai 2, Gedung A">
                    @error('location')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                      <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Tersedia</option>
                      <option value="occupied" {{ old('status') == 'occupied' ? 'selected' : '' }}>Terisi</option>
                      <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>Pemeliharaan
                      </option>
                    </select>
                    @error('status')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
              </div>

              <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="reset" class="btn btn-outline-secondary me-md-2">
                  <i class="bi bi-arrow-clockwise me-1"></i> Reset
                </button>
                <button type="submit" class="btn btn-success">
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