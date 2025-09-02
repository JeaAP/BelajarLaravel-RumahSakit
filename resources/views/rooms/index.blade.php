@extends('template')

@section('content')
  <div class="container mt-4">
    {{-- Header --}}
    <div class="text-center mb-4 p-4 bg-success bg-gradient text-white rounded-3 shadow">
      <i class="bi bi-building display-4 mb-3"></i>
      <h1 class="fw-bold mb-2">Manajemen Ruangan</h1>
      <p class="lead opacity-90">Kelola informasi ruangan rumah sakit dengan antarmuka yang intuitif</p>
      <div class="mt-3">
        <span class="badge bg-light text-success fs-6">
          <i class="bi bi-door-open me-1"></i> Total: {{ $rooms->count() }} Ruangan
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
        <h5 class="card-title mb-0 text-success">
          <i class="bi bi-list-check me-2"></i> Daftar Ruangan
        </h5>
        <div>
          <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-sm me-2">
            <i class="bi bi-arrow-left me-1"></i> Kembali
          </a>
          <a href="{{ route('rooms.create') }}" class="btn btn-success btn-sm">
            <i class="bi bi-plus-circle me-1"></i> Ruangan Baru
          </a>
        </div>
      </div>
      <div class="card-body p-0">
        @if($rooms->isEmpty())
          <div class="text-center py-5">
            <i class="bi bi-emoji-frown display-4 text-muted"></i>
            <p class="mt-3 text-muted fs-5">Tidak ada data ruangan</p>
            <a href="{{ route('rooms.create') }}" class="btn btn-success mt-2">
              <i class="bi bi-plus-circle me-1"></i> Tambah Ruangan Pertama
            </a>
          </div>
        @else
          <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
              <thead class="table-light">
                <tr>
                  <th scope="col" class="text-center">ID Ruangan</th>
                  <th scope="col">Nama Ruangan</th>
                  <th scope="col" class="text-center">Kapasitas</th>
                  <th scope="col" class="text-center">Lokasi</th>
                  <th scope="col" class="text-center">Status</th>
                  <th scope="col" class="text-center">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach($rooms as $room)
                  <tr>
                    <td class="text-center fw-bold text-success">{{ $room->room_id ?? '-' }}</td>
                    <td>
                      <div class="d-flex align-items-center">
                        <div class="bg-success rounded-circle d-flex justify-content-center align-items-center me-3"
                          style="width: 40px; height: 40px;">
                          <i class="bi bi-door-open text-white"></i>
                        </div>
                        <div>
                          <div class="fw-semibold">{{ $room->room_name ?? '-' }}</div>
                          <small class="text-muted">
                            {{ $room->examinations_count ?? 0 }} Pasien
                          </small>
                        </div>
                      </div>
                    </td>
                    <td class="text-center">
                      <span class="badge bg-info text-dark px-3 py-2">{{ $room->capacity ?? 0 }} Orang</span>
                    </td>
                    <td class="text-center">
                      <span class="text-muted">{{ $room->location ?? '-' }}</span>
                    </td>
                    <td class="text-center">
                      @if($room->status == 'available')
                        <span class="badge bg-success px-3 py-2">Tersedia</span>
                      @elseif($room->status == 'occupied')
                        <span class="badge bg-danger px-3 py-2">Terisi</span>
                      @else
                        <span class="badge bg-warning text-dark px-3 py-2">Pemeliharaan</span>
                      @endif
                    </td>
                    <td class="text-center">
                      <div class="btn-group" role="group">
                        <button class="btn btn-info btn-sm text-white" data-bs-toggle="modal"
                          data-bs-target="#roomDetailModal{{ $room->id }}" title="Detail">
                          <i class="bi bi-eye"></i>
                        </button>

                        <a href="{{ route('rooms.edit', $room->id) }}" class="btn btn-warning btn-sm" title="Edit">
                          <i class="bi bi-pencil-square"></i>
                        </a>

                        <form action="{{ route('rooms.destroy', $room->id) }}" method="POST" class="d-inline">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-danger btn-sm"
                            onclick="return confirm('Yakin ingin menghapus ruangan {{ $room->room_name ?? '-' }}?')"
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

  {{-- Modal Detail Ruangan --}}
  @foreach($rooms as $room)
    <div class="modal fade" id="roomDetailModal{{ $room->id }}" tabindex="-1"
      aria-labelledby="roomDetailModalLabel{{ $room->id }}" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-success text-white">
            <h5 class="modal-title" id="roomDetailModalLabel{{ $room->id }}">
              <i class="bi bi-door-open me-2"></i> Detail Ruangan
            </h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="row mb-4">
              <div class="col-md-2 d-flex justify-content-center align-items-center">
                <div class="bg-success rounded-circle d-flex justify-content-center align-items-center"
                  style="width: 70px; height: 70px;">
                  <i class="bi bi-door-open text-white fs-3"></i>
                </div>
              </div>
              <div class="col-md-10">
                <h4 class="text-success">{{ $room->room_name ?? '-' }}</h4>
                <p class="text-muted mb-0">ID: {{ $room->room_id ?? '-' }}</p>
                <p class="text-muted">{{ $room->location ?? '-' }}</p>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <h6 class="border-bottom pb-2 text-success">Informasi Ruangan</h6>
                <dl class="row">
                  <dt class="col-sm-5">ID Ruangan</dt>
                  <dd class="col-sm-7">{{ $room->room_id ?? '-' }}</dd>

                  <dt class="col-sm-5">Nama Ruangan</dt>
                  <dd class="col-sm-7">{{ $room->room_name ?? '-' }}</dd>

                  <dt class="col-sm-5">Kapasitas</dt>
                  <dd class="col-sm-7">{{ $room->capacity ?? 0 }} Orang</dd>

                  <dt class="col-sm-5">Lokasi</dt>
                  <dd class="col-sm-7">{{ $room->location ?? '-' }}</dd>
                </dl>
              </div>
              <div class="col-md-6">
                <h6 class="border-bottom pb-2 text-success">Status & Penggunaan</h6>
                <dl class="row">
                  <dt class="col-sm-5">Status</dt>
                  <dd class="col-sm-7">
                    @if($room->status == 'available')
                      <span class="badge bg-success">Tersedia</span>
                    @elseif($room->status == 'occupied')
                      <span class="badge bg-danger">Terisi</span>
                    @else
                      <span class="badge bg-warning text-dark">Pemeliharaan</span>
                    @endif
                  </dd>

                  <dt class="col-sm-5">Jumlah Pasien</dt>
                  <dd class="col-sm-7">{{ $room->examinations_count ?? 0 }} Orang</dd>

                  <dt class="col-sm-5">Ketersediaan</dt>
                  <dd class="col-sm-7">
                    @if($room->capacity > 0 && $room->examinations_count > 0)
                      {{ $room->capacity - $room->examinations_count }} dari {{ $room->capacity }} tersedia
                    @elseif($room->capacity > 0)
                      {{ $room->capacity }} tempat tersedia
                    @else
                      -
                    @endif
                  </dd>
                </dl>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <a href="{{ route('rooms.edit', $room->id) }}" class="btn btn-warning">
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
      background-color: rgba(25, 135, 84, 0.05);
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
