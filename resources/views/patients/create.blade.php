@extends('template')

@section('content')
  <div class="container mt-5">
    <div class="text-center mb-4">
    <h1>Tambah Pasien</h1>
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

    <form action="{{ route('patients.store') }}" method="POST">
    @csrf
    <div class="form-group">
      <label for="medical_record_number">Nomor Rekam Medis</label>
      <input type="text" class="form-control" id="medical_record_number" name="medical_record_number"
      placeholder="Masukkan Nomor Rekam Medis">
    </div>

    <div class="form-group">
      <label for="patient_name">Nama Pasien</label>
      <input type="text" class="form-control" id="patient_name" name="patient_name" placeholder="Masukkan Nama Pasien">
    </div>

    <div class="form-group">
      <label for="birth_date">Tanggal Lahir</label>
      <input type="date" class="form-control" id="birth_date" name="birth_date">
    </div>

    <div class="form-group">
      <label for="gender">Jenis Kelamin</label>
      <select class="form-control" id="gender" name="gender">
      <option value="" disabled selected>Pilih Jenis Kelamin</option>
      <option value="male">Laki-laki</option>
      <option value="female">Perempuan</option>
      </select>
    </div>

    <div class="form-group">
      <label for="patient_address">Alamat Pasien</label>
      <input type="text" class="form-control" id="patient_address" name="patient_address"
      placeholder="Masukkan Alamat Pasien">
    </div>

    <div class="form-group">
      <label for="patient_city">Kota Pasien</label>
      <input type="text" class="form-control" id="patient_city" name="patient_city" placeholder="Masukkan Kota Pasien">
    </div>

    <div class="form-group">
      <label for="doctor_id">Dokter</label>
      <select class="form-control" id="doctor_id" name="doctor_id">
      <option value="" disabled selected>Pilih Dokter</option>
      @foreach($doctors as $doctor)
      <option value="{{ $doctor->id }}">{{ $doctor->name }} - ({{ $doctor->specialization }})</option>
    @endforeach
      </select>
    </div>

    <div class="form-group">
      <label for="admission_date">Tanggal Masuk</label>
      <input type="date" class="form-control" id="admission_date" name="admission_date">
    </div>

    <div class="form-group">
      <label for="room_number">Nomor Kamar</label>
      <select class="form-control" id="room_number" name="room_number">
      <option value="" disabled selected>Pilih Kamar</option>
      @foreach($rooms as $room)
      <option value="{{ $room->room_id }}" {{ $room->capacity <= 0 ? 'disabled' : '' }}>
      {{ $room->room_id }} - Kapasitas: {{ $room->capacity <= 0 ? 'Penuh' : $room->capacity }}
      </option>
    @endforeach
      </select>
    </div>

    <div class="mt-4">
      <button type="submit" class="btn btn-primary">Tambah</button>
      <a href="{{ route('patients.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
    </form>
  </div>
@endsection