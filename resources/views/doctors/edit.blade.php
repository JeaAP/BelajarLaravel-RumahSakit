@extends('template')

@section('content')
  <div class="container mt-4">
    <div class="row justify-content-center">
      <div class="col-md-10">
        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
          <div>
            <h2 class="fw-bold text-primary mb-1">
              <i class="bi bi-pencil-square me-2"></i>Edit Data Dokter
            </h2>
            <p class="text-muted">Perbarui informasi dokter berikut</p>
          </div>
          <a href="{{ route('doctors.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Kembali
          </a>
        </div>

        {{-- Card Form --}}
        <div class="card shadow-sm border-0">
          <div class="card-header bg-primary text-white py-3">
            <h5 class="card-title mb-0">
              <i class="bi bi-person-check me-2"></i>Formulir Edit Dokter
            </h5>
          </div>
          <div class="card-body p-4">
            <form action="{{ route('doctors.update', $doctor->id) }}" method="POST">
              @csrf
              @method('PUT')

              {{-- Informasi Akun --}}
              <div class="mb-4">
                <h5 class="border-bottom pb-2 text-primary mb-3">
                  <i class="bi bi-person-badge me-2"></i>Informasi Akun
                </h5>
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                      value="{{ old('name', $doctor->user->name) }}" required>
                    @error('name')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                      value="{{ old('email', $doctor->user->email) }}" required>
                    @error('email')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                      <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                        name="password" placeholder="Kosongkan jika tidak ingin mengubah">
                      <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                        <i class="bi bi-eye" id="togglePasswordIcon"></i>
                      </button>
                    </div>
                    @error('password')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text">Minimal 8 karakter</div>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                    <div class="input-group">
                      <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                        placeholder="Kosongkan jika tidak ingin mengubah">
                      <button type="button" class="btn btn-outline-secondary" id="toggleConfirmPassword">
                        <i class="bi bi-eye" id="toggleConfirmPasswordIcon"></i>
                      </button>
                    </div>
                  </div>
                </div>
              </div>

              {{-- Informasi Pribadi --}}
              <div class="mb-4">
                <h5 class="border-bottom pb-2 text-primary mb-3">
                  <i class="bi bi-info-circle me-2"></i>Informasi Pribadi
                </h5>
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label for="id_number" class="form-label">ID Dokter</label>
                    <input type="text" class="form-control @error('id_number') is-invalid @enderror" id="id_number"
                      name="id_number" value="{{ old('id_number', $doctor->id_number) }}">
                    @error('id_number')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="birth_date" class="form-label">Tanggal Lahir</label>
                    <input type="date" class="form-control @error('birth_date') is-invalid @enderror" id="birth_date"
                      name="birth_date"
                      value="{{ old('birth_date', $doctor->birth_date ? \Carbon\Carbon::parse($doctor->birth_date)->format('Y-m-d') : '') }}">
                    @error('birth_date')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="gender" class="form-label">Jenis Kelamin</label>
                    <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender">
                      <option value="">Pilih Jenis Kelamin</option>
                      <option value="male" {{ old('gender', $doctor->gender) == 'male' ? 'selected' : '' }}>Laki-laki
                      </option>
                      <option value="female" {{ old('gender', $doctor->gender) == 'female' ? 'selected' : '' }}>Perempuan
                      </option>
                    </select>
                    @error('gender')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="phone_number" class="form-label">Nomor Telepon</label>
                    <input type="tel" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number"
                      name="phone_number" value="{{ old('phone_number', $doctor->phone_number) }}">
                    @error('phone_number')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
              </div>

              {{-- Informasi Profesional --}}
              <div class="mb-4">
                <h5 class="border-bottom pb-2 text-primary mb-3">
                  <i class="bi bi-briefcase me-2"></i>Informasi Profesional
                </h5>
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label for="specialization" class="form-label">Spesialisasi <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('specialization') is-invalid @enderror"
                      id="specialization" name="specialization"
                      value="{{ old('specialization', $doctor->specialization) }}" required>
                    @error('specialization')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="practice_location" class="form-label">Lokasi Praktik</label>
                    <input type="text" class="form-control @error('practice_location') is-invalid @enderror"
                      id="practice_location" name="practice_location"
                      value="{{ old('practice_location', $doctor->practice_location) }}">
                    @error('practice_location')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="practice_hours" class="form-label">Jam Praktik</label>
                    <input type="text" class="form-control @error('practice_hours') is-invalid @enderror"
                      id="practice_hours" name="practice_hours"
                      value="{{ old('practice_hours', $doctor->practice_hours) }}" placeholder="Contoh: 08:00 - 16:00">
                    @error('practice_hours')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="city" class="form-label">Kota</label>
                    <input type="text" class="form-control @error('city') is-invalid @enderror" id="city" name="city"
                      value="{{ old('city', $doctor->city) }}">
                    @error('city')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="col-12 mb-3">
                    <label for="address" class="form-label">Alamat Lengkap</label>
                    <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address"
                      rows="3">{{ old('address', $doctor->address) }}</textarea>
                    @error('address')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
              </div>

              <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="{{ route('doctors.index') }}" class="btn btn-outline-secondary me-md-2">
                  <i class="bi bi-x-circle me-1"></i> Batal
                </a>
                <button type="submit" class="btn btn-primary">
                  <i class="bi bi-check-circle me-1"></i> Perbarui Data
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    function togglePasswordField(buttonId, inputId) {
      const toggleBtn = document.querySelector(buttonId);
      const input = document.querySelector(inputId);
      toggleBtn.addEventListener("click", function () {
        const type = input.getAttribute("type") === "password" ? "text" : "password";
        input.setAttribute("type", type);
        this.innerHTML = type === "password" ? '<i class="bi bi-eye"></i>' : '<i class="bi bi-eye-slash"></i>';
      });
    }

    togglePasswordField("#togglePassword", "#password");
    togglePasswordField("#toggleConfirmPassword", "#password_confirmation");
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