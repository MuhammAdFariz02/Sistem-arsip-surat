<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Pelacakan Pengajuan Surat</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Newsreader:opsz,wght@6..72,600;6..72,700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --ink: #102033;
            --muted: #647083;
            --paper: #fbfaf6;
            --paper-soft: #f3f0e8;
            --line: #d9ded6;
            --forest: #0f766e;
            --forest-deep: #0b4f49;
            --blueprint: #1d4d7a;
            --clay: #b85c38;
            --gold: #d8a030;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background:
                linear-gradient(90deg, rgba(16, 32, 51, .04) 1px, transparent 1px) 0 0 / 34px 34px,
                linear-gradient(180deg, #fbfaf6 0%, #eef4ef 100%);
            color: var(--ink);
            font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
            min-height: 100vh;
            overflow-x: hidden;
            overflow-y: auto;
        }

        .login-container {
            display: flex;
            min-height: 100vh;
        }

        /* Left Side - Branding */
        .left-panel {
            flex: 1;
            background:
                linear-gradient(180deg, rgba(255, 255, 255, .07) 0 1px, transparent 1px) 0 0 / 100% 42px,
                linear-gradient(135deg, #102033 0%, #0b4f49 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 60px;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .left-panel::before {
            content: '';
            position: absolute;
            width: 72%;
            height: 76%;
            background:
                linear-gradient(90deg, rgba(216, 160, 48, .52) 0 7px, transparent 7px 100%),
                repeating-linear-gradient(180deg, rgba(255, 255, 255, .12) 0 42px, rgba(255, 255, 255, .03) 42px 44px);
            border: 1px solid rgba(255, 255, 255, .16);
            right: -28%;
            top: 12%;
            transform: rotate(-4deg);
        }

        .left-panel::after {
            content: '';
            position: absolute;
            background: rgba(216, 160, 48, .9);
            bottom: 0;
            height: 5px;
            left: 60px;
            width: 150px;
        }

        .brand-content {
            position: relative;
            z-index: 1;
            text-align: center;
        }

        .brand-logo {
            width: 120px;
            height: 120px;
            background: rgba(216, 160, 48, 0.18);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .brand-logo i {
            font-size: 3.5rem;
            color: white;
        }

        .brand-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 15px;
            font-family: 'Newsreader', Georgia, serif;
            letter-spacing: 0;
        }

        .brand-subtitle {
            font-size: 1.1rem;
            opacity: 0.9;
            font-weight: 300;
            line-height: 1.6;
        }

        /* Right Side - Login Form */
        .right-panel {
            flex: 1;
            background: rgba(255, 253, 248, .86);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 60px;
        }

        .login-form-wrapper {
            width: 100%;
            max-width: 450px;
            background: rgba(255, 255, 255, .88);
            border: 1px solid var(--line);
            border-radius: 8px;
            box-shadow: 0 22px 54px rgba(16, 32, 51, .12);
            padding: 28px;
            position: relative;
        }

        .login-form-wrapper::before {
            background: var(--clay);
            content: "";
            height: 64px;
            left: -1px;
            position: absolute;
            top: 28px;
            width: 5px;
        }

        .login-header {
            margin-bottom: 40px;
        }

        .login-header h2 {
            font-family: 'Newsreader', Georgia, serif;
            font-size: 2rem;
            font-weight: 700;
            color: var(--ink);
            margin-bottom: 10px;
        }

        .login-header p {
            color: var(--muted);
            font-size: 0.95rem;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            font-weight: 600;
            color: #334155;
            margin-bottom: 10px;
            font-size: 0.9rem;
            display: block;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--forest);
            font-size: 1.1rem;
        }

        .form-control {
            width: 100%;
            padding: 16px 18px 16px 50px;
            border: 1px solid #cfd8d1;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s;
            background: #fffdf8;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--forest);
            background: white;
            box-shadow: 0 0 0 4px rgba(15, 118, 110, 0.12);
        }

        .form-control::placeholder {
            color: #cbd5e0;
        }

        .btn-login {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, var(--forest) 0%, var(--forest-deep) 100%);
            border: none;
            border-radius: 8px;
            color: white;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 10px;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(15, 118, 110, 0.26);
        }

        .alert {
            padding: 14px 18px;
            border-radius: 10px;
            margin-bottom: 25px;
            border: none;
            font-size: 0.9rem;
        }

        .alert-danger {
            background: #fff5f5;
            color: #c53030;
            border-left: 4px solid #fc8181;
        }

        .footer-text {
            text-align: center;
            margin-top: 30px;
            color: #a0aec0;
            font-size: 0.85rem;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .login-container {
                flex-direction: column;
            }

            .left-panel {
                padding: 40px 30px;
                min-height: 40vh;
            }

            .brand-title {
                font-size: 1.8rem;
            }

            .right-panel {
                padding: 40px 30px;
            }

        }

        @media (max-width: 576px) {
            .left-panel {
                min-height: 30vh;
                padding: 30px 20px;
            }

            .brand-logo {
                width: 80px;
                height: 80px;
            }

            .brand-logo i {
                font-size: 2.5rem;
            }

            .brand-title {
                font-size: 1.5rem;
            }

            .brand-subtitle {
                font-size: 0.9rem;
            }

            .right-panel {
                padding: 30px 20px;
            }

            .login-header h2 {
                font-size: 1.5rem;
            }

        }
    </style>
</head>

<body>

    <div class="login-container">
        <!-- Left Panel - Branding -->
        <div class="left-panel">
            <div class="brand-content">
                <div class="brand-logo">
                    <i class="fas fa-file-alt"></i>
                </div>
                <h1 class="brand-title">Sistem Pelacakan Pengajuan Surat</h1>
                <p class="brand-subtitle">Pengajuan, pemeriksaan, persetujuan, dan verifikasi dokumen secara digital</p>
            </div>
        </div>

        <!-- Right Panel - Login Form -->
        <div class="right-panel">
            <div class="login-form-wrapper">
                <div class="login-header">
                    <h2>Selamat Datang</h2>
                    <p>Silakan masukkan kredensial Anda untuk mengakses sistem</p>
                </div>

                <!-- Alert Error (jika ada) -->
                <div class="alert alert-danger" style="display: none;" id="errorAlert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <span id="errorMessage">NIP atau password salah!</span>
                </div>

                <form action="{{ route('login') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label class="form-label">NIP</label>
                        <div class="input-wrapper">
                            <i class="fas fa-id-card input-icon"></i>
                    <input type="text" name="nip" id="nipInput" class="form-control"
                        placeholder="Masukkan NIP" value="{{ old('nip') }}" inputmode="numeric" pattern="[0-9]{18}" minlength="18" maxlength="18" required autofocus>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <div class="input-wrapper">
                            <i class="fas fa-lock input-icon"></i>
                            <input type="password" name="password" id="passwordInput" class="form-control"
                                placeholder="Masukkan password" required>
                        </div>
                    </div>

                    <button type="submit" class="btn-login">
                        <span>Masuk ke Sistem</span>
                        <i class="fas fa-arrow-right ms-2"></i>
                    </button>
                </form>

                <div class="footer-text">
                    <p>&copy; 2024 Sistem Pelacakan Pengajuan Surat</p>
                </div>
            </div>
        </div>
    </div>

    @if ($errors->any())
    <script>
        // Show error alert jika ada error dari Laravel
        document.getElementById('errorAlert').style.display = 'block';
        document.getElementById('errorMessage').textContent = '{{ $errors->first() }}';
    </script>
    @endif

</body>

</html>
