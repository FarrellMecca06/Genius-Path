<?php
include 'config.php';

// Ambil assessment terbaru (sangat sederhana)
$stmt = $pdo->query("
    SELECT u.id AS user_id, u.full_name, a.interest_area, a.personality_type, a.top_skill
    FROM users u
    JOIN user_assessments a ON a.user_id = u.id
    ORDER BY a.id DESC
    LIMIT 1
");
$userProfile = $stmt->fetch(PDO::FETCH_ASSOC);

// Query career yang match interest_area
$careers = [];
if ($userProfile) {
    $stmtCareers = $pdo->prepare("SELECT * FROM career_paths WHERE category = ? LIMIT 6");
    $stmtCareers->execute([$userProfile['interest_area']]);
    $careers = $stmtCareers->fetchAll(PDO::FETCH_ASSOC);
}

include 'header.php';
?>
<main class="page narrow">
    <section class="page-header">
        <h1>Career Recommendations</h1>
        <?php if ($userProfile): ?>
            <p>
                Based on your profile, <strong><?php echo htmlspecialchars($userProfile['full_name']); ?></strong>,
                you seem interested in <strong><?php echo htmlspecialchars($userProfile['interest_area']); ?></strong>
                with a <strong><?php echo htmlspecialchars($userProfile['personality_type']); ?></strong> personality.
            </p>
        <?php else: ?>
            <p>No profile found yet. Please complete the Self Discovery first.</p>
        <?php endif; ?>
    </section>
    <?php if ($careers): ?>
        <section class="cards-grid">
            <?php foreach ($careers as $career): ?>
                <article class="card card-career">
                    <div class="card-badge"><?php echo htmlspecialchars($career['category']); ?></div>
                    <h3><?php echo htmlspecialchars($career['title']); ?></h3>
                    <p><?php echo nl2br(htmlspecialchars($career['description'])); ?></p>
                    <h4>Required skills</h4>
                    <p><?php echo nl2br(htmlspecialchars($career['required_skills'])); ?></p>
                    <div class="career-meta">
                        <span>Education: <?php echo htmlspecialchars($career['education_path']); ?></span>
                        <span>Salary: <?php echo htmlspecialchars($career['salary_range']); ?></span>
                        <span>Outlook: <?php echo htmlspecialchars($career['outlook']); ?></span>
                    </div>
                    <button class="btn-card">View roadmap</button>
                </article>
            <?php endforeach; ?>
        </section>
    <?php elseif ($userProfile): ?>
        <p>No career data yet in database for this category. Insert some sample careers into <code>career_paths</code>
            table.</p>
    <?php endif; ?>
</main>
<?php include 'footer.php'; ?>