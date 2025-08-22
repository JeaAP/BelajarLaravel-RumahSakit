@extends('template')

@section('content')
  <div class="container mt-5">
    <h1>Daftar Pasien</h1>
    <a href="{{ route('patients.create') }}" class="btn btn-primary mb-3">Tambah Pasien</a>
    <a href="{{ route('home') }}" class="btn btn-secondary mb-3">Home</a>

    @if($message = session('success'))
    <div class="alert alert-success">{{ $message }}</div>
    @endif
    <form method="GET" action="{{ route('patients.index') }}" class="mb-3">
    <select name="status" onchange="this.form.submit()" class="form-select w-auto d-inline">
      <option value="">Semua Status</option>
      <option value="dirawat" {{ request('status') == 'dirawat' ? 'selected' : '' }}>Dirawat</option>
      <option value="pulang" {{ request('status') == 'pulang' ? 'selected' : '' }}>Pulang</option>
    </select>
    </form>

    <table class="table table-bordered">
    <thead>
      <tr>
      <th>No RM</th>
      <th>Nama</th>
      <th>Usia</th>
      <th>Penyakit</th>
      <th>Dokter</th>
      <th>Kamar</th>
      <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @if($patients->count() == 0)
      <tr>
      <td colspan="7" class="text-center">Tidak ada data pasien</td>
      </tr>
    @else
      @foreach($patients as $patient)
      <tr>
      <td>{{ $patient->medical_record_number }}</td>
      <td>{{ $patient->patient_name }}</td>
      <td>{{ $patient->patient_age }}</td>
      <td>{{ $patient->patient_disease }}</td>
      <td>{{ $patient->doctor->name }}</td>
      <td>{{ $patient->room_number }}</td>
      <td>
      <a href="{{ route('patients.show', $patient->id) }}" class="btn btn-info btn-sm">Lihat</a>
      <a href="{{ route('patients.edit', $patient->id) }}" class="btn btn-warning btn-sm">Edit</a>

      @if($patient->patient_status !== 'pulang')
      <form action="{{ route('patients.updateStatus', $patient->id) }}" method="POST" style="display:inline;">
      @csrf @method('PATCH')
      <button type="submit" class="btn btn-success btn-sm">Pulang</button>
      </form>
      @endif

      <form action="{{ route('patients.destroy', $patient->id) }}" method="POST" style="display:inline;">
      @csrf @method('DELETE')
      <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
      </form>
      </td>
      </tr>
    @endforeach
    @endif
    </tbody>
    </table>
    {!! $patients->links() !!}
  </div>
@endsection