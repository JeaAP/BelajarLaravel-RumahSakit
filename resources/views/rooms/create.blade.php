@extends('template')

@section('content')
    <div class="container mt-5">
    <div class="text-center mb-4">
      <h1>Tambah Ruangan Rawat Inap</h1>
    </div>

    @if($errors->any())
      <div class="alert alert-danger">
      <strong>Whoops!</strong> Ada kesalahan.<br><br>
      <ul>
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
      </div>
    @endif

    <form action="{{ route('rooms.store') }}" method="post">
      @csrf
      <div class="form-group">
      <label for="room_id">ID Ruangan</label>
      <input type="text" class="form-control" id="room_id" name="room_id" aria-describedby="room_idHelp"
        placeholder="Masukkan ID Ruangan" required>
      </div>

      <div class="form-group">
      <label for="name">Nama Ruangan</label>
      <input type="text" class="form-control" id="name" name="room_name" aria-describedby="nameHelp"
        placeholder="Masukkan Nama Ruangan" required>
      </div>

      <div class="form-group">
      <label for="location">Lokasi</label>
      <input type="text" class="form-control" id="location" name="location" aria-describedby="locationHelp"
        placeholder="Masukkan Lokasi Ruangan" required>
      </div>

      <div class="form-group">
      <label for="capacity">Kapasitas</label>
      <input type="number" class="form-control" id="capacity" name="capacity" aria-describedby="capacityHelp" min="0"
        placeholder="Masukkan Kapasitas Ruangan">
      </div>

      <div class="mt-4">
      <button type="submit" class="btn btn-primary">Tambah</button>
      <a href="{{ route('rooms.index') }}" class="btn btn-secondary">Kembali</a>
      </div>
    </form>
    </div>
@endsection

