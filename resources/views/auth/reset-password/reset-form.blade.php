@extends('template')

@section('content')
  <div class="container">
    <h2 class="mb-4">Reset Password</h2>

    @if (session('status'))
    <div class="alert alert-success">
    {{ session('status') }}
    </div>
    @endif

    <form method="POST" action="{{ route('password.update') }}">
    @csrf

    <!-- Hidden Token -->
    <input type="hidden" name="token" value="{{ $token }}">

    <!-- Email -->
    <div class="form-group mb-3">
      <label for="email">Email Address</label>
      <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
      value="{{ old('email') }}" required autofocus>
      @error('email')
      <span class="invalid-feedback">{{ $message }}</span>
    @enderror
    </div>

    <!-- Password -->
    <div class="form-group mb-3">
      <label for="password">New Password</label>
      <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password"
      required minlength="8">
      @error('password')
      <span class="invalid-feedback">{{ $message }}</span>
    @enderror
    </div>

    <!-- Confirm Password -->
    <div class="form-group mb-4">
      <label for="password-confirm">Confirm New Password</label>
      <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
    </div>

    <button type="submit" class="btn btn-primary">
      Reset Password
    </button>
    </form>
  </div>
@endsection