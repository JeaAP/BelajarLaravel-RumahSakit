@extends('template')

@section('content')
      <div class="container">
        <div class="row justify-content-center mt-4">
          <div class="col-md-10 col-lg-8">
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
              <div class="card-body p-0">
                <div class="bg-primary bg-opacity-10 py-4 px-5">
                  <div class="d-flex align-items-center">
                    <div class="me-4 position-relative">
                      @if (!$user->profile_picture)
                        <div class="rounded-circle border border-2 border-white shadow-sm d-flex align-items-center justify-content-center"
                          style="width: 120px; height: 120px;">
                          <i class="bi bi-person-circle text-primary fs-1"></i>
                        </div>
                      @else
                        <img src="{{ $user->profile_picture ? asset('images/' . $user->profile_picture) : '' }}"
                          alt="profile picture" class="rounded-circle border border-2 border-white shadow-sm" width="120" height="120"
                          style="object-fit: cover; cursor: pointer;" id="profile-preview"
                          onclick="document.getElementById('profile_picture').click()">
                      @endif
                      <label for="profile_picture" class="btn btn-primary btn-sm rounded-circle position-absolute"
                        style="bottom: 10px; right: 10px; width: 32px; height: 32px; cursor: pointer;">
                        <i class="bi bi-camera"></i>
                      </label>
                    </div>

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
                </div>

                <div class="p-5">
                  <h4 class="mb-4 fw-bold text-primary">
                    <i class="fas fa-user-edit me-2"></i>Edit Profil
                  </h4>

                  <form action="{{ route('profile.update', $patientDetails->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <input type="file" name="profile_picture" id="profile_picture" class="d-none" accept="image/*">

                    <div class="row">
                      <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control rounded-3 @error('name') is-invalid @enderror" id="name"
                          name="name" value="{{ old('name', $user->name) }}" required>
                        @error('name')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>

                      <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control rounded-3" id="email" value="{{ $user->email }}" disabled>
                        <small class="text-muted">Email tidak dapat diubah</small>
                      </div>
                    </div>

                    @if($user->role == 'user')
                      <hr class="my-4">
                      <h5 class="mb-3 text-primary">
                        <i class="fas fa-info-circle me-2"></i>Informasi Pasien
                      </h5>

                      <div class="row">
                        <div class="col-md-6 mb-3">
                          <label for="phone_number" class="form-label">Nomor Telepon</label>
                          <input type="text" class="form-control rounded-3 @error('phone_number') is-invalid @enderror"
                            id="phone_number" name="phone_number"
                            value="{{ old('phone_number', $patientDetails->phone_number ?? '') }}">
                          @error('phone_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                          <label for="birth_date" class="form-label">Tanggal Lahir</label>
                          <input type="date" class="form-control rounded-3 @error('birth_date') is-invalid @enderror"
                            id="birth_date" name="birth_date"
                            value="{{ old('birth_date', $patientDetails->birth_date ?? '') }}">
                          @error('birth_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                          <label for="gender" class="form-label">Jenis Kelamin</label>
                          <select class="form-select rounded-3 @error('gender') is-invalid @enderror" id="gender" name="gender">
                            <option value="" disabled>Pilih Jenis Kelamin</option>
                            <option value="male" {{ (old('gender', $patientDetails->gender ?? '') == 'male') ? 'selected' : '' }}>
                              Laki-laki
                            </option>
                            <option value="female" {{ (old('gender', $patientDetails->gender ?? '') == 'female') ? 'selected' : '' }}>
                              Perempuan
                            </option>
                          </select>
                          @error('gender')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                          <label for="emergency_contact" class="form-label">Kontak Darurat</label>
                          <input type="text" class="form-control rounded-3 @error('emergency_contact') is-invalid @enderror"
                            id="emergency_contact" name="emergency_contact"
                            value="{{ old('emergency_contact', $patientDetails->emergency_contact ?? '') }}">
                          @error('emergency_contact')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>

                        <div class="col-12 mb-3">
                          <label for="address" class="form-label">Alamat</label>
                          <textarea class="form-control rounded-3 @error('address') is-invalid @enderror" id="address"
                            name="address" rows="2">{{ old('address', $patientDetails->address ?? '') }}</textarea>
                          @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                          <label for="city" class="form-label">Kota</label>
                          <input type="text" class="form-control rounded-3 @error('city') is-invalid @enderror" id="city"
                            name="city" value="{{ old('city', $patientDetails->city ?? '') }}">
                          @error('city')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                          <label for="insurance_info" class="form-label">Informasi Asuransi</label>
                          <input type="text" class="form-control rounded-3 @error('insurance_info') is-invalid @enderror"
                            id="insurance_info" name="insurance_info"
                            value="{{ old('insurance_info', $patientDetails->insurance_info ?? '') }}">
                          @error('insurance_info')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                    @endif

                    <div class="d-flex justify-content-between mt-4">
                      <a href="{{ route('profile.show', $patientDetails->id) }}" class="btn btn-outline-secondary rounded-pill px-4">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                      </a>
                      <button type="submit" class="btn btn-primary rounded-pill px-4">
                        <i class="fas fa-save me-2"></i>Simpan Perubahan
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
@endsection

@push('scripts')
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const profileInput = document.getElementById('profile_picture');
      const profilePreview = document.getElementById('profile-preview');

      profileInput.addEventListener('change', function () {
        const file = this.files[0];
        if (file) {
          const reader = new FileReader();
          reader.onload = function (e) {
            // Kalau preview sudah <img>, langsung ganti src
            if (profilePreview.tagName === 'IMG') {
              profilePreview.src = e.target.result;
            } else {
              // Kalau masih <div> icon, ganti jadi <img>
              const newImg = document.createElement('img');
              newImg.src = e.target.result;
              newImg.alt = 'profile preview';
              newImg.className = 'rounded-circle border border-2 border-white shadow-sm';
              newImg.width = 120;
              newImg.height = 120;
              newImg.style.objectFit = 'cover';
              newImg.style.cursor = 'pointer';
              newImg.id = 'profile-preview';

              profilePreview.replaceWith(newImg);
            }
          }
          reader.readAsDataURL(file);
        }
      });
    });
  </script>
@endpush

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

    .form-control,
    .form-select {
      border: 1px solid #dee2e6;
      padding: 0.75rem 1rem;
    }

    .form-control:focus,
    .form-select:focus {
      box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
      border-color: #86b7fe;
    }
  </style>
@endpush