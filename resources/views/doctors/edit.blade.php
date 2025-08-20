@extends('template')

@section('content')
    <div class="container mt-5">
    <div class="text-center mb-4">
    <h1>Edit Dokter</h1>
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

    <form action="{{ route('doctors.update', $doctor->id) }}" method="post">
    @csrf
    @method('PUT')
    <div class="form-group">
      <label for="id_number">ID Dokter</label>
      <input type="text" class="form-control" id="id_number" name="id_number" value="{{ $doctor->id_number }}"
      aria-describedby="idNumberHelp" placeholder="Masukkan ID Dokter">
    </div>

    <div class="form-group">
      <label for="name">Nama</label>
      <input type="text" class="form-control" id="name" name="name" value="{{ $doctor->name }}"
      aria-describedby="nameHelp" placeholder="Masukkan Nama">
    </div>

    <div class="form-group">
      <label for="birth_date">Tanggal Lahir</label>
      <input type="date" class="form-control" id="birth_date" name="birth_date" value="{{ $doctor->birth_date }}"
      aria-describedby="birthDateHelp" placeholder="Masukkan Tanggal Lahir">
    </div>

    <div class="form-group">
      <label for="specialization">Spesialis</label>
      <select name="specialization" id="specialization" class="form-control"">
      <option  value="{{ $doctor->specialization }}">{{ $doctor->specialization }}</option>
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
      <select name="practice_location" id="practice_location" class="form-control"">
      <option value="{{ $doctor->practice_location }}">{{ $doctor->practice_location }}</option>
      @foreach($rooms as $room)
        <option value="{{ $room->location }}">{{ $room->location }}</option>
      @endforeach
      </select>
    </div>

    <div class="form-group">
      <label for="practice_hours">Jam Praktek</label>
      <input type="text" class="form-control" id="practice_hours" name="practice_hours"
      value="{{ $doctor->practice_hours }}" aria-describedby="practiceHoursHelp" placeholder="Masukkan Jam Praktek">
    </div>

    <div class="mt-4">
      <button type="submit" class="btn btn-primary">Perbarui</button>
      <a href="{{ route('doctors.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
    </form>
    </div>
@endsection