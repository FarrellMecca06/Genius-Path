<?php
include __DIR__ . '/config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Proteksi login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// 1. Ambil data nama pengguna
$stmtUser = $pdo->prepare("SELECT full_name FROM users WHERE id = ?");
$stmtUser->execute([$_SESSION['user_id']]);
$user = $stmtUser->fetch();

// 2. Query data karier
try {
    $stmt = $pdo->prepare("
        SELECT 
            c.title as career_name, 
            c.description as career_desc, 
            c.required_skills as skills, 
            c.education_path as education, 
            c.salary_range as salary, 
            c.outlook as job_outlook, 
            c.category as career_cat
        FROM user_assessments ua
        JOIN career_paths c ON ua.top_skill = c.title
        WHERE ua.user_id = ?
        ORDER BY ua.id DESC LIMIT 1
    ");
    $stmt->execute([$_SESSION['user_id']]);
    $result = $stmt->fetch();
} catch (PDOException $e) {
    $result = false;
}

include __DIR__ . '/header.php';
?>

<main class="page narrow">
    <section class="page-header">
        <h1>Your Career Recommendation</h1>
        <?php if ($result): ?>
            <p>
                Hello <strong><?php echo htmlspecialchars($user['full_name']); ?></strong>, 
                based on your <strong><?php echo htmlspecialchars($result['career_cat']); ?></strong> assessment results, 
                here is the profession that best aligns with your specific interests:
            </p>
        <?php endif; ?>
    </section>

    <?php if ($result): 
        $cleanName = strtolower(str_replace([' ', '&'], ['-', 'and'], trim($result['career_name'])));
        
        $baseUrl = "/WAD-Project/wordpress/wp-content/themes/Genius-Path";
        
        $imageURL = $baseUrl . "/image/" . $cleanName . ".png";
        $fallbackURL = $baseUrl . "/image/roadmap.png";
    ?>
        <article class="card card-career" style="border: 2px solid #2545f5; padding: 2rem; border-radius: 12px; background: #fff; position: relative; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);">
            <div class="card-badge" style="background: #2545f5; color: white; padding: 4px 12px; border-radius: 9999px; font-size: 0.8rem; position: absolute; top: 20px; right: 20px;">
                <?php echo htmlspecialchars($result['career_cat']); ?>
            </div>
            
            <h2 style="margin-top: 1rem; color: #1e293b; font-size: 1.8rem;"><?php echo htmlspecialchars($result['career_name']); ?></h2>
            <p style="font-size: 1.1rem; line-height: 1.6; color: #475569; margin: 1rem 0;">
                <?php echo htmlspecialchars($result['career_desc']); ?>
            </p>
            
            <div style="background: #f8fafc; padding: 1.5rem; border-radius: 8px; margin: 1.5rem 0; border-left: 4px solid #2545f5;">
                <h4 style="margin-bottom: 0.5rem; color: #2545f5; font-weight: 700;">Required Skills:</h4>
                <p style="color: #334155;"><?php echo htmlspecialchars($result['skills']); ?></p>
            </div>
            
            <div style="display: flex; flex-direction: column; gap: 0.75rem; font-size: 0.95rem; border-top: 1px solid #e2e8f0; padding-top: 1rem; color: #1e293b;">
                <span><strong>Education Path:</strong> <?php echo htmlspecialchars($result['education']); ?></span>
                <span><strong>Estimated Salary:</strong> <?php echo htmlspecialchars($result['salary']); ?></span>
                <span><strong>Job Outlook:</strong> <?php echo htmlspecialchars($result['job_outlook']); ?></span>
            </div>

            <div style="margin-top: 2rem; text-align: center; border-top: 1px solid #f1f5f9; padding-top: 2rem;">
                <img src="<?php echo $imageURL; ?>" 
                     alt="Roadmap" 
                     style="max-width: 100%; height: auto; border-radius: 8px; border: 1px solid #eee;"
                     onerror="this.onerror=null; this.src='<?php echo $fallbackURL; ?>';">
                
                <p style="margin-top: 1rem; color: #64748b; font-size: 0.9rem; font-style: italic;">
                    Full Roadmap for <?php echo htmlspecialchars($result['career_name']); ?>
                </p>
            </div>
        </article>
    <?php else: ?>
        <div class="alert-error" style="text-align: center; padding: 3rem;">
            <p>Data rekomendasi tidak ditemukan. Silakan lakukan asesmen ulang.</p>
        </div>
    <?php endif; ?>
</main>

<?php include __DIR__ . '/footer.php'; ?>