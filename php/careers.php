<?php
include __DIR__ . '/config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$userProfile = false;
$careers = [];

// 1. Ambil data profil user yang sedang login (Assessment terbaru)
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

// 2. Query career TUNGGAL yang paling akurat sesuai hasil pembobotan
if ($userProfile) {
    $specific_job = trim($userProfile['top_skill']); // Menghilangkan spasi tak sengaja
    $category = $userProfile['interest_area'];

    // Hanya mengambil 1 data yang judulnya sama persis dengan top_skill hasil quiz
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
                Halo <strong><?php echo htmlspecialchars($userProfile['full_name']); ?></strong>, 
                berdasarkan hasil asesmen <strong><?php echo htmlspecialchars($userProfile['interest_area']); ?></strong> Anda, 
                berikut adalah profesi yang paling sesuai dengan minat spesifik Anda:
            </p>
        <?php else: ?>
            <p>Profil tidak ditemukan. Silakan kerjakan <a href="<?php echo home_url('/self_discovery.php'); ?>">Self Discovery</a> terlebih dahulu.</p>
        <?php endif; ?>
    </section>

    <?php if ($careers): ?>
        <section class="cards-grid" style="grid-template-columns: 1fr; max-width: 600px; margin: 0 auto;">
            <?php foreach ($careers as $career): ?>
                <article class="card card-career" style="border: 2px solid #2545f5;">
                    <div class="card-badge" style="background: #2545f5; color: white;"><?php echo htmlspecialchars($career['category']); ?></div>
                    <h2 style="margin-top: 1rem; color: #1e293b;"><?php echo htmlspecialchars($career['title']); ?></h2>
                    <p style="font-size: 1.1rem; line-height: 1.6;"><?php echo nl2br(htmlspecialchars($career['description'])); ?></p>
                    
                    <div style="background: #f8fafc; padding: 1rem; border-radius: 8px; margin: 1.5rem 0;">
                        <h4 style="margin-bottom: 0.5rem; color: #2545f5;">Required Skills:</h4>
                        <p><?php echo nl2br(htmlspecialchars($career['required_skills'])); ?></p>
                    </div>
                    
                    <div class="career-meta" style="display: flex; flex-direction: column; gap: 0.5rem; font-size: 0.95rem;">
                        <span><strong>Education:</strong> <?php echo htmlspecialchars($career['education_path']); ?></span>
                        <span><strong>Salary:</strong> <?php echo htmlspecialchars($career['salary_range']); ?></span>
                        <span><strong>Outlook:</strong> <?php echo htmlspecialchars($career['outlook']); ?></span>
                    </div>
                    
                    <button class="btn-primary full-width" style="margin-top: 2rem;">Explore Full Roadmap</button>
                </article>
            <?php endforeach; ?>
        </section>
    <?php elseif ($userProfile): ?>
        <div class="alert-error" style="text-align: center; padding: 2rem;">
            <p>Maaf, kami menemukan hasil <strong>"<?php echo htmlspecialchars($userProfile['top_skill']); ?>"</strong>, 
            namun data detail untuk profesi tersebut belum tersedia di database kami.</p>
            <p style="font-size: 0.9rem; margin-top: 1rem;">Admin: Pastikan <code>title</code> di tabel <code>career_paths</code> sama persis dengan nama di atas.</p>
        </div>
    <?php endif; ?>
</main>

<?php 
include __DIR__ . '/footer.php'; 
?>