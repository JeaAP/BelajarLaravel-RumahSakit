@extends('template')

@section('content')
  <div class="container mt-5">
    <div class="text-center mb-4">
    <h1>Daftar Dokter</h1>
    </div>

    <a href="{{ route('doctors.create') }}" class="btn btn-primary mb-3">Tambah Dokter</a>
    <a href="{{ route('home') }}" class="btn btn-secondary ml-3 mb-3">Home</a>

    @if($message = session('success'))
    <div class="alert alert-success" role="alert">
    {{ $message }}
    </div>
    @endif

    <table class="table table-bordered table-striped">
    <thead>
      <tr>
      <th scope="col">ID</th>
      <th scope="col">ID Doctor</th>
      <th scope="col">Nama</th>
      <th scope="col">Tanggal Lahir</th>
      <th scope="col">Spesialis</th>
      <th scope="col">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @if($doctors->isEmpty())
      <tr>
      <td colspan="6" class="text-center">Tidak ada data dokter</td>
      </tr>
    @endif
      @foreach($doctors as $doctor)
      <tr>
      <th scope="row">{{ $doctor->id }}</th>
      <td>{{ $doctor->id_number }}</td>
      <td>{{ $doctor->name }}</td>
      <td>{{ $doctor->birth_date }}</td>
      <td>{{ $doctor->specialization }}</td>
      <td>
      <a href="{{ route('doctors.show', $doctor->id) }}" class="btn btn-info btn-sm">Lihat</a>
      <a href="{{ route('doctors.edit', $doctor->id) }}" class="btn btn-warning btn-sm">Edit</a>
      <form action="{{ route('doctors.destroy', $doctor->id) }}" method="POST" style="display:inline;">
      @csrf
      @method('DELETE')
      <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
      </form>
      </td>
      </tr>
    @endforeach
    </tbody>
    </table>

    {!! $doctors->links() !!}
  </div>
@endsection