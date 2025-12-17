<?php
// dashboard.php - Main page for viewing Self Discovery results and progress

include 'config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
// Assume full_name is stored in the session upon login
$user_name = $_SESSION['user_name'] ?? 'User'; 

$latestAssessment = null;
$error = null;

try {
    // 1. Fetch the user's latest assessment data
    $stmt = $pdo->prepare("
        SELECT 
            a.interest_area, a.personality_type, a.top_skill, a.career_values, a.favorite_subject
        FROM user_assessments a
        WHERE a.user_id = ?
        ORDER BY a.created_at DESC 
        LIMIT 1
    ");
    $stmt->execute([$user_id]);
    $latestAssessment = $stmt->fetch(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    $error = "Failed to retrieve assessment data: " . $e->getMessage();
}

// 2. Parse data for visualization
$matchPercentage = 0;
$assessmentPath = 'Not Available';
$matchType = 'N/A';
$scoreDetails = '0/0'; // Format: Score/Total

if ($latestAssessment) {
    // Get Assessment Path (e.g., Assessment-Saintek -> Saintek)
    $pathParts = explode('-', $latestAssessment['favorite_subject']);
    $assessmentPath = end($pathParts);
    
    // Get Score and Calculate Percentage from top_skill (e.g., Assessment Score: 12/15)
    if (preg_match('/(\d+)\/(\d+)/', $latestAssessment['top_skill'], $matches)) {
        if (count($matches) === 3) {
            $score = (int)$matches[1];
            $total = (int)$matches[2];
            $scoreDetails = "{$score}/{$total}";

            if ($total > 0) {
                $matchPercentage = round(($score / $total) * 100);
            }
        }
    }
    
    // Get Match Type from personality_type (e.g., Strong Match (80%) -> Strong Match)
    if (preg_match('/([a-zA-Z\s]+)/', $latestAssessment['personality_type'], $matches)) {
        $matchType = trim($matches[1]);
    }
}

include 'header.php';
?>
<main class="page">
    <section class="page-header">
        <h1>Career Readiness Dashboard</h1>
        <p>View your latest assessment results and career readiness status.</p>
    </section>

    <?php if (isset($error)): ?>
        <div class="alert-error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <?php if (!$latestAssessment): ?>
        <div class="alert-error">
            You have not completed the Self Discovery assessment. Please start the assessment
            <a href="self_discovery.php" style="font-weight: 600;">here</a>.
        </div>
    <?php else: ?>
        <div class="dashboard-grid">
            <div class="score-card">
                <h2>Profile Summary</h2>
                <div class="big-score" style="font-size: 2.2rem;"><?php echo htmlspecialchars($user_name); ?></div>
                <p class="hint">User name</p>
                
                <h3 style="margin-top: 1.5rem;">Primary Interest Path</h3>
                <div class="big-score" style="color: var(--accent-color);"><?php echo htmlspecialchars($assessmentPath); ?></div>
                <p class="hint">The path from your latest completed assessment.</p>

                <h3 style="margin-top: 1.5rem;">Personality Type / Match</h3>
                <div class="big-score" style="color: #9333ea;"><?php echo htmlspecialchars($matchType); ?></div>
                <p class="hint">Based on the match score of 'Yes' answers to the path questions.</p>
                
                <a href="self_discovery.php" class="btn-primary full-width" style="margin-top: 2rem;">Retake Assessment</a>

            </div>

            <div class="score-card">
                <h2>Path Alignment Level</h2>

                <h3>Interest Match (<?php echo $matchPercentage; ?>%)</h3>
                <div class="meter">
                    <div class="meter-fill" style="width: <?php echo $matchPercentage; ?>%;" title="<?php echo $matchPercentage; ?>% Match"></div>
                </div>
                <p class="hint">Percentage of 'Yes' answers in your <?php echo htmlspecialchars($assessmentPath); ?> assessment.</p>
                
                <h3 style="margin-top: 2rem;">Interest Consistency (Placeholder)</h3>
                <div class="meter">
                    <div class="meter-fill meter-skill" style="width: 85%;" title="85% Consistent"></div> 
                </div>
                <p class="hint">The consistency level of your interests over time (Fictional: 85%).</p>
                
                <h3 style="margin-top: 2rem;">Career Readiness (Placeholder)</h3>
                <div class="meter">
                    <div class="meter-fill meter-consistency" style="width: 70%;" title="70% Ready"></div>
                </div>
                <p class="hint">Combined score of your Interest, Academic, and Consistency scores (Fictional: 70%).</p>

                <h3 style="margin-top: 3rem; border-top: 1px solid #eef2ff; padding-top: 1.5rem;">Latest Assessment Details</h3>
                <p><strong>Assessment Path:</strong> <?php echo htmlspecialchars($assessmentPath); ?></p>
                <p><strong>'Yes' Answer Score:</strong> <?php echo $scoreDetails; ?></p>
                <p><strong>Profile Comment:</strong> <?php echo htmlspecialchars($latestAssessment['career_values']); ?></p>
                
                <a href="careers.php" class="btn-card" style="margin-top: 2rem;">View Career Recommendations</a>
            </div>
        </div>
    <?php endif; ?>
</main>
<?php include 'footer.php'; ?>