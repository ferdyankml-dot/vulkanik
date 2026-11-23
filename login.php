<?php
session_start();
require 'config.php';

if (isset($_SESSION['admin_logged_in'])) {
    header("Location: admin.php");
    exit();
}

$error = null;

// Fungsi: memproses autentikasi akun administrator saat form login dikirim.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username_or_email = sanitize($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    
    $is_valid = false;
    
    // Autentikasi default admin123 / admin123
    if (($username_or_email === 'admin123' || $username_or_email === 'admin123@vulkanik.com' || $username_or_email === 'admin@vulkanik.com') && $password === 'admin123') {
        $is_valid = true;
    } elseif ($conn) {
        // Fungsi database [READ]: mencocokkan email/nama dan password pada tabel users.
        $pw_md5 = md5($password);
        $sql = "SELECT * FROM users WHERE (email='$username_or_email' OR nama='$username_or_email') AND (password='$password' OR password='$pw_md5') AND role='admin'";
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
            $is_valid = true;
        }
    }
    
    if ($is_valid) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_email'] = $username_or_email;
        $_SESSION['admin_name'] = 'Admin Vulkanik';
        header("Location: admin.php");
        exit();
    } else {
        $error = "Username atau password salah! Gunakan: admin123 / admin123";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — Vulkanik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Newsreader:wght@400;500;600&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/footer.css">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #faf9f5;
            color: #151813;
        }
        .login-wrap {
            min-height: calc(100vh - 70px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .login-card {
            background: #ffffff;
            border: 1px solid rgba(21, 24, 19, 0.08);
            border-radius: 24px;
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.06);
            width: 100%;
            max-width: 440px;
            overflow: hidden;
            padding: 12px;
        }
        .login-card .card-body {
            padding: 28px;
        }
        .login-brand h2 {
            font-family: 'Newsreader', serif;
            font-size: 2rem;
            color: #151813;
            margin-bottom: 4px;
        }
        .btn-login {
            background: #344326;
            color: #ffffff;
            border-radius: 9999px;
            padding: 12px;
            font-weight: 600;
            border: none;
            transition: all 0.2s ease;
        }
        .btn-login:hover {
            background: #26331b;
            color: #ffffff;
        }
        .form-control {
            border-radius: 12px;
            padding: 12px 16px;
            border: 1px solid rgba(21, 24, 19, 0.12);
            background: #faf9f5;
        }
        .form-control:focus {
            background: #ffffff;
            border-color: #344326;
            box-shadow: 0 0 0 3px rgba(52, 67, 38, 0.15);
        }
        .credential-box {
            background: #f2f6ed;
            border: 1px solid #d9e3cc;
            border-radius: 12px;
            padding: 10px 14px;
            font-size: 0.82rem;
            color: #344326;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <?php include __DIR__ . '/includes/navbar.php'; ?>
    <div class="login-wrap">
        <div class="login-card">
            <div class="card-body">
                <div class="login-brand text-center mb-4">
                    <h2>Vulkanik<span style="color: #344326;">.</span></h2>
                    <p class="text-muted" style="font-size: 0.9rem;">Portal Masuk Petugas & Admin Posko Bencana</p>
                </div>
                
                <!-- <div class="credential-box">
                    <strong>Kredensial Akses Admin:</strong><br>
                    Username: <code>admin123</code> &bull; Password: <code>admin123</code>
                </div> -->

                <?php if (isset($error)): ?>
                    <div class="alert alert-danger" style="border-radius: 12px; font-size: 0.88rem;"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>
                
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label" style="font-size: 0.88rem; font-weight: 600;">Username / Email</label>
                        <input type="text" class="form-control" name="email" autocomplete="username" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label" style="font-size: 0.88rem; font-weight: 600;">Kata Sandi</label>
                        <input type="password" class="form-control" name="password" autocomplete="current-password" placeholder="••••••••" required>
                    </div>
                    <button type="submit" class="btn btn-login w-100">Masuk ke Portal</button>
                </form>
                
                <div class="text-center mt-4">
                    <a href="index.php" class="text-muted" style="text-decoration: none; font-size: 0.88rem;">
                        &larr; Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
