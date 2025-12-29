<?php
include __DIR__ . '/config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$userProfile = false;
$careers = [];

// 1. Ambil data profil user yang sedang login dari hasil assessment terakhir
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

// 2. Query career dengan logika pembobotan (Prioritas Match Spesifik)
if ($userProfile) {
    $specific_job = $userProfile['top_skill'];
    $category = $userProfile['interest_area'];

    // Query ini mencari judul yang SAMA PERSIS dengan top_skill (hasil bobot asesmen) terlebih dahulu
    // Kemudian digabungkan dengan 1 profesi acak dari kategori yang sama agar total menjadi 2
    $stmtCareers = $pdo->prepare("
        (SELECT * FROM career_paths WHERE title = ? AND category = ? LIMIT 1)
        UNION
        (SELECT * FROM career_paths WHERE category = ? AND title <> ? ORDER BY RAND() LIMIT 1)
        LIMIT 2
    ");
    
    $stmtCareers->execute([$specific_job, $category, $category, $specific_job]);
    $careers = $stmtCareers->fetchAll(PDO::FETCH_ASSOC);
}

include __DIR__ . '/header.php';
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
            <p>No profile found yet. Please complete the <a href="<?php echo home_url('/self_discovery.php'); ?>">Self Discovery</a> first.</p>
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
                        <span><strong>Education:</strong> <?php echo htmlspecialchars($career['education_path']); ?></span>
                        <span><strong>Salary:</strong> <?php echo htmlspecialchars($career['salary_range']); ?></span>
                        <span><strong>Outlook:</strong> <?php echo htmlspecialchars($career['outlook']); ?></span>
                    </div>
                    
                    <button class="btn-card">View roadmap</button>
                </article>
            <?php endforeach; ?>
        </section>
    <?php elseif ($userProfile): ?>
        <div class="alert-error">
            <p>No career data yet in database for the <strong><?php echo htmlspecialchars($userProfile['interest_area']); ?></strong> category.</p>
            <p>Please ensure your <code>top_skill</code> in <code>user_assessments</code> matches a <code>title</code> in <code>career_paths</code>.</p>
        </div>
    <?php endif; ?>
</main>

<?php 
include __DIR__ . '/footer.php'; 
?>