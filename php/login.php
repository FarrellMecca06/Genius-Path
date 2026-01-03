<?php
include __DIR__ . '/config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$is_admin = isset($_GET['type']) && $_GET['type'] === 'admin';

if (isset($_SESSION['user_id']) && !$is_admin) {
    $stmtCheck = $pdo->prepare("SELECT id FROM user_assessments WHERE user_id = ? LIMIT 1");
    $stmtCheck->execute([$_SESSION['user_id']]);
    
    if ($stmtCheck->fetch()) {
        wp_redirect(home_url('/careers.php')); 
    } else {
        wp_redirect(home_url('/self_discovery.php'));
    }
    exit;
}

if (isset($_SESSION['admin_id']) && $is_admin) {
    wp_redirect(home_url('/wp-content/themes/Genius-Path/AdminPage/'));
    exit;
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '' || $password === '') {
        $error = "Please fill in both email and password.";
    } else {
        if ($is_admin) {
            $stmt = $pdo->prepare("SELECT id, full_name, password_hash FROM admins WHERE email = ? LIMIT 1");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password_hash'])) {
                $_SESSION['admin_id']        = $user['id'];
                $_SESSION['admin_full_name'] = $user['full_name'];
                wp_redirect(home_url('/wp-content/themes/Genius-Path/AdminPage/'));
                exit;
            } else {
                $error = "Invalid email or password.";
            }
        } else {
            $stmt = $pdo->prepare("SELECT id, full_name, password_hash FROM users WHERE email = ? LIMIT 1");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password_hash'])) {
                $_SESSION['user_id']        = $user['id'];
                $_SESSION['user_full_name'] = $user['full_name'];

                $stmtCheck = $pdo->prepare("SELECT id FROM user_assessments WHERE user_id = ? LIMIT 1");
                $stmtCheck->execute([$user['id']]);

                if ($stmtCheck->fetch()) {
                    wp_redirect(home_url('/careers.php'));
                } else {
                    wp_redirect(home_url('/self_discovery.php'));
                }
                exit;

            } else {
                $error = "Invalid email or password.";
            }
        }
    }
}

