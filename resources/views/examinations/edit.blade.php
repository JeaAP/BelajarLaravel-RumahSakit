@extends('template')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0"><i class="bi bi-pencil-square me-2"></i>Edit Pemeriksaan</h2>
            <a href="{{ route('examinations.show', $examination) }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i>Kembali
            </a>
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

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Whoops!</strong> Ada kesalahan.<br><br>
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0"><i class="bi bi-person me-2"></i>Data Pasien</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Nama Pasien:</strong> {{ $examination->visit->patient->user->name ?? 'Nama tidak tersedia' }}</p>
                        <p><strong>Keluhan Awal:</strong> {{ $examination->visit->complaint }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Tanggal Kunjungan:</strong> {{ \Carbon\Carbon::parse($examination->visit->requested_date)->format('d M Y') }}</p>
                        <p><strong>Waktu Kunjungan:</strong> {{ \Carbon\Carbon::parse($examination->visit->requested_time)->format('H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm mt-4">
            <div class="card-body">
                <form action="{{ route('examinations.update', $examination) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <h5 class="card-title text-primary mb-4"><i class="bi bi-clipboard2-pulse me-2"></i>Diagnosis & Pengobatan</h5>

                    <div class="mb-3">
                        <label for="doctor_id" class="form-label">Dokter Pemeriksa</label>
                        <input type="text" class="form-control" value="{{ $examination->doctor->user->name }} - {{ $examination->doctor->specialization }}" disabled>
                        <input type="hidden" value="{{ $examination->doctor_id }}" name="doctor_id">
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="disease_name" class="form-label">Nama Penyakit *</label>
                            <input type="text" class="form-control" id="disease_name" name="disease_name" 
                                    value="{{ $diseaseRecord->disease_name ?? old('disease_name') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="diagnosis_date" class="form-label">Tanggal Diagnosis *</label>
                                <input type="date" class="form-control" id="diagnosis_date" name="diagnosis_date"
                                        value="{{ $diseaseRecord->diagnosis_date ?? $examination->created_at->format('Y-m-d') ?? old('diagnosis_date') }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="symptoms" class="form-label">Gejala yang Dikeluhkan</label>
                        <textarea class="form-control" id="symptoms" name="symptoms" rows="2">{{ $diseaseRecord->symptoms ?? old('symptoms') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="diagnosis" class="form-label">Diagnosis *</label>
                        <textarea class="form-control" id="diagnosis" name="diagnosis" rows="2" required>{{ $examination->diagnosis ?? old('diagnosis') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="treatment_plan" class="form-label">Rencana Pengobatan *</label>
                        <textarea class="form-control" id="treatment_plan" name="treatment_plan" rows="2" required>{{ $examination->treatment_plan ?? old('treatment_plan') }}</textarea>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="medications" class="form-label">Obat yang Diberikan</label>
                            <textarea class="form-control" id="medications" name="medications" rows="2">{{ $examination->medications ?? old('medications') }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="dosage" class="form-label">Dosis & Aturan Pakai</label>
                            <textarea class="form-control" id="dosage" name="dosage" rows="2">{{ $examination->dosage ?? old('dosage') }}</textarea>
                        </div>
                    </div>

                    <h5 class="card-title text-primary mt-4 mb-4"><i class="bi bi-heart-pulse me-2"></i>Status Perawatan</h5>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="patient_status" class="form-label">Status Pasien *</label>
                            <select class="form-select" id="patient_status" name="patient_status" required>
                                <option value="under_treatment" {{ $examination->patient_status == 'under_treatment' ? 'selected' : '' }}>Dalam Perawatan</option>
                                <option value="recovered" {{ $examination->patient_status == 'recovered' ? 'selected' : '' }}>Sembuh</option>
                                <option value="referred" {{ $examination->patient_status == 'referred' ? 'selected' : '' }}>Dirujuk</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="disease_status" class="form-label">Status Penyakit *</label>
                            <select class="form-select" id="disease_status" name="disease_status" required>
                                <option value="active" {{ ($diseaseRecord->status ?? '') == 'active' ? 'selected' : '' }}>Aktif</option>
                                <option value="treated" {{ ($diseaseRecord->status ?? '') == 'treated' ? 'selected' : '' }}>Sedang Diobati</option>
                                <option value="chronic" {{ ($diseaseRecord->status ?? '') == 'chronic' ? 'selected' : '' }}>Kronis</option>
                                <option value="cured" {{ ($diseaseRecord->status ?? '') == 'cured' ? 'selected' : '' }}>Sembuh</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="needs_hospitalization" name="needs_hospitalization"
                                    value="1" {{ $examination->needs_hospitalization ? 'checked' : '' }}>
                            <label class="form-check-label" for="needs_hospitalization">
                                Pasien perlu dirawat inap
                            </label>
                        </div>
                    </div>

                    <div id="hospitalizationFields" class="bg-light p-3 rounded mb-3" style="{{ $examination->needs_hospitalization ? 'display: block;' : 'display: none;' }}">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="room_id" class="form-label">Ruangan Rawat Inap</label>
                                <select class="form-select" id="room_id" name="room_id">
                                    <option value="">Pilih Ruangan</option>
                                    @foreach($rooms as $room)
                                        <option value="{{ $room->id }}" 
                                                {{ $examination->room_id == $room->id ? 'selected' : '' }}
                                                {{ $room->status == 'occupied' && $examination->room_id != $room->id ? 'disabled' : '' }}
                                                {{ $room->status == 'occupied' && $examination->room_id != $room->id ? 'title=PENUH' : '' }}>
                                            {{ $room->room_id }} - {{ $room->room_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="admission_date" class="form-label">Tanggal Masuk Rawat Inap</label>
                                <input type="date" class="form-control" id="admission_date" name="admission_date"
                                        value="{{ $examination->admission_date ? \Carbon\Carbon::parse($examination->admission_date)->format('Y-m-d') : date('Y-m-d') }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="discharge_date" class="form-label">Tanggal Keluar Rawat Inap (jika sudah)</label>
                            <input type="date" class="form-control" id="discharge_date" name="discharge_date"
                                    value="{{ $examination->discharge_date ? \Carbon\Carbon::parse($examination->discharge_date)->format('Y-m-d') : '' }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label">Catatan Tambahan</label>
                        <textarea class="form-control" id="notes" name="notes" rows="2">{{ $examination->notes ?? old('notes') }}</textarea>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <a href="{{ route('examinations.show', $examination) }}" class="btn btn-secondary me-2">Batal</a>
                        <button type="submit" class="btn btn-primary">Perbarui Data Pemeriksaan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
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

        document.addEventListener('DOMContentLoaded', function() {
            const needsHospitalization = document.getElementById('needs_hospitalization');
            if (needsHospitalization.checked) {
                document.getElementById('room_id').setAttribute('required', 'required');
                document.getElementById('admission_date').setAttribute('required', 'required');
            }
        });
    </script>
@endsection