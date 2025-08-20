@extends('template')

@section('content')
  <div class="container mt-5">
    <div class="text-center mb-4">
    <h1>Tambah Dokter</h1>
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

    <form action="{{ route('doctors.store') }}" method="post">
    @csrf
    <div class="form-group">
      <label for="id_number">ID Dokter</label>
      <input type="text" class="form-control" id="id_number" name="id_number" aria-describedby="idNumberHelp"
      placeholder="Masukkan ID Dokter">
    </div>

    <div class="form-group">
      <label for="name">Nama</label>
      <input type="text" class="form-control" id="name" name="name" aria-describedby="nameHelp"
      placeholder="Masukkan Nama">
    </div>

    <div class="form-group">
      <label for="birth_date">Tanggal Lahir</label>
      <input type="date" class="form-control" id="birth_date" name="birth_date" aria-describedby="birthDateHelp"
      placeholder="Masukkan Tanggal Lahir">
    </div>

    <div class="form-group">
      <label for="specialization">Spesialis</label>
      <select class="form-control" id="specialization" name="specialization" aria-describedby="specializationHelp">
      <option value="" disabled selected>Pilih Spesialis</option>
      <option value="Poli Jantung">Poli Jantung</option>
      <option value="Poli Mata">Poli Mata</option>
      <option value="Poli Bedah">Poli Bedah</option>
      <option value="Poli Gizi">Poli Gizi</option>
      <option value="Kodok">Kodok</option>
      <option value="Sapi">Sapi</option>
      <option value="Kambing">Kambing</option>
      </select>
    </div>

    <div class="form-group">
      <label for="practice_location">Lokasi Praktek</label>
      <select class="form-control" id="practice_location" name="practice_location"
      aria-describedby="practiceLocationHelp">
      <option value="" disabled selected>Pilih Lokasi Praktek</option>
      @foreach($rooms as $room)
        <option value="{{ $room->location }}">{{ $room->location }}</option>
      @endforeach
      </select>
    </div>

    <div class="form-group">
      <label for="practice_hours">Jam Praktek</label>
      <input type="string" class="form-control" id="practice_hours" name="practice_hours"
      aria-describedby="practiceHoursHelp" placeholder="Masukkan Jam Praktek" step="900">
    </div>

    <div class="mt-4">
      <button type="submit" class="btn btn-primary">Tambah</button>
      <a href="{{ route('doctors.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
    </form>
  </div>
@endsection