@extends('template')

@section('content')
<div class="container mt-5">
  <div class="text-center mb-4">
    <h1>Update Foto Profil</h1>
  </div>

  @if ($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="form-group">
      <label for="profile_picture">Foto Profil</label>
      <input type="file" class="form-control @error('profile_picture') is-invalid @enderror" id="profile_picture" name="profile_picture" aria-describedby="profilePictureHelp">
      <small id="profilePictureHelp" class="form-text text-muted">Ukuran maksimal 2MB</small>
      @error('profile_picture')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
  </form>
</div>
@endsection


