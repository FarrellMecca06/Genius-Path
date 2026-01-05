<?php
include 'AdminHeader.php';

/* 1) Total active students */
$stmt = $pdo->query("SELECT COUNT(*) AS total_students FROM users WHERE role = 'student' AND is_active = 1");
$totalStudents = $stmt->fetch(PDO::FETCH_ASSOC)['total_students'] ?? 0;

/* 2) Top interest category & stats */
$interestStats = [];
$stmt = $pdo->query("
    SELECT interest_area, COUNT(*) AS total 
    FROM user_assessments 
    GROUP BY interest_area
");
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    if ($row['interest_area']) {
        $interestStats[] = $row;
    }
}

$topCategory = "–";
$topCategoryCount = 0;
foreach ($interestStats as $row) {
    if ($row['total'] > $topCategoryCount) {
        $topCategory = $row['interest_area'];
        $topCategoryCount = $row['total'];
    }
}

/* 3) Notifications (last 5) */
$stmt = $pdo->query("SELECT * FROM notifications ORDER BY created_at DESC LIMIT 5");
$notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);

/* 4) Important activities (last 8) */
$stmt = $pdo->query("
    SELECT a.*, u.full_name 
    FROM activity_logs a
    LEFT JOIN users u ON u.id = a.user_id
    ORDER BY a.created_at DESC
    LIMIT 8
");
$activities = $stmt->fetchAll(PDO::FETCH_ASSOC);

/* Helper: max value for bar width */
$maxInterest = 0;
foreach ($interestStats as $row) {
    if ($row['total'] > $maxInterest) $maxInterest = $row['total'];
}
$maxInterest = max($maxInterest, 1);
?>
<div class="admin-topbar">
    <h1>Admin Dashboard</h1>
</div>

<section class="cards-grid" style="margin-bottom:1.5rem;">
    <article class="card card-tech">
        <div class="card-badge">Active users</div>
        <h3>Total students</h3>
        <p style="font-size:2rem;font-weight:800;"><?php echo (int)$totalStudents; ?></p>
        <p style="font-size:0.85rem;color:#4b5670;">Students with active accounts</p>
    </article>

    <article class="card card-business">
        <div class="card-badge">Interest summary</div>
        <h3>Most popular interest</h3>
        <p style="font-size:1.1rem;font-weight:700;">
            <?php echo htmlspecialchars($topCategory); ?>
        </p>
        <p style="font-size:0.85rem;color:#4b5670;">
            Total assessments: <?php echo (int)$topCategoryCount; ?>
        </p>
    </article>

    <article class="card card-progress">
        <div class="card-badge">System</div>
        <h3>Quick notes</h3>
        <ul>
            <li>Use <strong>User Management</strong> to reset passwords.</li>
            <li>Use <strong>Interest Test</strong> to update questions & options.</li>
            <li>Use <strong>Career Management</strong> to update recommended careers.</li>
        </ul>
    </article>
</section>

<section class="form-card" style="margin-bottom:1.5rem;">
    <h2>Career interest trend</h2>
    <p style="font-size:0.85rem;color:#4b5670;margin-bottom:0.7rem;">
        Distribution of interest categories based on the latest assessments.
    </p>
    <?php if ($interestStats): ?>
        <?php foreach ($interestStats as $row): 
            $width = round(($row['total'] / $maxInterest) * 100);
        ?>
            <div style="margin-bottom:0.35rem;">
                <div style="display:flex;justify-content:space-between;font-size:0.85rem;">
                    <span><?php echo htmlspecialchars($row['interest_area']); ?></span>
                    <span><?php echo (int)$row['total']; ?></span>
                </div>
                <div class="meter">
                    <div class="meter-fill" style="width: <?php echo $width; ?>%;"></div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No assessment data yet.</p>
    <?php endif; ?>
</section>

<div class="dashboard-grid">
    <section class="score-card">
        <h2>Recent notifications</h2>
        <?php if ($notifications): ?>
            <ul style="list-style:none;margin-top:0.6rem;">
                <?php foreach ($notifications as $n): ?>
                    <li style="margin-bottom:0.6rem;">
                        <strong>[<?php echo strtoupper($n['level']); ?>]</strong>
                        <?php echo htmlspecialchars($n['title']); ?><br>
                        <span style="font-size:0.8rem;color:#6b7280;">
                            <?php echo htmlspecialchars($n['created_at']); ?>
                        </span>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No notifications yet.</p>
        <?php endif; ?>
    </section>

    <section class="score-card">
        <h2>Recent activities</h2>
        <?php if ($activities): ?>
            <ul style="list-style:none;margin-top:0.6rem;">
                <?php foreach ($activities as $act): ?>
                    <li style="margin-bottom:0.55rem;font-size:0.85rem;">
                        <strong><?php echo htmlspecialchars($act['activity_type']); ?></strong>
                        – <?php echo htmlspecialchars($act['description']); ?><br>
                        <span style="font-size:0.78rem;color:#6b7280;">
                            <?php echo htmlspecialchars($act['created_at']); ?>
                            <?php if ($act['full_name']): ?>
                                · <?php echo htmlspecialchars($act['full_name']); ?>
                            <?php endif; ?>
                        </span>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No activity logs yet.</p>
        <?php endif; ?>
    </section>
</div>

<?php include 'admin_footer.php'; ?>