<?php
include __DIR__ . '/config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['user_id'])) {
    $stmtCheck = $pdo->prepare("SELECT id FROM user_assessments WHERE user_id = ? LIMIT 1");
    $stmtCheck->execute([$_SESSION['user_id']]);
    
    if ($stmtCheck->fetch()) {
        wp_redirect(home_url('/careers.php')); 
    } else {
        wp_redirect(home_url('/self_discovery.php'));
    }
    exit;
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '' || $password === '') {
        $error = "Please fill in both email and password.";
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

include __DIR__ . '/header.php';
?>

<main class="page narrow">
    <section class="page-header">
        <h1>Login</h1>
        <p>Sign in to see your personalised career guidance.</p>
    </section>

    <?php if ($error): ?>
        <div class="alert-error" style="background: #fef2f2; color: #991b1b; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; border: 1px solid #fee2e2;">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <form class="form-card" method="POST" action="<?php echo home_url('/login.php'); ?>">
        <h2 style="margin-bottom: 1.5rem;">Welcome back</h2>
        
        <div class="form-grid" style="display: flex; flex-direction: column; gap: 1rem;">
            <div class="form-field">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Email</label>
                <input type="email" name="email" required style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 6px;">
            </div>
            
            <div class="form-field">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Password</label>
                <input type="password" name="password" required style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 6px;">
            </div>
        </div>

        <button type="submit" class="btn-primary full-width" style="margin-top: 1.5rem; padding: 0.85rem; font-weight: 600;">
            Login
        </button>

        <p style="margin-top: 1.5rem; font-size: 0.9rem; text-align: center; color: #64748b;">
            New here? 
            <a href="<?php echo home_url('/register.php'); ?>" style="color: #2545f5; font-weight: 600; text-decoration: none;">Create your free account</a>.
        </p>
    </form>
</main>

<?php 
include __DIR__ . '/footer.php'; 
?>