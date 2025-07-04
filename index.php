<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login - Antosa Arsitek</title>

    <!-- Custom fonts for this template-->
    <link href="tmp/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="tmp/css/sb-admin-2.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #1a1a1a 0%, #2d3748 50%, #1a1a1a 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 0;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 24px;
            padding: 3.5rem;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 32px 64px rgba(0, 0, 0, 0.2);
        }

        .logo-section {
            text-align: center;
            margin-bottom: 2rem;
        }

        .logo-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .logo-icon i {
            font-size: 3.5rem;
            color: #fff;
            opacity: 0.9;
        }

        .brand-title {
            color: #fff;
            font-size: 2rem;
            font-weight: 700;
            margin: 0;
            letter-spacing: -0.5px;
        }

        .brand-subtitle {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.875rem;
            font-weight: 400;
            margin: 0.5rem 0 0 0;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }

        .form-control-modern {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            color: #fff;
            font-size: 1rem;
            padding: 1rem 1.25rem;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .form-control-modern::placeholder {
            color: rgba(255, 255, 255, 0.6);
            font-weight: 400;
        }

        .form-control-modern:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 255, 255, 0.4);
            box-shadow: 0 0 0 0.2rem rgba(255, 255, 255, 0.1);
            color: #fff;
        }

        .password-toggle {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: rgba(255, 255, 255, 0.6);
            cursor: pointer;
            font-size: 1.1rem;
            transition: color 0.3s ease;
        }

        .password-toggle:hover {
            color: rgba(255, 255, 255, 0.9);
        }

        .btn-login {
            background: linear-gradient(135deg, #4a90e2 0%, #357abd 100%);
            border: none;
            border-radius: 12px;
            color: #fff;
            font-size: 1rem;
            font-weight: 600;
            padding: 1rem;
            width: 100%;
            margin-top: 1.5rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(74, 144, 226, 0.3);
        }

        .btn-login:hover {
            background: linear-gradient(135deg, #357abd 0%, #2968a3 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(74, 144, 226, 0.4);
            color: #fff;
        }

        .footer-text {
            text-align: center;
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.875rem;
            margin-top: 2rem;
        }

        @media (max-width: 576px) {
            .login-container {
                margin: 1rem;
                padding: 2rem;
            }

            .brand-title {
                font-size: 1.5rem;
            }

            .login-title {
                font-size: 2rem;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="login-container">
                    <!-- Logo and Brand -->
                    <div class="logo-section">
                        <div class="logo-icon">
                            <i class="fas fa-drafting-compass"></i>
                        </div>
                        <h1 class="brand-title">ANTOSA<br>ARCHITECT</h1>
                        <p class="brand-subtitle">PROJECT MANAGEMENT SYSTEM</p>
                    </div>

                    <!-- Login Form -->
                    <form method="post" action="cek_login.php">
                        <div class="form-group">
                            <input type="text" class="form-control form-control-modern"
                                   name="username" placeholder="Username" required>
                        </div>

                        <div class="form-group">
                            <input type="password" class="form-control form-control-modern"
                                   name="password" placeholder="Password" id="password" required>
                            <button type="button" class="password-toggle" onclick="togglePassword()">
                                <i class="fas fa-eye" id="toggleIcon"></i>
                            </button>
                        </div>

                        <button type="submit" class="btn btn-login">
                            Log in
                        </button>
                    </form>

                    <!-- Footer -->
                    <div class="footer-text">
                        © 2025 Antosa Architect
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="tmp/vendor/jquery/jquery.min.js"></script>
    <script src="tmp/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="tmp/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="tmp/js/sb-admin-2.min.js"></script>

    <script>
        function togglePassword() {
            const passwordField = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>

</html>