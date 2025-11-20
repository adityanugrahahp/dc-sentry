<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Data Center Access - PT PELNI</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="icon" href="<?php echo base_url(THEME_PATH) ?>favicon1.ico">

    <style>
        :root {
            --navy: #0f172a;
            --navy-light: #1e293b;
            --cyan: #06b6d4;
            --cyan-glow: #0ea5e9;
            --card-bg: rgba(15, 25, 45, 0.65);
            --card-border: rgba(6, 182, 212, 0.3);
            --text: #f1f5f9;
            --text-muted: #94a3b8;
            --input-bg: rgba(30, 41, 59, 0.6);
            --border: rgba(148, 163, 184, 0.3);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #334155 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            color: var(--text);
            position: relative;
            overflow: hidden;
        }

        /* SUBTLE DATA LINES BACKGROUND */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background:
                repeating-linear-gradient(90deg, transparent, transparent 50px, rgba(6, 182, 212, 0.03) 50px, rgba(6, 182, 212, 0.03) 51px),
                repeating-linear-gradient(0deg, transparent, transparent 50px, rgba(6, 182, 212, 0.03) 50px, rgba(6, 182, 212, 0.03) 51px);
            z-index: -1;
            animation: gridMove 40s linear infinite;
        }

        @keyframes gridMove {
            0% {
                transform: translate(0, 0);
            }

            100% {
                transform: translate(50px, 50px);
            }
        }

        /* FLOATING DATA PARTICLES – HALUS BANGET */
        /* FLOATING DATA PARTICLES – LEBIH TERLIHAT */
        .particle {
            position: absolute;
            color: rgba(6, 182, 212, 0.25);
            /* DARI 0.1 JADI 0.25 */
            font-size: 1.5rem;
            /* DARI 1.2rem JADI 1.5rem */
            pointer-events: none;
            animation: floatUp 15s linear infinite;
            opacity: 0;
            text-shadow: 0 0 10px rgba(6, 182, 212, 0.3);
            /* TAMBAH SHADOW */
        }

        @keyframes floatUp {
            0% {
                transform: translateY(100vh);
                opacity: 0;
            }

            10% {
                opacity: 0.8;
                /* DARI 0.6 JADI 0.8 */
            }

            90% {
                opacity: 0.8;
                /* DARI 0.6 JADI 0.8 */
            }

            100% {
                transform: translateY(-100px);
                opacity: 0;
            }
        }

        .login-container {
            width: 100%;
            max-width: 420px;
            z-index: 10;
        }

        .login-card {
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            border: 1px solid var(--card-border);
            overflow: hidden;
            box-shadow:
                0 20px 40px rgba(0, 0, 0, 0.3),
                0 0 0 1px rgba(6, 182, 212, 0.15);
            transition: all 0.4s ease;
        }

        .login-card:hover {
            transform: translateY(-6px);
            box-shadow:
                0 30px 60px rgba(0, 0, 0, 0.4),
                0 0 0 1px rgba(6, 182, 212, 0.25);
        }

        .card-header {
            background: linear-gradient(135deg, var(--navy), var(--navy-light));
            padding: 2.5rem 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .card-header::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            animation: shine 3s infinite;
        }

        @keyframes shine {
            0% {
                left: -100%;
            }

            100% {
                left: 100%;
            }
        }

        .logo {
            width: 90px;
            height: 90px;
            margin: 0 auto 1rem;
            background: rgba(6, 182, 212, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid rgba(6, 182, 212, 0.4);
            position: relative;
        }

        .logo i {
            font-size: 2.5rem;
            color: var(--cyan);
            filter: drop-shadow(0 0 10px rgba(6, 182, 212, 0.5));
        }

        .card-header h1 {
            font-weight: 800;
            font-size: 1.9rem;
            color: white;
            margin: 0;
            letter-spacing: -0.5px;
        }

        .card-header p {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.95rem;
            margin-top: 0.5rem;
            font-weight: 500;
        }

        .security-badge {
            display: inline-flex;
            align-items: center;
            background: rgba(6, 182, 212, 0.2);
            color: var(--cyan);
            padding: 0.4rem 1rem;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
            margin-top: 1rem;
            border: 1px solid rgba(6, 182, 212, 0.4);
        }

        .security-badge i {
            margin-right: 6px;
        }

        .card-body {
            padding: 2.5rem 2rem;
        }

        .form-label {
            font-weight: 600;
            color: var(--text);
            margin-bottom: 0.7rem;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* PERBAIKAN: INPUT GROUP YANG SAMA PANJANG */
        .input-group {
            margin-bottom: 1.5rem;
            position: relative;
            display: flex;
            flex-direction: column;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: stretch;
            width: 100%;
        }

        .input-wrapper .form-control {
            background: var(--input-bg);
            border: 1.5px solid var(--border);
            border-radius: 14px;
            padding: 1rem 3.5rem 1rem 3.5rem;
            font-size: 1rem;
            color: white;
            transition: all 0.3s ease;
            height: 56px;
            width: 100%;
            flex: 1;
        }

        .input-wrapper .form-control::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        .input-wrapper .form-control:focus {
            outline: none;
            border-color: var(--cyan);
            background: rgba(30, 41, 59, 0.8);
            box-shadow: 0 0 0 4px rgba(6, 182, 212, 0.2);
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--cyan);
            z-index: 5;
            pointer-events: none;
        }

        .password-toggle {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: transparent;
            border: none;
            color: rgba(255, 255, 255, 0.7);
            font-size: 1.1rem;
            cursor: pointer;
            z-index: 5;
            transition: color 0.2s ease;
            width: auto;
            height: auto;
            padding: 0.5rem;
        }

        .password-toggle:hover {
            color: white;
        }

        .btn-login {
            background: linear-gradient(135deg, var(--cyan), var(--cyan-glow));
            color: white;
            border: none;
            padding: 1rem;
            border-radius: 14px;
            font-weight: 700;
            font-size: 1.1rem;
            width: 100%;
            margin-top: 1.5rem;
            transition: all 0.4s ease;
            box-shadow: 0 8px 25px rgba(6, 182, 212, 0.4);
            position: relative;
            overflow: hidden;
            height: 56px;
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(6, 182, 212, 0.5);
        }

        .btn-login:active {
            transform: translateY(-1px);
        }

        .btn-login:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }

        .btn-login .spinner {
            display: none;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .alert {
            border-radius: 12px;
            padding: 1rem 1.2rem;
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
            border: none;
            backdrop-filter: blur(10px);
        }

        .alert-danger {
            background: rgba(239, 68, 68, 0.15);
            color: #fca5a5;
            border-left: 4px solid #ef4444;
        }

        .alert-success {
            background: rgba(34, 197, 94, 0.15);
            color: #86efac;
            border-left: 4px solid #22c55e;
        }

        .alert-info {
            background: rgba(59, 130, 246, 0.15);
            color: #93c5fd;
            border-left: 4px solid #3b82f6;
        }

        .login-footer {
            text-align: center;
            padding: 1.5rem 2rem 2rem;
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.85rem;
            background: rgba(15, 25, 45, 0.4);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* RESPONSIVE */
        @media (max-width: 480px) {
            .card-header {
                padding: 2rem 1.5rem;
            }

            .card-body {
                padding: 2rem 1.5rem;
            }

            .logo {
                width: 75px;
                height: 75px;
            }

            .logo i {
                font-size: 2rem;
            }

            .card-header h1 {
                font-size: 1.7rem;
            }
        }
    </style>

</head>

<body>

    <!-- FLOATING PARTICLES -->
    <div id="particles"></div>

    <div class="login-container">
        <div class="login-card">
            <div class="card-header">
                <div class="logo">
                    <i class="fas fa-server"></i>
                </div>
                <h1>DC-SENTRY</h1>
                <p>PT PELNI - Data Center Secure Entry Network for Tracking & Registration System</p>
                <div class="security-badge">
                    <i class="fas fa-shield-alt"></i> End-to-End Encrypted
                </div>
            </div>

            <div class="card-body">
                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <?= $this->session->flashdata('error') ?>
                    </div>
                <?php endif; ?>

                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle me-2"></i>
                        <?= $this->session->flashdata('success') ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($is_logged_in) && $is_logged_in): ?>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Anda sudah login sebagai <strong><?= $current_user ?></strong>
                    </div>
                <?php endif; ?>

                <form id="loginForm" action="<?= site_url('dc-auth/login') ?>" method="POST">
                    <div class="input-group">
                        <label class="form-label">
                            <i class="fas fa-user"></i> Username
                        </label>
                        <div class="input-wrapper">
                            <i class="fas fa-user input-icon"></i>
                            <input type="text" name="username" class="form-control"
                                placeholder="Masukkan username" required autofocus>
                        </div>
                    </div>

                    <div class="input-group">
                        <label class="form-label">
                            <i class="fas fa-lock"></i> Password
                        </label>
                        <div class="input-wrapper">
                            <i class="fas fa-lock input-icon"></i>
                            <input type="password" name="password" id="passwordInput" class="form-control"
                                placeholder="Masukkan password" required>
                            <button type="button" class="password-toggle" id="passwordToggle">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn-login" id="loginBtn">
                        <span class="spinner"><i class="fas fa-spinner fa-spin"></i></span>
                        <span class="text">Access System</span>
                    </button>
                </form>
            </div>

            <div class="login-footer">
                <small>© <?= date('Y') ?> PT PELNI • Data Center System v4.0</small>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Password toggle
        document.getElementById('passwordToggle').addEventListener('click', function() {
            const input = document.getElementById('passwordInput');
            const icon = this.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        });

        // Form submit animation
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const btn = document.getElementById('loginBtn');
            const spinner = btn.querySelector('.spinner');
            const text = btn.querySelector('.text');
            btn.disabled = true;
            spinner.style.display = 'inline-block';
            text.textContent = 'Authenticating...';

            // Reset after 5s (demo)
            setTimeout(() => {
                spinner.style.display = 'none';
                text.textContent = 'Access System';
                btn.disabled = false;
            }, 5000);
        });

        // Auto hide alerts
        setTimeout(() => {
            document.querySelectorAll('.alert').forEach(alert => {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);

        // Floating particles
        const icons = ['fas fa-server', 'fas fa-database', 'fas fa-shield-alt', 'fas fa-lock', 'fas fa-key', 'fas fa-microchip'];
        const container = document.getElementById('particles');
        const total = 20;

        for (let i = 0; i < total; i++) {
            const el = document.createElement('i');
            const icon = icons[Math.floor(Math.random() * icons.length)];
            const left = Math.random() * 100 + '%';
            const duration = Math.random() * 10 + 10 + 's';
            const delay = Math.random() * 10 + 's';

            el.className = `${icon} particle`;
            el.style.left = left;
            el.style.animationDuration = duration;
            el.style.animationDelay = delay;

            container.appendChild(el);
        }
    </script>
    <style>
        .watermark {
            position: fixed;
            bottom: 20px;
            right: 20px;
            opacity: 0.25;
            z-index: 9999;
            pointer-events: none;
            font-family: 'Inter', sans-serif;
            font-size: 12px;
            color: #ffffffff;
            text-align: right;
            line-height: 1.4;
        }

        .watermark-main {
            font-weight: 700;
            font-size: 13px;
        }

        .watermark-sub {
            font-weight: 500;
            opacity: 0.8;
        }
    </style>

    <div class="watermark">
        <div class="watermark-main">Made With Anger 🤬 - OPS TI</div>
        <div class="watermark-sub" id="watermarkTimestamp"></div>
    </div>
</body>

</html>