// Don't include header/footer for cleaner login page
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $is_admin ? 'Admin Login' : 'Login'; ?> - GeniusPath</title>
    <link rel="stylesheet" href="<?php echo home_url('/wp-content/themes/Genius-Path/php/style.css'); ?>">
    <style>
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
        }

        .login-container {
            display: flex;
            height: 100vh;
            background: #ffffff;
        }

        .login-left {
            flex: 1;
            background: linear-gradient(135deg, #4a9fd8 0%, #3a8bc8 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 2rem;
            color: white;
        }

        .login-left-content {
            text-align: center;
            max-width: 400px;
        }

        .login-logo {
            margin-bottom: 2rem;
        }

        .login-logo img {
            height: 60px;
            width: auto;
        }

        .login-left h1 {
            font-size: 3rem;
            font-weight: 700;
            margin: 0 0 1rem 0;
            color: white;
        }

        .login-left p {
            font-size: 1.1rem;
            font-weight: 300;
            color: rgba(255, 255, 255, 0.9);
            margin: 0;
            line-height: 1.6;
        }

        .login-illustration {
            margin-top: 3rem;
            opacity: 0.9;
        }

        .login-illustration img {
            max-width: 200px;
            height: auto;
        }

        .login-right {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 2rem;
            background: #f8fafc;
        }

        .login-form-container {
            width: 100%;
            max-width: 420px;
        }

        .login-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .login-tabs {
            display: flex;
            gap: 1rem;
        }

        .login-tab {
            padding: 0.75rem 1.5rem;
            background: transparent;
            border: none;
            color: #94a3b8;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s;
        }

        .login-tab.active {
            color: #4a9fd8;
            border-bottom: 2px solid #4a9fd8;
        }

        .login-tab:hover {
            color: #4a9fd8;
        }

        .login-form-container h2 {
            font-size: 1.75rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 1.5rem;
            text-align: left;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #1e293b;
            font-size: 0.95rem;
        }

        .form-group input {
            width: 100%;
            padding: 0.85rem 1rem;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-size: 0.95rem;
            font-family: inherit;
            transition: all 0.3s;
            background: white;
        }

        .form-group input:focus {
            outline: none;
            border-color: #4a9fd8;
            box-shadow: 0 0 0 3px rgba(74, 159, 216, 0.1);
        }

        .password-wrapper {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #64748b;
            font-size: 1.2rem;
            padding: 0;
            margin-top: -0.5rem;
        }

        .login-submit {
            width: 100%;
            padding: 0.9rem;
            background: linear-gradient(135deg, #4a9fd8 0%, #3a8bc8 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 0.5rem;
        }

        .login-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(74, 159, 216, 0.3);
        }

        .login-footer-text {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.9rem;
            color: #64748b;
        }

        .login-footer-text a {
            color: #4a9fd8;
            font-weight: 600;
            text-decoration: none;
        }

        .login-footer-text a:hover {
            text-decoration: underline;
        }

        .alert-error {
            background: #fef2f2;
            color: #991b1b;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            border: 1px solid #fee2e2;
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
            }

            .login-left {
                min-height: 250px;
                padding: 2rem 1rem;
            }

            .login-left h1 {
                font-size: 2rem;
            }

            .login-left p {
                font-size: 0.95rem;
            }

            .login-right {
                min-height: 100vh;
                padding: 2rem 1rem;
            }

            .login-form-container {
                max-width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-left">
            <div class="login-left-content">
                <div class="login-logo">
                    <svg width="60" height="60" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M30 5C16.7 5 6 15.7 6 29s10.7 24 24 24 24-10.7 24-24-10.7-24-24-24zm0 42c-9.9 0-18-8.1-18-18s8.1-18 18-18 18 8.1 18 18-8.1 18-18 18z" fill="white"/>
                        <path d="M30 17c-6.6 0-12 5.4-12 12s5.4 12 12 12 12-5.4 12-12-5.4-12-12-12z" fill="white"/>
                    </svg>
                </div>
                <h1>GeniusPath</h1>
                <p><?php echo $is_admin ? 'Administrator Panel' : 'Kelola seluruh platform GeniusPath'; ?></p>
                
                <div class="login-illustration">
                    <svg width="150" height="150" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="100" cy="100" r="80" fill="rgba(255,255,255,0.1)"/>
                        <path d="M100 50c-27.6 0-50 22.4-50 50s22.4 50 50 50 50-22.4 50-50-22.4-50-50-50zm0 80c-16.6 0-30-13.4-30-30s13.4-30 30-30 30 13.4 30 30-13.4 30-30 30z" fill="white" opacity="0.5"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="login-right">
            <div class="login-form-container">
                <div class="login-header">
                    <h2><?php echo $is_admin ? 'Login Admin' : 'Login'; ?></h2>
                    <div class="login-tabs">
                        <a href="<?php echo home_url('/login.php'); ?>" class="login-tab <?php echo !$is_admin ? 'active' : ''; ?>">Pengguna</a>
                        <a href="<?php echo home_url('/login.php?type=admin'); ?>" class="login-tab <?php echo $is_admin ? 'active' : ''; ?>">Admin</a>
                    </div>
                </div>

                <?php if ($error): ?>
                    <div class="alert-error"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>

                <form method="POST" action="">
                    <div class="form-group">
                        <label for="email"><?php echo $is_admin ? 'Email Admin' : 'Email'; ?></label>
                        <input type="email" id="email" name="email" placeholder="Enter your email" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="password-wrapper">
                            <input type="password" id="password" name="password" placeholder="Enter your password" required>
                            <button type="button" class="password-toggle" onclick="togglePassword()">
                                <span id="password-icon">👁️</span>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="login-submit">Login</button>

                    <?php if (!$is_admin): ?>
                        <p class="login-footer-text">
                            New here? <a href="<?php echo home_url('/register.php'); ?>">Create your free account</a>
                        </p>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordField = document.getElementById('password');
            const icon = document.getElementById('password-icon');
            
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                icon.textContent = '🙈';
            } else {
                passwordField.type = 'password';
                icon.textContent = '👁️';
            }
        }
    </script>
</body>
</html>