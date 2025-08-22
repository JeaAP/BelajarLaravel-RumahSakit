@extends('template')

@section('content')
    <div class="container mt-5">
    <div class="text-center mb-4">
    <h1>Edit Pasien</h1>
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

    <form action="{{ route('patients.update', $patient->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="form-group">
      <label for="medical_record_number">Nomor Rekam Medis</label>
      <input type="text" class="form-control" id="medical_record_number" name="medical_record_number"
      value="{{ $patient->medical_record_number }}" readonly>
    </div>

    <div class="form-group">
      <label for="patient_name">Nama Pasien</label>
      <input type="text" class="form-control" id="patient_name" name="patient_name"
      value="{{ $patient->patient_name }}">
    </div>

    <div class="form-group">
      <label for="birth_date">Tanggal Lahir</label>
      <input type="date" class="form-control" id="birth_date" name="birth_date" value="{{ $patient->birth_date }}">
    </div>

    <div class="form-group">
      <label for="gender">Jenis Kelamin</label>
      <select class="form-control" id="gender" name="gender">
      <option value="male" {{ $patient->gender == 'male' ? 'selected' : '' }}>Laki-laki</option>
      <option value="female" {{ $patient->gender == 'female' ? 'selected' : '' }}>Perempuan</option>
      </select>
    </div>

    <div class="form-group">
      <label for="patient_address">Alamat Pasien</label>
      <input type="text" class="form-control" id="patient_address" name="patient_address"
      value="{{ $patient->patient_address }}">
    </div>

    <div class="form-group">
      <label for="patient_city">Kota Pasien</label>
      <input type="text" class="form-control" id="patient_city" name="patient_city"
      value="{{ $patient->patient_city }}">
    </div>

    <div class="form-group">
      <label for="doctor_id">Dokter</label>
      <select class="form-control" id="doctor_id" name="doctor_id">
      @foreach($doctors as $doctor)
      <option value="{{ $doctor->id }}" {{ $patient->doctor_id == $doctor->id ? 'selected' : '' }}>{{ $doctor->name }} -
      ({{ $doctor->specialization }})</option>
    @endforeach
      </select>
    </div>

    <div class="form-group">
      <label for="admission_date">Tanggal Masuk</label>
      <input type="date" class="form-control" id="admission_date" name="admission_date"
      value="{{ $patient->admission_date }}">
    </div>

    <div class="form-group">
      <label for="discharge_date">Tanggal Keluar</label>
      <input type="date" class="form-control" id="discharge_date" name="discharge_date"
      value="{{ $patient->discharge_date }}">
    </div>

    <div class="form-group">
      <label for="room_number">Nomor Kamar</label>
      <select class="form-control" id="room_number" name="room_number">
      @foreach($rooms as $room)
      <option value="{{ $room->room_id }}" {{ $patient->room_number == $room->room_id ? 'selected' : '' }} {{ $room->capacity <= 0 ? 'disabled' : '' }}>
      {{ $room->room_id }} - Kapasitas: {{ $room->capacity <= 0 ? 'Penuh' : $room->capacity }}
      </option>
    @endforeach
      </select>
    </div>

    <div class="form-group">
      <label for="patient_status">Status Pasien</label>
      <select class="form-control" id="patient_status" name="patient_status">
      <option value="dirawat" {{ $patient->patient_status == 'dirawat' ? 'selected' : '' }}>Dirawat</option>
      <option value="pulang" {{ $patient->patient_status == 'pulang' ? 'selected' : '' }}>Pulang</option>
      </select>
    </div>

    <div class="mt-4">
      <button type="submit" class="btn btn-primary">Update</button>
      <a href="{{ route('patients.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
    </form>
    </div>
@endsection