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
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '' || $password === '') {
        $error = "Please fill in both email and password.";
    } else {
        if ($is_admin) {
            $stmt = $pdo->prepare("SELECT id, full_name, password_hash FROM admins WHERE email = ? LIMIT 1");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password_hash'])) {
                $_SESSION['admin_id'] = $user['id'];
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
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_full_name'] = $user['full_name'];

                $stmtCheck = $pdo->prepare("SELECT id FROM user_assessments WHERE user_id = ? LIMIT 1");
                $stmtCheck->execute([$user['id']]);

                if ($stmtCheck->fetch()) {
                    wp_redirect(home_url('/careers.php'));
                } else {
                    wp_redirect(home_url('/index.php'));
                }
                exit;

            } else {
                $error = "Invalid email or password.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - GeniusPath</title>
    <link rel="stylesheet" href="<?php echo home_url('/wp-content/themes/Genius-Path/php/style.css'); ?>">
    <style>
        html,
        body {
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
            background: #1C4D8D;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 1rem;
            color: white;
        }

        .login-left-content {
            text-align: center;
            margin-top: 5%;
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

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #1e293b;
        }

        .form-group input {
            width: 100%;
            padding: 0.85rem 1rem;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
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
        }

        .login-submit {
            width: 100%;
            padding: 0.9rem;
            background: linear-gradient(135deg, #4a9fd8 0%, #3a8bc8 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
        }

        .alert-error {
            background: #fef2f2;
            color: #991b1b;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            border: 1px solid #fee2e2;
        }

        @media (max-width: 1024px) {
            .login-left h1 {
                font-size: 2.5rem;
            }

            .login-left p {
                font-size: 1rem;
            }

            .login-form-container {
                max-width: 380px;
            }
        }

        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
            }

            .login-left {
                min-height: 200px;
                padding: 2rem 1rem;
            }

            .login-right {
                min-height: auto;
                padding: 2rem 1.5rem;
            }
        }

        @media (max-width: 480px) {
            .login-left {
                min-height: 180px;
                padding: 1.5rem 1rem;
            }

            .login-right {
                padding: 1.5rem 1rem;
            }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-left">
            <div class="login-left-content">
                <img src="wp-content/themes/Genius-Path/image/logo.png" style="width:672px;height: 384px;"
                    alt="GeniusPath Logo">
            </div>
        </div>

        <div class="login-right">
            <div class="login-form-container">
                <div class="login-header">
                    <h2>Login</h2>
                </div>

                <?php if ($error): ?>
                    <div class="alert-error"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>

                <form method="POST" action="">
                    <div class="form-group">
                        <label for="email"><?php echo $is_admin ? 'Email Admin' : 'Email'; ?></label>
                        <input type="email" id="email" name="email" placeholder="Enter your email" required>
                    </div>

                    <div class="form-group" Email <label for="password">Password</label>
                        <div class="password-wrapper">
                            <input type="password" id="password" name="password" placeholder="Enter your password"
                                required>
                            <button type="button" class="password-toggle" onclick="togglePassword()">
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="login-submit">Login</button>

                    <?php if (!$is_admin): ?>
                        <div style="text-align: center; margin-top: 1.5rem; color: #64748b; font-size: 0.9rem;">
                            New here? <a href="<?php echo home_url('/register.php'); ?>"
                                style="color: #4a9fd8; font-weight: 600; text-decoration: none;">Create your free
                                account</a>
                        </div>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordField = document.getElementById('password');
            const icon = document.getElementById('password-icon');
        }
    </script>
</body>

</html>