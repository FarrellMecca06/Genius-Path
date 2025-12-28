<?php
include 'config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    wp_redirect(home_url('/login.php'));
    exit;
}

include  __DIR__ . '/header.php';
?>
<main class="page narrow">
    <section class="page-header">
        <h1>Self Discovery Assessment</h1>
        <p>Choose your starting focus to begin the personality and interest quiz.</p>
        <?php if (isset($_GET['message'])): ?>
            <div class="alert-success">
                <?php echo htmlspecialchars($_GET['message']); ?>
            </div>
        <?php endif; ?>
    </section>

    <form class="form-card" method="GET" action="<?php echo home_url('/start_assessment.php'); ?>">
        <h2>Choose Your Academic Path</h2>
        <div class="form-grid" style="grid-template-columns: 1fr;">
            <div class="form-field">
                <label>Select Main Path:</label>
                <select name="path" required>
                    <option value="" disabled selected>-- Select Path --</option>
                    <option value="Saintek">Saintek (Science & Technology)</option>
                    <option value="Soshum">Soshum (Social Sciences & Humanities)</option>
                    <option value="Bahasa">Bahasa (Language)</option>
                    <option value="Seni">Seni (Arts)</option>
                </select>
            </div>
        </div>

        <button type="submit" class="btn-primary full-width">Start Quiz</button>
        
        <p style="margin-top: 1rem; font-size: 0.9rem; color: #6b7280; text-align: center;">
            You can always retake the assessment later.
        </p>
    </form>
</main>
<?php 
include __DIR__ . '/footer.php'; 
?>