<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background: #f5f7fa;
    }

    .card {
      border-radius: 1rem;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }
  </style>
</head>

<body>
  <div class="container d-flex align-items-center justify-content-center min-vh-100">
    <div class="col-md-5">
      <div class="card p-4">
        <div class="text-center mb-4">
          <h2 class="fw-bold">Login</h2>
          <p class="text-muted">Silakan masuk ke akun Anda</p>
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

        <form action="{{ route('login.post') }}" method="post">
          @csrf
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-envelope"></i></span>
              <input type="email" class="form-control" id="email" name="email" value="user@example.com" required>
            </div>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-lock"></i></span>
              <input type="password" class="form-control" id="password" name="password" value="password" required>
              <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                <i class="bi bi-eye"></i>
              </button>
            </div>
          </div>
          <button type="submit" class="btn btn-primary w-100">Login</button>
          <div class="mt-3 text-center">
            <p>Belum punya akun? <a href="{{ route('register') }}">Daftar</a></p>
            <p><a href="{{ route('password.request') }}">Lupa Password?</a></p>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    const togglePassword = document.querySelector("#togglePassword");
    const password = document.querySelector("#password");
    togglePassword.addEventListener("click", function () {
      const type = password.getAttribute("type") === "password" ? "text" : "password";
      password.setAttribute("type", type);
      this.innerHTML = type === "password" ? '<i class="bi bi-eye"></i>' : '<i class="bi bi-eye-slash"></i>';
    });
  </script>
</body>

</html>