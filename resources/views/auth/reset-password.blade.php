<!-- resources/views/auth/reset-password.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <!-- Tambahkan CSS yang diperlukan -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Reset Password</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <!-- Token yang dibutuhkan untuk reset password -->
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="mb-3">
                <!-- <label for="hidden" class="form-label">Email:</label> -->
                <input type="hidden" id="email" name="email" class="form-control" value="{{ $email }}" required autofocus>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">New Password:</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="password-confirm" class="form-label">Confirm Password:</label>
                <input type="password" id="password-confirm" name="password_confirmation" class="form-control" required>
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Reset Password</button>
            </div>
        </form>
    </div>

    <!-- Tambahkan JavaScript yang diperlukan -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
