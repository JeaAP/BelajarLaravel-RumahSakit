@extends('template')

@section('content')
  <div class="container mt-4">
    {{-- Header --}}
    <div class="text-center mb-4 p-4 bg-primary bg-gradient text-white rounded-3 shadow">
      <i class="bi bi-heart-pulse-fill display-4 mb-3"></i>
      <h1 class="fw-bold mb-2">Manajemen Dokter</h1>
      <p class="lead opacity-90">Kelola informasi dokter rumah sakit dengan antarmuka yang intuitif</p>
      <div class="mt-3">
        <span class="badge bg-light text-primary fs-6">
          <i class="bi bi-people-fill me-1"></i> Total: {{ $doctors->count() }} Dokter
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
        <h5 class="card-title mb-0 text-primary">
          <i class="bi bi-list-check me-2"></i> Daftar Dokter
        </h5>
        <div>
          <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-sm me-2">
            <i class="bi bi-arrow-left me-1"></i> Kembali
          </a>
          <a href="{{ route('doctors.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-circle me-1"></i> Dokter Baru
          </a>
        </div>
      </div>
      <div class="card-body p-0">
        @if($doctors->isEmpty())
          <div class="text-center py-5">
            <i class="bi bi-emoji-frown display-4 text-muted"></i>
            <p class="mt-3 text-muted fs-5">Tidak ada data dokter</p>
            <a href="{{ route('doctors.create') }}" class="btn btn-primary mt-2">
              <i class="bi bi-plus-circle me-1"></i> Tambah Dokter Pertama
            </a>
          </div>
        @else
          <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
              <thead class="table-light">
                <tr>
                  <th scope="col" class="text-center">ID Dokter</th>
                  <th scope="col">Nama</th>
                  <th scope="col" class="text-center">Spesialis</th>
                  <th scope="col" class="text-center">Lokasi Praktik</th>
                  <th scope="col" class="text-center">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach($doctors as $doctor)
                  <tr>
                    <td class="text-center fw-bold text-primary">{{ $doctor->id_number ?? '-' }}</td>
                    <td>
                      <div class="d-flex align-items-center">
                        <div class="bg-primary rounded-circle d-flex justify-content-center align-items-center me-3"
                          style="width: 40px; height: 40px;">
                          <i class="bi bi-person-fill text-white"></i>
                        </div>
                        <div>
                          <div class="fw-semibold">{{ $doctor->user->name ?? '-' }}</div>
                          <small class="text-muted">
                            {{ $doctor->gender ? ($doctor->gender == 'male' ? 'Laki-laki' : 'Perempuan') : '-' }}
                          </small>
                        </div>
                      </div>
                    </td>
                    <td class="text-center">
                      <span class="badge bg-info text-dark px-3 py-2">{{ $doctor->specialization ?? '-' }}</span>
                    </td>
                    <td class="text-center">
                      <span class="text-muted">{{ $doctor->practice_location ?? '-' }}</span>
                    </td>
                    <td class="text-center">
                      <div class="btn-group" role="group">
                        {{-- Tombol Detail pakai modal --}}
                        <button class="btn btn-info btn-sm text-white" data-bs-toggle="modal"
                          data-bs-target="#doctorDetailModal{{ $doctor->id }}" title="Detail">
                          <i class="bi bi-eye"></i>
                        </button>

                        <a href="{{ route('doctors.edit', $doctor->id) }}" class="btn btn-warning btn-sm" title="Edit">
                          <i class="bi bi-pencil-square"></i>
                        </a>

                        <form action="{{ route('doctors.destroy', $doctor->id) }}" method="POST" class="d-inline">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-danger btn-sm"
                            onclick="return confirm('Yakin ingin menghapus dokter {{ $doctor->user->name ?? '-' }}?')"
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

  {{-- Modal Detail Dokter --}}
  @foreach($doctors as $doctor)
    <div class="modal fade" id="doctorDetailModal{{ $doctor->id }}" tabindex="-1"
      aria-labelledby="doctorDetailModalLabel{{ $doctor->id }}" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-primary text-white">
            <h5 class="modal-title" id="doctorDetailModalLabel{{ $doctor->id }}">
              <i class="bi bi-person-badge me-2"></i> Detail Dokter
            </h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="row mb-4">
              <div class="col-md-2 d-flex justify-content-center align-items-center">
                <div class="bg-primary rounded-circle d-flex justify-content-center align-items-center"
                  style="width: 70px; height: 70px;">
                  <i class="bi bi-person-fill text-white fs-3"></i>
                </div>
              </div>
              <div class="col-md-10">
                <h4 class="text-primary">{{ $doctor->user->name ?? '-' }}</h4>
                <p class="text-muted mb-0">{{ $doctor->specialization ?? '-' }}</p>
                <p class="text-muted">{{ $doctor->practice_location ?? '-' }}</p>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <h6 class="border-bottom pb-2 text-primary">Informasi Pribadi</h6>
                <dl class="row">
                  <dt class="col-sm-5">ID Dokter</dt>
                  <dd class="col-sm-7">{{ $doctor->id_number ?? '-' }}</dd>

                  <dt class="col-sm-5">Tanggal Lahir</dt>
                  <dd class="col-sm-7">
                    {{ $doctor->birth_date ? \Carbon\Carbon::parse($doctor->birth_date)->format('d F Y') : '-' }}
                  </dd>

                  <dt class="col-sm-5">Jenis Kelamin</dt>
                  <dd class="col-sm-7">
                    {{ $doctor->gender == 'male' ? 'Laki-laki' : ($doctor->gender == 'female' ? 'Perempuan' : '-') }}
                  </dd>

                  <dt class="col-sm-5">Telepon</dt>
                  <dd class="col-sm-7">{{ $doctor->phone_number ?? '-' }}</dd>
                </dl>
              </div>
              <div class="col-md-6">
                <h6 class="border-bottom pb-2 text-primary">Informasi Profesional</h6>
                <dl class="row">
                  <dt class="col-sm-5">Spesialisasi</dt>
                  <dd class="col-sm-7">{{ $doctor->specialization ?? '-' }}</dd>

                  <dt class="col-sm-5">Lokasi Praktik</dt>
                  <dd class="col-sm-7">{{ $doctor->practice_location ?? '-' }}</dd>

                  <dt class="col-sm-5">Jam Praktik</dt>
                  <dd class="col-sm-7">{{ $doctor->practice_hours ?? '-' }}</dd>

                  <dt class="col-sm-5">Alamat</dt>
                  <dd class="col-sm-7">{{ $doctor->address ?? '-' }}, {{ $doctor->city ?? '-' }}</dd>
                </dl>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <a href="{{ route('doctors.edit', $doctor->id) }}" class="btn btn-warning">
              <i class="bi bi-pencil-square me-1"></i> Edit
            </a>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
              <i class="bi bi-x-circle me-1"></i> Tutup
            </button>
          </div>
        </div>
      </div>
    </div>
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
      background-color: rgba(13, 110, 253, 0.05);
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
  </style>
@endsection
