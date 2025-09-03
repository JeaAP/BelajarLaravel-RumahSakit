@extends('template')

@section('content')
  <div class="container mt-4">
    {{-- Header --}}
    <div class="text-center mb-4 p-4 bg-purple bg-gradient text-white rounded-3 shadow"
      style="background-color: #9b59b6;">
      <i class="bi bi-calendar-check display-4 mb-3"></i>
      <h1 class="fw-bold mb-2">Manajemen Kunjungan</h1>
      <p class="lead opacity-90">Kelola data kunjungan pasien dengan antarmuka yang intuitif</p>
      <div class="mt-3">
        <span class="badge bg-light text-purple fs-6" style="color: #9b59b6 !important;">
          <i class="bi bi-people me-1"></i> Total: {{ $visits->count() }} Kunjungan
        </span>
      </div>
    </div>

    {{-- Alert sukses --}}
    @if($message = session('success'))
      <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>
        {{ $message }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    {{-- Main content --}}
    <div class="card shadow border-0">
      <div class="card-header bg-light py-3 d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0 text-purple" style="color: #9b59b6;">
          <i class="bi bi-list-check me-2"></i> Daftar Kunjungan
        </h5>
        <div>
          <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-sm me-2">
            <i class="bi bi-arrow-left me-1"></i> Kembali
          </a>
          <a href="{{ route('visits.create') }}" class="btn btn-purple btn-sm"
            style="background-color: #9b59b6; border-color: #9b59b6; color: white;">
            <i class="bi bi-plus-circle me-1"></i> Kunjungan Baru
          </a>
        </div>
      </div>
      <div class="card-body p-0">
        @if($visits->isEmpty())
          <div class="text-center py-5">
            <i class="bi bi-emoji-frown display-4 text-muted"></i>
            <p class="mt-3 text-muted fs-5">Tidak ada data kunjungan</p>
            <a href="{{ route('visits.create') }}" class="btn mt-2"
              style="background-color: #9b59b6; border-color: #9b59b6; color: white;">
              <i class="bi bi-plus-circle me-1"></i> Tambah Kunjungan Pertama
            </a>
          </div>
        @else
          <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
              <thead class="table-light">
                <tr>
                  <th scope="col" class="text-center">ID Pasien</th>
                  <th scope="col">Nama Pasien</th>
                  <th scope="col" class="text-center">Keluhan</th>
                  <th scope="col" class="text-center">Tanggal Permintaan</th>
                  <th scope="col" class="text-center">Waktu Permintaan</th>
                  <th scope="col" class="text-center">Status</th>
                  <th scope="col" class="text-center">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach($visits as $visit)
                  <tr>
                    <td class="text-center fw-bold text-purple" style="color: #9b59b6;">
                      {{ $visit->patient->medical_record_number ?? '-' }}
                    </td>
                    <td>
                      <div class="d-flex align-items-center">
                        <div class="bg-purple rounded-circle d-flex justify-content-center align-items-center me-3"
                          style="width: 40px; height: 40px; background-color: #9b59b6;">
                          <i class="bi bi-person text-white"></i>
                        </div>
                        <div>
                          <div class="fw-semibold">{{ $visit->patient->user->name ?? '-' }}</div>
                          <small class="text-muted">
                            {{ $visit->doctor->user->name ?? 'Belum ada dokter' }}
                          </small>
                        </div>
                      </div>
                    </td>
                    <td class="text-center">
                      <span class="text-truncate d-inline-block" style="max-width: 200px;"
                        title="{{ $visit->complaint ?? '-' }}">
                        {{ $visit->complaint ?? '-' }}
                      </span>
                    </td>
                    <td class="text-center">
                      <span
                        class="text-muted">{{ $visit->requested_date ? \Carbon\Carbon::parse($visit->requested_date)->format('d/m/Y') : '-' }}</span>
                    </td>
                    <td class="text-center">
                      <span
                        class="text-muted">{{ $visit->requested_time ? \Carbon\Carbon::parse($visit->requested_time)->format('H:i') : '-' }}</span>
                    </td>
                    <td class="text-center">
                      @if($visit->status == 'pending')
                        <span class="badge bg-warning text-dark px-3 py-2">Menunggu</span>
                      @elseif($visit->status == 'approved')
                        <span class="badge bg-success px-3 py-2">Disetujui</span>
                      @elseif($visit->status == 'rejected')
                        <span class="badge bg-danger px-3 py-2">Ditolak</span>
                      @elseif($visit->status == 'completed')
                        <span class="badge bg-info px-3 py-2">Selesai</span>
                      @else
                        <span class="badge bg-secondary px-3 py-2">Dibatalkan</span>
                      @endif
                    </td>
                    <td class="text-center">
                      <div class="btn-group" role="group">
                        <button class="btn btn-info btn-sm text-white" data-bs-toggle="modal"
                          data-bs-target="#visitDetailModal{{ $visit->id }}" title="Detail">
                          <i class="bi bi-eye"></i>
                        </button>

                        <!-- <a href="{{ route('visits.edit', $visit->id) }}" class="btn btn-warning btn-sm" title="Edit">
                          <i class="bi bi-pencil-square"></i>
                        </a> -->

                        <form action="{{ route('visits.destroy', $visit->id) }}" method="POST" class="d-inline">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-danger btn-sm"
                            onclick="return confirm('Yakin ingin menghapus kunjungan {{ $visit->patient->user->name ?? '-' }}?')"
                            title="Hapus">
                            <i class="bi bi-trash"></i>
                          </button>
                        </form>
                      </div>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        @endif
      </div>
    </div>
  </div>

  {{-- Modal Detail Kunjungan --}}
  @foreach($visits as $visit)
    <div class="modal fade" id="visitDetailModal{{ $visit->id }}" tabindex="-1"
      aria-labelledby="visitDetailModalLabel{{ $visit->id }}" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header text-white" style="background-color: #9b59b6;">
            <h5 class="modal-title" id="visitDetailModalLabel{{ $visit->id }}">
              <i class="bi bi-calendar-check me-2"></i> Detail Kunjungan
            </h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="row mb-4">
              <div class="col-md-2 d-flex justify-content-center align-items-center">
                <div class="rounded-circle d-flex justify-content-center align-items-center"
                  style="width: 70px; height: 70px; background-color: #9b59b6;">
                  <i class="bi bi-person text-white fs-3"></i>
                </div>
              </div>
              <div class="col-md-10">
                <h4 class="text-purple" style="color: #9b59b6;">{{ $visit->patient->user->name ?? '-' }}</h4>
                <p class="text-muted mb-0">No. RM: {{ $visit->patient->medical_record_number ?? '-' }}</p>
                <p class="text-muted">Dokter: {{ $visit->doctor->user->name ?? 'Belum ditentukan' }}</p>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <h6 class="border-bottom pb-2 text-purple" style="color: #9b59b6;">Informasi Kunjungan</h6>
                <dl class="row">
                  <dt class="col-sm-5">No. Rekam Medis</dt>
                  <dd class="col-sm-7">{{ $visit->patient->medical_record_number ?? '-' }}</dd>

                  <dt class="col-sm-5">Nama Pasien</dt>
                  <dd class="col-sm-7">{{ $visit->patient->user->name ?? '-' }}</dd>

                  <dt class="col-sm-5">Tanggal Permintaan</dt>
                  <dd class="col-sm-7">
                    {{ $visit->requested_date ? \Carbon\Carbon::parse($visit->requested_date)->format('d/m/Y') : '-' }}
                  </dd>

                  <dt class="col-sm-5">Waktu Permintaan</dt>
                  <dd class="col-sm-7">
                    {{ $visit->requested_time ? \Carbon\Carbon::parse($visit->requested_time)->format('H:i') : '-' }}
                  </dd>
                </dl>
              </div>
              <div class="col-md-6">
                <h6 class="border-bottom pb-2 text-purple" style="color: #9b59b6;">Status & Keluhan</h6>
                <dl class="row">
                  <dt class="col-sm-5">Status</dt>
                  <dd class="col-sm-7">
                    @if($visit->status == 'pending')
                      <span class="badge bg-warning text-dark">Menunggu</span>
                    @elseif($visit->status == 'approved')
                      <span class="badge bg-success">Disetujui</span>
                    @elseif($visit->status == 'rejected')
                      <span class="badge bg-danger">Ditolak</span>
                    @elseif($visit->status == 'completed')
                      <span class="badge bg-info">Selesai</span>
                    @else
                      <span class="badge bg-secondary">Dibatalkan</span>
                    @endif
                  </dd>

                  <dt class="col-sm-5">Dokter Penanggung Jawab</dt>
                  <dd class="col-sm-7">{{ $visit->patient->doctor->user->name ?? 'Belum ditentukan' }}</dd>

                  <dt class="col-sm-5">Keluhan</dt>
                  <dd class="col-sm-7">{{ $visit->complaint ?? '-' }}</dd>

                  @if($visit->cancellation_reason)
                    <dt class="col-sm-5">Alasan Pembatalan</dt>
                    <dd class="col-sm-7">{{ $visit->cancellation_reason }}</dd>
                  @endif
                </dl>
              </div>
            </div>

            {{-- Form --}}
            @if(in_array($visit->status, ['pending', 'approved']))
              <div class="mt-4 pt-3 border-top">
                <h6 class="border-bottom pb-2 text-purple mb-3" style="color: #9b59b6;">
                  <i class="bi bi-gear me-2"></i>Kelola Kunjungan
                </h6>

                <form action="{{ route('visits.update', $visit->id) }}" method="POST">
                  @csrf
                  @method('PUT')

                  <div class="row">
                    <div class="col-md-6 mb-3">
                      <label for="doctor_id_{{ $visit->id }}" class="form-label">Pilih Dokter</label>
                      <select class="form-select" id="doctor_id_{{ $visit->id }}" name="doctor_id">
                        <option value="">Pilih Dokter</option>
                        @foreach($doctors as $doctor)
                          <option value="{{ $doctor->id }}" {{ (old('doctor_id', $visit->doctor_id) == $doctor->id) ? 'selected' : '' }}>
                            {{ $doctor->user->name }} - {{ $doctor->specialization }}
                          </option>
                        @endforeach
                      </select>
                    </div>

                    <div class="col-md-6 mb-3">
                      <label for="status_action_{{ $visit->id }}" class="form-label">Tindakan</label>
                      <select class="form-select" id="status_action_{{ $visit->id }}" name="status">
                        <option value="approved" {{ $visit->status == 'approved' ? 'selected' : '' }}>Setujui Kunjungan</option>
                        <option value="completed" {{ $visit->status == 'completed' ? 'selected' : '' }}>Tandai Selesai</option>
                        <option value="cancelled">Batalkan Kunjungan</option>
                      </select>
                    </div>

                    <div class="col-md-12 mb-3" id="cancellation_reason_container_{{ $visit->id }}" style="display: none;">
                      <label for="cancellation_reason_{{ $visit->id }}" class="form-label">Alasan Pembatalan</label>
                      <textarea class="form-control" id="cancellation_reason_{{ $visit->id }}" name="cancellation_reason"
                        rows="2"
                        placeholder="Masukkan alasan pembatalan">{{ old('cancellation_reason', $visit->cancellation_reason) }}</textarea>
                    </div>

                    <div class="col-md-12">
                      <button type="submit" class="btn btn-success w-100">
                        <i class="bi bi-check-circle me-1"></i> Simpan Perubahan
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            @endif
          </div>
          <div class="modal-footer">
            <!-- <a href="{{ route('visits.edit', $visit->id) }}" class="btn btn-warning">
              <i class="bi bi-pencil-square me-1"></i> Edit Lengkap
            </a> -->
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
              <i class="bi bi-x-circle me-1"></i> Tutup
            </button>
          </div>
        </div>
      </div>
    </div>

    <script>
      document.addEventListener('DOMContentLoaded', function () {

        const statusSelect = document.getElementById('status_action_{{ $visit->id }}');
        const reasonContainer = document.getElementById('cancellation_reason_container_{{ $visit->id }}');

        if (statusSelect && reasonContainer) {
          function toggleCancellationReason() {
            if (statusSelect.value === 'cancelled') {
              reasonContainer.style.display = 'block';
              document.getElementById('cancellation_reason_{{ $visit->id }}').setAttribute('required', 'required');
            } else {
              reasonContainer.style.display = 'none';
              document.getElementById('cancellation_reason_{{ $visit->id }}').removeAttribute('required');
            }
          }

          statusSelect.addEventListener('change', toggleCancellationReason);
          toggleCancellationReason();
        }
      });
    </script>
  @endforeach

  <style>
    .table th {
      border-top: none;
      font-weight: 600;
      text-transform: uppercase;
      font-size: 0.85rem;
      letter-spacing: 0.5px;
      background-color: #f8f9fa;
    }

    .table-hover tbody tr:hover {
      background-color: rgba(155, 89, 182, 0.05);
      transform: translateY(-1px);
      transition: all 0.2s ease;
    }

    .card {
      border-radius: 0.75rem;
      overflow: hidden;
    }

    .card-header {
      border-radius: 0 !important;
    }

    .btn-group .btn {
      border-radius: 0.375rem;
      margin: 0 2px;
    }

    .badge {
      font-size: 0.85em;
    }

    .bg-purple {
      background-color: #9b59b6;
    }

    .text-purple {
      color: #9b59b6;
    }
  </style>
@endsection