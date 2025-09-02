@extends('template')

@section('content')
  <div class="container mt-4">
    <div class="row justify-content-center">
      <div class="col-md-10">
        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
          <div>
            <h2 class="fw-bold text-info mb-1">
              <i class="bi bi-pencil-square me-2"></i>Edit Pasien
            </h2>
            <p class="text-muted">Perbarui informasi pasien</p>
          </div>
          <a href="{{ route('patients.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Kembali
          </a>
        </div>

        {{-- Card Form --}}
        <div class="card shadow-sm border-0">
          <div class="card-header bg-info text-white py-3">
            <h5 class="card-title mb-0">
              <i class="bi bi-person-plus me-2"></i>Formulir Edit Pasien
            </h5>
          </div>
          <div class="card-body p-4">
            <form action="{{ route('patients.update', $patient->id) }}" method="POST">
              @csrf
              @method('PUT')

              {{-- Informasi Akun --}}
              <div class="mb-4">
                <h5 class="border-bottom pb-2 text-info mb-3">
                  <i class="bi bi-person-badge me-2"></i>Informasi Akun
                </h5>
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                      value="{{ old('name', $patient->user->name) }}" required>
                    @error('name')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                      value="{{ old('email', $patient->user->email) }}" required>
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

              {{-- Informasi Medis --}}
              <div class="mb-4">
                <h5 class="border-bottom pb-2 text-info mb-3">
                  <i class="bi bi-heart-pulse me-2"></i>Informasi Medis
                </h5>
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label for="medical_record_number" class="form-label">Nomor Rekam Medis <span
                        class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('medical_record_number') is-invalid @enderror"
                      id="medical_record_number" name="medical_record_number"
                      value="{{ old('medical_record_number', $patient->medical_record_number) }}" required>
                    @error('medical_record_number')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="patient_disease" class="form-label">Diagnosa Penyakit <span
                        class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('patient_disease') is-invalid @enderror"
                      id="patient_disease" name="patient_disease"
                      value="{{ old('patient_disease', $patient->patient_disease) }}" required>
                    @error('patient_disease')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
              </div>

              {{-- Informasi Pribadi --}}
              <div class="mb-4">
                <h5 class="border-bottom pb-2 text-info mb-3">
                  <i class="bi bi-info-circle me-2"></i>Informasi Pribadi
                </h5>
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label for="birth_date" class="form-label">Tanggal Lahir</label>
                    <input type="date" class="form-control @error('birth_date') is-invalid @enderror" id="birth_date"
                      name="birth_date" value="{{ old('birth_date', $patient->patientDetail->birth_date ?? '') }}">
                    @error('birth_date')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="gender" class="form-label">Jenis Kelamin</label>
                    <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender">
                      <option value="">Pilih Jenis Kelamin</option>
                      <option value="male" {{ old('gender', $patient->patientDetail->gender ?? '') == 'male' ? 'selected' : '' }}>Laki-laki</option>
                      <option value="female" {{ old('gender', $patient->patientDetail->gender ?? '') == 'female' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('gender')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="phone_number" class="form-label">Nomor Telepon</label>
                    <input type="tel" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number"
                      name="phone_number" value="{{ old('phone_number', $patient->patientDetail->phone_number ?? '') }}">
                    @error('phone_number')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="emergency_contact" class="form-label">Kontak Darurat</label>
                    <input type="text" class="form-control @error('emergency_contact') is-invalid @enderror"
                      id="emergency_contact" name="emergency_contact"
                      value="{{ old('emergency_contact', $patient->patientDetail->emergency_contact ?? '') }}">
                    @error('emergency_contact')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="insurance_info" class="form-label">Informasi Asuransi</label>
                    <input type="text" class="form-control @error('insurance_info') is-invalid @enderror"
                      id="insurance_info" name="insurance_info"
                      value="{{ old('insurance_info', $patient->patientDetail->insurance_info ?? '') }}">
                    @error('insurance_info')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="city" class="form-label">Kota</label>
                    <input type="text" class="form-control @error('city') is-invalid @enderror" id="city" name="city"
                      value="{{ old('city', $patient->patientDetail->city ?? '') }}">
                    @error('city')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="col-12 mb-3">
                    <label for="address" class="form-label">Alamat Lengkap</label>
                    <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address"
                      rows="3">{{ old('address', $patient->patientDetail->address ?? '') }}</textarea>
                    @error('address')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
              </div>

              <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="reset" class="btn btn-outline-secondary me-md-2">
                  <i class="bi bi-arrow-clockwise me-1"></i> Reset
                </button>
                <button type="submit" class="btn btn-info text-white">
                  <i class="bi bi-save me-1"></i> Perbarui Data
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