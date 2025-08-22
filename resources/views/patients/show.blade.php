@extends('template')

@section('content')
    <div class="container">
    <div class="row">
      <div class="col-md-8 offset-md-2">
      <div class="card shadow-sm mt-4">
        <div class="card-body">
        <h5 class="card-title text-center">{{ $patient->patient_name }}</h5>
        <hr>
        <div class="d-flex justify-content-between">
          <p class="card-text"><strong>ID Pasien:</strong></p>
          <p class="card-text">{{ $patient->medical_record_number }}</p>
        </div>
        <div class="d-flex justify-content-between">
          <p class="card-text"><strong>Tanggal Lahir:</strong></p>
          <p class="card-text">{{ $patient->birth_date }}</p>
        </div>
        <div class="d-flex justify-content-between">
          <p class="card-text"><strong>Jenis Kelamin:</strong></p>
          <p class="card-text">{{ $patient->gender }}</p>
        </div>
        <div class="d-flex justify-content-between">
          <p class="card-text"><strong>Alamat:</strong></p>
          <p class="card-text">{{ $patient->patient_address }}</p>
        </div>
        <div class="d-flex justify-content-between">
          <p class="card-text"><strong>Kota:</strong></p>
          <p class="card-text">{{ $patient->patient_city }}</p>
        </div>
        <div class="d-flex justify-content-between">
          <p class="card-text"><strong>Penyakit:</strong></p>
          <p class="card-text">{{ $patient->patient_disease }}</p>
        </div>
        <div class="d-flex justify-content-between">
          <p class="card-text"><strong>Dokter Penanggung Jawab:</strong></p>
          <p class="card-text">{{ $patient->doctor->name ?? '-' }}</p>
        </div>
        <div class="d-flex justify-content-between">
          <p class="card-text"><strong>Tanggal Masuk:</strong></p>
          <p class="card-text">{{ $patient->admission_date }}</p>
        </div>
        <div class="d-flex justify-content-between">
          <p class="card-text"><strong>Tanggal Keluar:</strong></p>
          <p class="card-text">{{ $patient->discharge_date ? $patient->discharge_date : 'Belum Keluar' }}</p>
        </div>
        <div class="d-flex justify-content-between">
          <p class="card-text"><strong>Nomor Kamar:</strong></p>
          <p class="card-text">{{ $patient->room_number }}</p>
        </div>
        <div class="d-flex justify-content-between">
          <p class="card-text"><strong>Status:</strong></p>
          <p class="card-text">{{ ucfirst($patient->patient_status) }}</p>
        </div>
        <div class="text-end">
          <a href="{{ route('patients.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
        </div>
      </div>
      </div>
    </div>
    </div>
@endsection