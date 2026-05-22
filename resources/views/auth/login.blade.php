<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Minipalasa Education</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg,
                    #0f172a,
                    #1e3a8a,
                    #2563eb);
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            position: relative;
        }

        /* Floating Background */
        .floating-elements {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        .floating-element {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.06);
            animation: float 10s infinite ease-in-out;
        }

        .floating-element:nth-child(1) {
            width: 120px;
            height: 120px;
            top: 10%;
            left: 10%;
        }

        .floating-element:nth-child(2) {
            width: 90px;
            height: 90px;
            bottom: 15%;
            right: 10%;
        }

        .floating-element:nth-child(3) {
            width: 70px;
            height: 70px;
            top: 60%;
            left: 20%;
        }

        .floating-element:nth-child(4) {
            width: 150px;
            height: 150px;
            top: 15%;
            right: 20%;
        }

        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        /* Login Card */
        .login-container {
            position: relative;
            z-index: 10;
        }

        .login-card {
            width: 430px;
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 25px;
            overflow: hidden;
            background: rgba(255, 255, 255, 0.10);
            backdrop-filter: blur(18px);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.30);
            color: white;
        }

        /* Header */
        .login-header {
            text-align: center;
            padding: 35px 20px 20px;
            border: none;
            background: transparent;
        }

        .login-header i {
            font-size: 45px;
            color: #93c5fd;
            margin-bottom: 15px;
        }

        .login-header h4 {
            font-size: 24px;
            font-weight: 700;
        }

        .login-header p {
            color: rgba(255, 255, 255, 0.75);
            margin-top: 10px;
        }

        /* Body */
        .login-body {
            padding: 30px;
        }

        /* Labels */
        .login-form-label {
            margin-bottom: 10px;
            font-weight: 600;
        }

        /* Input Group */
        .input-group {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.10);
            border-radius: 12px;
            overflow: hidden;
        }

        .input-group-text {
            background: transparent;
            border: none;
            color: #cbd5e1;
        }

        /* Inputs */
        .login-form-control {
            background: transparent;
            border: none;
            color: white;
            padding: 14px;
        }

        .login-form-control::placeholder {
            color: rgba(255, 255, 255, 0.55);
        }

        .login-form-control:focus {
            background: transparent;
            color: white;
            box-shadow: none;
        }

        /* Password Button */
        .password-toggle {
            border: none;
            background: transparent;
            color: #cbd5e1;
            padding: 0 15px;
        }

        /* Login Button */
        .btn-login {
            background: linear-gradient(135deg,
                    #2563eb,
                    #1d4ed8);
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-login:hover {
            background: linear-gradient(135deg,
                    #1d4ed8,
                    #1e40af);
            transform: translateY(-2px);
        }

        /* Text */
        .form-check-label,
        .form-text,
        a {
            color: rgba(255, 255, 255, 0.85) !important;
        }

        a:hover {
            color: white !important;
        }

        /* Alerts */
        .alert {
            border-radius: 12px;
        }

        .login-footer-text {
            text-align: center;
            margin-top: 20px;
        }

        /* Responsive */
        @media(max-width: 500px) {

            .login-card {
                width: 95%;
                margin: 15px;
            }

            .login-body {
                padding: 20px;
            }

            .login-header h4 {
                font-size: 20px;
            }
        }
    </style>
</head>

<body>

    <!-- Floating Shapes -->
    <div class="floating-elements">
        <div class="floating-element"></div>
        <div class="floating-element"></div>
        <div class="floating-element"></div>
        <div class="floating-element"></div>
    </div>

    <!-- Login Container -->
    <div class="login-container">

        <div class="card login-card">

            <!-- Header -->
            <div class="card-header login-header">

                <i class="fas fa-graduation-cap"></i>

                <h4>
                    MINIPALASA EDUCATION
                </h4>

                <p>
                    Student Management System
                </p>

            </div>

            <!-- Body -->
            <div class="card-body login-body">

                <!-- Laravel Errors -->
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Form -->
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email -->
                    <div class="mb-4">

                        <label class="form-label login-form-label">
                            <i class="fas fa-envelope me-2"></i>
                            Email Address
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                <i class="fas fa-envelope"></i>
                            </span>

                            <input type="email" name="email" class="form-control login-form-control"
                                placeholder="Enter your email address" required>

                        </div>

                    </div>

                    <!-- Password -->
                    <div class="mb-4">

                        <label class="form-label login-form-label">
                            <i class="fas fa-lock me-2"></i>
                            Password
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                <i class="fas fa-lock"></i>
                            </span>

                            <input type="password" name="password" id="password" class="form-control login-form-control"
                                placeholder="Enter your password" required>

                            <button type="button" class="password-toggle" onclick="togglePassword()">

                                <i class="fas fa-eye" id="eyeIcon"></i>

                            </button>

                        </div>

                    </div>

                    <!-- Remember -->
                    <div class="mb-4 form-check">

                        <input type="checkbox" class="form-check-input" id="remember">

                        <label class="form-check-label" for="remember">
                            Remember Me
                        </label>

                    </div>

                    <!-- Login Button -->
                    <button type="submit" class="btn btn-login text-white w-100 py-3">

                        <i class="fas fa-sign-in-alt me-2"></i>
                        Login to Dashboard

                    </button>

                    <!-- Forgot -->
                    <div class="text-center mt-4">

                        <a href="#">
                            Forgot Password?
                        </a>

                    </div>

                </form>

                <!-- Footer -->
                <div class="login-footer-text">

                    <p>
                        <a href="#">
                            Contact Administrator
                        </a>
                    </p>

                </div>

            </div>

        </div>

    </div>

    <!-- Password Toggle -->
    <script>
        function togglePassword() {

            const password =
                document.getElementById('password');

            const eyeIcon =
                document.getElementById('eyeIcon');

            if (password.type === 'password') {

                password.type = 'text';

                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');

            } else {

                password.type = 'password';

                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        }
    </script>

</body>

</html>