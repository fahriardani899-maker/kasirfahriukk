<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login - KASIR FAHRI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />

    <style>
        body {
            background: linear-gradient(135deg, #0a1f44, #081a35);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
        }

        .login-card {
            background: rgba(255 255 255 / 12%);
            backdrop-filter: blur(18px);
            border-radius: 30px;
            box-shadow: 0 24px 48px rgba(0, 0, 0, 0.5);
            width: 100%;
            max-width: 400px;
            padding: 3rem 2.5rem 2.5rem;
            animation: fadeIn 0.9s cubic-bezier(0.4, 0, 0.2, 1);
            color: #fff;
            text-align: center;
            user-select: none;
        }

        .brand-logo {
            width: 90px;
            height: 90px;
            margin: 0 auto 1.8rem;
            background: linear-gradient(135deg, #1d4ed8, #2563eb);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.8rem;
            box-shadow: 0 0 28px rgba(37, 99, 235, 0.85);
            transition: transform 0.3s ease;
            cursor: default;
        }
        .brand-logo:hover {
            transform: scale(1.1) rotate(10deg);
        }

        h3 {
            letter-spacing: 1.3px;
            font-weight: 700;
            margin-bottom: 0.2rem;
        }

        p.lead {
            font-size: 1rem;
            font-weight: 500;
            opacity: 0.85;
            margin-bottom: 2rem;
        }

        form {
            text-align: left;
        }

        .form-label {
            font-weight: 600;
            font-size: 0.85rem;
            color: rgba(255 255 255 / 0.85);
        }

        .input-group-text {
            border-radius: 15px 0 0 15px;
            background-color: rgba(255 255 255 / 0.95);
            border: none;
            color: #444;
            font-size: 1.1rem;
        }

        .form-control {
            border-radius: 0 15px 15px 0;
            border: none;
            background-color: rgba(255 255 255 / 0.95);
            padding: 14px 18px;
            transition: box-shadow 0.3s ease;
            font-weight: 500;
            font-size: 1rem;
            color: #222;
        }
        .form-control:focus {
            box-shadow: 0 0 14px rgba(37, 99, 235, 0.75);
            outline: none;
            background-color: white;
            color: #1d4ed8;
        }

        .btn-login {
            width: 100%;
            border-radius: 18px;
            padding: 14px 0;
            font-weight: 700;
            letter-spacing: 1.1px;
            background: linear-gradient(135deg, #1d4ed8, #2563eb);
            border: none;
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.7);
            transition: all 0.25s ease;
            color: #fff;
            user-select: none;
            cursor: pointer;
        }
        .btn-login:hover {
            transform: scale(1.05);
            box-shadow: 0 0 30px rgba(37, 99, 235, 1);
        }
        .btn-login:active {
            transform: scale(0.97);
            box-shadow: 0 3px 10px rgba(37, 99, 235, 0.8);
        }

        .alert {
            border-radius: 12px;
            font-size: 0.9rem;
            padding: 0.75rem 1rem;
            margin-bottom: 1.8rem;
            user-select: none;
        }

        .footer-text {
            font-size: 11px;
            letter-spacing: 1.2px;
            opacity: 0.65;
            margin-top: 2.8rem;
            user-select: none;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(35px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>

<div class="login-card" role="main" aria-label="Login Form">
    <div class="brand-logo" aria-hidden="true" title="Logo Kasir Fahri">
        <i class="fas fa-coins"></i>
    </div>

    <h3>KASIR FAHRI</h3>
    <p class="lead">Manajemen Toko Jadi Lebih Mudah</p>

    <?php if (isset($_GET['pesan']) && $_GET['pesan'] === "gagal"): ?>
        <div class="alert alert-danger text-center" role="alert" aria-live="polite" aria-atomic="true">
            <i class="fas fa-exclamation-circle me-2"></i> Username / Password Salah!
        </div>
    <?php endif; ?>

    <form action="auth.php" method="POST" novalidate>
        <div class="mb-4">
            <label for="username" class="form-label">Username</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
                <input
                    type="text"
                    id="username"
                    name="username"
                    class="form-control"
                    placeholder="admin123"
                    required
                    autocomplete="off"
                    aria-required="true"
                />
            </div>
        </div>

        <div class="mb-5">
            <label for="password" class="form-label">Password</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="form-control"
                    placeholder="••••••••"
                    required
                    aria-required="true"
                />
            </div>
        </div>

        <button type="submit" class="btn btn-login" aria-label="Login button">MASUK SEKARANG</button>
    </form>

    <div class="footer-text text-center">
        &copy; 2026 KASIR FAHRI V.1.0
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
