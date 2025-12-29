<?php
include __DIR__ . '/config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$userProfile = false;
$careers = [];

if (isset($_SESSION['user_id'])) {
    $current_user_id = $_SESSION['user_id'];

    $stmt = $pdo->prepare("
        SELECT u.id AS user_id, u.full_name, a.interest_area, a.personality_type, a.top_skill
        FROM users u
        JOIN user_assessments a ON a.user_id = u.id
        WHERE u.id = ? 
        ORDER BY a.id DESC
        LIMIT 1
    ");
    $stmt->execute([$current_user_id]);
    $userProfile = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($userProfile) {
    $specific_job = trim($userProfile['top_skill']); 
    $category = $userProfile['interest_area'];

    $stmtCareers = $pdo->prepare("SELECT * FROM career_paths WHERE title = ? AND category = ? LIMIT 1");
    $stmtCareers->execute([$specific_job, $category]);
    $careers = $stmtCareers->fetchAll(PDO::FETCH_ASSOC);
}

include __DIR__ . '/header.php';
?>

<main class="page narrow">
    <section class="page-header">
        <h1>Your Career Recommendation</h1>
        <?php if ($userProfile): ?>
            <p>
                Hello <strong><?php echo htmlspecialchars($userProfile['full_name']); ?></strong>, 
                based on your <strong><?php echo htmlspecialchars($userProfile['interest_area']); ?></strong> assessment results, 
                here is the profession that best aligns with your specific interests:
            </p>
        <?php else: ?>
            <p>Profile not found. Please complete the <a href="<?php echo home_url('/self_discovery.php'); ?>">Self Discovery</a> assessment first.</p>
        <?php endif; ?>
    </section>

    <?php if ($careers): ?>
        <section class="cards-grid" style="grid-template-columns: 1fr; max-width: 600px; margin: 0 auto;">
            <?php foreach ($careers as $career): ?>
                <article class="card card-career" style="border: 2px solid #2545f5; padding: 2rem; border-radius: 12px; background: #fff; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);">
                    <div class="card-badge" style="background: #2545f5; color: white; padding: 4px 12px; border-radius: 9999px; font-size: 0.8rem; display: inline-block;">
                        <?php echo htmlspecialchars($career['category']); ?>
                    </div>
                    
                    <h2 style="margin-top: 1rem; color: #1e293b; font-size: 1.8rem;"><?php echo htmlspecialchars($career['title']); ?></h2>
                    <p style="font-size: 1.1rem; line-height: 1.6; color: #475569; margin: 1rem 0;">
                        <?php echo nl2br(htmlspecialchars($career['description'])); ?>
                    </p>
                    
                    <div style="background: #f8fafc; padding: 1.5rem; border-radius: 8px; margin: 1.5rem 0; border-left: 4px solid #2545f5;">
                        <h4 style="margin-bottom: 0.5rem; color: #2545f5; font-weight: 700;">Required Skills:</h4>
                        <p style="color: #334155;"><?php echo nl2br(htmlspecialchars($career['required_skills'])); ?></p>
                    </div>
                    
                    <div class="career-meta" style="display: flex; flex-direction: column; gap: 0.75rem; font-size: 0.95rem; border-top: 1px solid #e2e8f0; pt: 1rem;">
                        <span><strong>Education Path:</strong> <?php echo htmlspecialchars($career['education_path']); ?></span>
                        <span><strong>Estimated Salary:</strong> <?php echo htmlspecialchars($career['salary_range']); ?></span>
                        <span><strong>Job Outlook:</strong> <?php echo htmlspecialchars($career['outlook']); ?></span>
                    </div>
                    
                    <button class="btn-primary full-width" style="margin-top: 2rem; padding: 12px; font-weight: 600;">Explore Full Roadmap</button>
                </article>
            <?php endforeach; ?>
        </section>
    <?php elseif ($userProfile): ?>
        <div class="alert-error" style="text-align: center; padding: 3rem; background: #fef2f2; border: 1px solid #fee2e2; border-radius: 8px;">
            <p style="font-size: 1.2rem; color: #991b1b;">
                We found a match for <strong>"<?php echo htmlspecialchars($userProfile['top_skill']); ?>"</strong>, 
                but specific details for this profession are not yet available in our database.
            </p>
            <p style="font-size: 0.9rem; margin-top: 1.5rem; color: #b91c1c;">
                <strong>Admin Tip:</strong> Ensure the <code>title</code> in the <code>career_paths</code> table exactly matches the name shown above (including spelling and spaces).
            </p>
        </div>
    <?php endif; ?>
</main>

<?php 
include __DIR__ . '/footer.php'; 
?>