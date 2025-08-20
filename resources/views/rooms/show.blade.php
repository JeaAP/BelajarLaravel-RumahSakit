@extends('template')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-8 offset-md-2">
        <div class="card shadow-sm mt-4">
          <div class="card-body">
            <h5 class="card-title text-center">{{ $room->room_name }}</h5>
            <hr>
            <div class="d-flex justify-content-between">
              <p class="card-text"><strong>Kode Ruangan:</strong></p>
              <p class="card-text">{{ $room->room_id }}</p>
            </div>
            <div class="d-flex justify-content-between">
              <p class="card-text"><strong>Lokasi:</strong></p>
              <p class="card-text">{{ $room->location }}</p>
            </div>
            <div class="d-flex justify-content-between">
              <p class="card-text"><strong>Kapasitas:</strong></p>
              <p class="card-text">{{ $room->capacity }}</p>
            </div>
            <div class="text-end">
              <a href="{{ route('rooms.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
