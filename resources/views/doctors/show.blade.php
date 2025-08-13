@extends('template')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-8 offset-md-2">
        <div class="card shadow-sm mt-4">
          <div class="card-body">
            <h5 class="card-title text-center">{{ $doctor->name }}</h5>
            <hr>
            <div class="d-flex justify-content-between">
              <p class="card-text"><strong>ID Dokter:</strong></p>
              <p class="card-text">{{ $doctor->id_number }}</p>
            </div>
            <div class="d-flex justify-content-between">
              <p class="card-text"><strong>Tanggal Lahir:</strong></p>
              <p class="card-text">{{ $doctor->birth_date }}</p>
            </div>
            <div class="d-flex justify-content-between">
              <p class="card-text"><strong>Spesialis:</strong></p>
              <p class="card-text">{{ $doctor->specialization }}</p>
            </div>
            <div class="d-flex justify-content-between">
              <p class="card-text"><strong>Lokasi Praktek:</strong></p>
              <p class="card-text">{{ $doctor->practice_location }}</p>
            </div>
            <div class="d-flex justify-content-between">
              <p class="card-text"><strong>Jam Praktek:</strong></p>
              <p class="card-text">{{ $doctor->practice_hours }}</p>
            </div>
            <div class="text-end">
              <a href="{{ route('doctors.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection