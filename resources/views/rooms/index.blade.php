@extends('template')

@section('content')
  <div class="container mt-5">
    <div class="text-center mb-4">
      <h1>Daftar Ruangan Rawat Inap</h1>
    </div>

    <a href="{{ route('rooms.create') }}" class="btn btn-primary mb-3">Tambah Ruangan Rawat Inap</a>
    <a href="{{ route('home') }}" class="btn btn-secondary ml-3 mb-3">Home</a>

    @if($message = session('success'))
      <div class="alert alert-success" role="alert">
        {{ $message }}
      </div>
    @endif

    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th scope="col">ID Ruangan</th>
          <th scope="col">Nama Ruangan</th>
          <th scope="col">Kapasitas</th>
          <th scope="col">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @if($rooms->isEmpty())
          <tr>
            <td colspan="4" class="text-center">Tidak ada data ruangan rawat inap</td>
          </tr>
        @endif
        @foreach($rooms as $room)
          <tr>
            <th scope="row">{{ $room->room_id }}</th>
            <td>{{ $room->room_name }}</td>
            <td>{{ $room->capacity }}</td>
            <td>
              <a href="{{ route('rooms.show', $room->id) }}" class="btn btn-info btn-sm">Lihat</a>
              <a href="{{ route('rooms.edit', $room->id) }}" class="btn btn-warning btn-sm">Edit</a>
              <form action="{{ route('rooms.destroy', $room->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
@endsection
