<?php
include __DIR__ . '/config.php';
include __DIR__ . '/questions.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header('Location: ' . home_url('/login.php'));
    exit;
}

$user_id = $_SESSION['user_id'];
$path = $_REQUEST['path'] ?? null;
$error = "";
$success = "";

if (!$path || !array_key_exists($path, $all_path_questions)) {
    header('Location: ' . home_url('/self_discovery.php'));
    exit;
}

$questions = $all_path_questions[$path];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($pdo) || !$user_id) {
        $error = "An internal error occurred. Please ensure you are logged in.";
    } else {
        $score = 0;
        $totalQuestions = count($questions);
        
        for ($i = 1; $i <= $totalQuestions; $i++) {
            if (isset($_POST["q{$i}"]) && ($_POST["q{$i}"] === 'yes')) {
                $score++;
            }
        }

        $interest_area = $path; 
        
        $match_percentage = ($score / $totalQuestions);
        if ($match_percentage >= 0.7) {
            $personality_type = 'Strong Match (' . round($match_percentage * 100) . '%)';
        } elseif ($match_percentage >= 0.4) {
            $personality_type = 'Moderate Match (' . round($match_percentage * 100) . '%)';
        } else {
            $personality_type = 'Low Match (' . round($match_percentage * 100) . '%)';
        }
        
        $top_skill = "Assessment Score: {$score}/{$totalQuestions}";
        $career_values = "Interest determined via {$path} path assessment.";

        try {
            $stmt = $pdo->prepare("INSERT INTO user_assessments 
                (user_id, favorite_subject, interest_area, personality_type, top_skill, career_values)
                VALUES (?, ?, ?, ?, ?, ?)");
            
            $stmt->execute([
                $user_id,
                "Assessment-{$path}", 
                $interest_area,
                $personality_type,
                $top_skill,
                $career_values
            ]);

            header('Location: ' . home_url('/self_discovery.php?message=Assessment complete! Your profile has been updated. Check your career recommendations.'));
            exit;

        } catch (PDOException $e) {
            $error = "Database error occurred. Please try again. (" . $e->getCode() . ")";
        }
    }
}

include  __DIR__ . '/header.php';
?>
<main class="page narrow">
    <section class="page-header">
        <h1><?php echo htmlspecialchars($path); ?> Path Assessment</h1>
        <h1> (<?php echo count($questions); ?> Questions)</h1>
        <p>Answer Yes or No to determine your alignment with the <?php echo htmlspecialchars($path); ?> path.</p>
    </section>

    <?php if ($error): ?>
        <div class="alert-error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form class="form-card" method="POST" action="start_assessment.php">
        <input type="hidden" name="path" value="<?php echo htmlspecialchars($path); ?>">
        
        <div id="questionList" style="display: flex; flex-direction: column; gap: 1.5rem;">
            <?php foreach ($questions as $index => $qText): 
                $qNumber = $index + 1;
                $prev_answer = $_POST["q{$qNumber}"] ?? null;
            ?>
            <div class="question" style="padding-bottom: 1rem; border-bottom: 1px solid #f1f5f9;">
                <p>
                    <span style="font-weight: 700; color: #2545f5;"><?php echo $qNumber; ?>.</span> 
                    <?php echo htmlspecialchars($qText); ?>
                </p>
                <div class="question-options" style="margin-top: 0.5rem; display: flex; gap: 1.5rem;">
                    
                    <input type='radio' name='q<?php echo $qNumber; ?>' id='q<?php echo $qNumber; ?>_yes' value='yes' required 
                        <?php echo ($prev_answer === 'yes') ? 'checked' : ''; ?>> 
                    <label for='q<?php echo $qNumber; ?>_yes'>Yes</label>
                    
                    <input type='radio' name='q<?php echo $qNumber; ?>' id='q<?php echo $qNumber; ?>_no' value='no' required
                        <?php echo ($prev_answer === 'no') ? 'checked' : ''; ?>> 
                    <label for='q<?php echo $qNumber; ?>_no'>No</label>
                </div>
            </div>
            <?php endforeach; ?>
            
            <?php 
            if (empty($questions)): ?>
                <div class="alert-error">No questions found for this path.</div>
            <?php endif; ?>
        </div>  
        
        <button type="submit" class="btn-primary full-width" style="margin-top: 2rem;">
            Submit Assessment
        </button>
    </form>
</main>
<?php 
include __DIR__ . '/footer.php'; 
?>