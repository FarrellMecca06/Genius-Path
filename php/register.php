<?php
include  __DIR__ . '/config.php';

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

if (isset($_SESSION['user_id'])) {
    wp_redirect(home_url('/self_discovery.php'));
    exit;
}

$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $full_name = trim($_POST['full_name'] ?? '');
  $email = trim($_POST['email'] ?? '');
  $password = $_POST['password'] ?? '';
  $education_level = $_POST['education_level'] ?? 'High School';
  $grade_or_major = trim($_POST['grade_or_major'] ?? '');

  if ($full_name === '' || $email === '' || $password === '') {
    $error = "Please fill in all required fields.";
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
     $error = "Invalid email format.";
  } else {
    
    $check = $pdo->prepare("SELECT id FROM users WHERE email = ? LIMIT 1");
    $check->execute([$email]);

    if ($check->fetch()) {
      $error = "This email is already registered. Please login instead.";
    } else {
      // Insert User Baru
      $password_hash = password_hash($password, PASSWORD_DEFAULT);

      $stmt = $pdo->prepare(
        "INSERT INTO users (full_name, email, password_hash, education_level, grade_or_major) VALUES (?,?,?,?,?)"
      );
      
      if ($stmt->execute([$full_name, $email, $password_hash, $education_level, $grade_or_major])) {
          
          $newUserId = $pdo->lastInsertId();
          $success = "Account created successfully! You can now login.";
          $_SESSION['user_id'] = $newUserId;
          $_SESSION['user_full_name'] = $full_name;

          wp_redirect(home_url('/self_discovery.php'));
          exit;

      } else {
          $error = "Failed to create account. Please try again.";
      }
    }
  }
}

include  __DIR__ . '/header.php';
?>
<main class="page narrow">
  <section class="page-header">
    <h1>Create your account</h1>
    <p>For high school and university students.</p>
  </section>

  <?php if ($error): ?>
    <div class="alert-error"><?php echo htmlspecialchars($error); ?></div>
  <?php endif; ?>

  <?php if ($success): ?>
    <div class="alert-success">
        <?php echo htmlspecialchars($success); ?> 
        <a href="<?php echo home_url('/login.php'); ?>" style="text-decoration: underline; font-weight: bold;">Login here</a>.
    </div>
  <?php endif; ?>

  <?php if (empty($success)): ?>
    <form class="form-card" method="POST" action="<?php echo home_url('/register.php'); ?>">
      <h2>Basic information</h2>
      <div class="form-grid">
        <div class="form-field">
          <label>Full name *</label>
          <input type="text" name="full_name" required>
        </div>
        <div class="form-field">
          <label>Email *</label>
          <input type="email" name="email" required>
        </div>
        <div class="form-field">
          <label>Password *</label>
          <input type="password" name="password" required>
        </div>
        <div class="form-field">
          <label>Education level</label>
          <select name="education_level">
            <option value="High School">High School</option>
            <option value="University">University</option>
          </select>
        </div>
        <div class="form-field">
          <label>Grade / Major</label>
          <input type="text" name="grade_or_major" placeholder="Grade 11 Science / Informatics">
        </div>
      </div>

      <button type="submit" class="btn-primary full-width">Create account</button>
      <p style="margin-top:0.75rem;font-size:0.85rem;">
        Already have an account?
        <a href="<?php echo home_url('/login.php'); ?>">Login here</a>.
      </p>
    </form>
  <?php endif; ?>
</main>
<?php 
include __DIR__ . '/footer.php'; 
?>