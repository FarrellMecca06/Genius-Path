<?php
include 'config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
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
            // store session
            $_SESSION['user_id']        = $user['id'];
            $_SESSION['user_full_name'] = $user['full_name'];

            // go to self discovery (or wherever you prefer)
            header('Location: self_discovery.php');
            exit;
        } else {
            $error = "Invalid email or password.";
        }
    }
}

include 'header.php';
?>
<main class="page narrow">
    <section class="page-header">
        <h1>Login</h1>
        <p>Sign in to see your personalised career guidance.</p>
    </section>

    <?php if ($error): ?>
        <div class="alert-error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form class="form-card" method="POST" action="login.php">
        <h2>Welcome back</h2>
        <div class="form-grid">
            <div class="form-field">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-field">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
        </div>
        <button type="submit" class="btn-primary full-width">Login</button>
        <p style="margin-top:0.75rem;font-size:0.85rem;">
            New here?
            <a href="register.php">Create your free account</a>.
        </p>
    </form>
</main>
<?php include 'footer.php'; ?>