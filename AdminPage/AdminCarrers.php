<?php
include 'admin_header.php';

$message = "";

/* Handle create / update */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id            = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $title         = trim($_POST['title'] ?? '');
    $category      = $_POST['category'] ?? 'Technology';
    $description   = trim($_POST['description'] ?? '');
    $required_skills = trim($_POST['required_skills'] ?? '');
    $education_path  = trim($_POST['education_path'] ?? '');
    $salary_range    = trim($_POST['salary_range'] ?? '');
    $outlook         = trim($_POST['outlook'] ?? '');
    $level           = $_POST['level'] ?? 'entry';
    $status          = $_POST['status'] ?? 'published';

    if ($title === '') {
        $message = "Title is required.";
    } else {
        if ($id > 0) {
            $stmt = $pdo->prepare("
                UPDATE career_paths 
                SET title=?, category=?, description=?, required_skills=?, education_path=?, salary_range=?, outlook=?, level=?, status=?
                WHERE id=?
            ");
            $stmt->execute([$title, $category, $description, $required_skills, $education_path, $salary_range, $outlook, $level, $status, $id]);
            $message = "Career updated.";
        } else {
            $stmt = $pdo->prepare("
                INSERT INTO career_paths (title, category, description, required_skills, education_path, salary_range, outlook, level, status)
                VALUES (?,?,?,?,?,?,?,?,?)
            ");
            $stmt->execute([$title, $category, $description, $required_skills, $education_path, $salary_range, $outlook, $level, $status]);
            $message = "Career created.";
        }
    }
}

/* Delete */
if (isset($_GET['delete'])) {
    $cid = (int)$_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM career_paths WHERE id = ?");
    $stmt->execute([$cid]);
    $message = "Career deleted.";
}

/* Edit mode */
$editCareer = null;
if (isset($_GET['edit'])) {
    $cid = (int)$_GET['edit'];
    $stmt = $pdo->prepare("SELECT * FROM career_paths WHERE id = ?");
    $stmt->execute([$cid]);
    $editCareer = $stmt->fetch(PDO::FETCH_ASSOC);
}

/* List careers */
$stmt = $pdo->query("SELECT * FROM career_paths ORDER BY id DESC LIMIT 50");
$careers = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="admin-topbar">
    <h1>Career Management</h1>
</div>

<?php if ($message): ?>
    <div class="alert-success"><?php echo htmlspecialchars($message); ?></div>
<?php endif; ?>

<section class="form-card" style="margin-bottom:1.5rem;">
    <h2><?php echo $editCareer ? 'Edit career' : 'Add new career'; ?></h2>
    <form method="POST" action="admin_careers.php">
        <?php if ($editCareer): ?>
            <input type="hidden" name="id" value="<?php echo (int)$editCareer['id']; ?>">
        <?php endif; ?>
        <div class="form-grid">
            <div class="form-field">
                <label>Career title</label>
                <input type="text" name="title" required
                       value="<?php echo htmlspecialchars($editCareer['title'] ?? ''); ?>">
            </div>
            <div class="form-field">
                <label>Category</label>
                <select name="category">
                    <?php
                    $cats = ['Technology','Business','Design','Social','Science'];
                    foreach ($cats as $c):
                        $sel = (isset($editCareer['category']) && $editCareer['category']===$c) ? 'selected' : '';
                    ?>
                        <option value="<?php echo $c; ?>" <?php echo $sel; ?>><?php echo $c; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-field">
                <label>Level</label>
                <select name="level">
                    <?php
                    $levels = ['entry','mid','advanced'];
                    foreach ($levels as $lv):
                        $sel = (isset($editCareer['level']) && $editCareer['level']===$lv) ? 'selected' : '';
                    ?>
                        <option value="<?php echo $lv; ?>" <?php echo $sel; ?>><?php echo $lv; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-field">
                <label>Status</label>
                <select name="status">
                    <?php
                    $sts = ['draft','published'];
                    foreach ($sts as $st):
                        $sel = (isset($editCareer['status']) && $editCareer['status']===$st) ? 'selected' : '';
                    ?>
                        <option value="<?php echo $st; ?>" <?php echo $sel; ?>><?php echo $st; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="form-field full">
            <label>Description</label>
            <textarea name="description" rows="2"><?php echo htmlspecialchars($editCareer['description'] ?? ''); ?></textarea>
        </div>

        <div class="form-field full">
            <label>Required skills</label>
            <textarea name="required_skills" rows="2"><?php echo htmlspecialchars($editCareer['required_skills'] ?? ''); ?></textarea>
        </div>

        <div class="form-grid">
            <div class="form-field">
                <label>Related education / major</label>
                <input type="text" name="education_path"
                       value="<?php echo htmlspecialchars($editCareer['education_path'] ?? ''); ?>">
            </div>
            <div class="form-field">
                <label>Salary range</label>
                <input type="text" name="salary_range"
                       value="<?php echo htmlspecialchars($editCareer['salary_range'] ?? ''); ?>">
            </div>
            <div class="form-field">
                <label>Job outlook</label>
                <input type="text" name="outlook"
                       value="<?php echo htmlspecialchars($editCareer['outlook'] ?? ''); ?>">
            </div>
        </div>

        <button type="submit" class="btn-primary">
            <?php echo $editCareer ? 'Update' : 'Save'; ?> career
        </button>
    </form>
</section>

<section class="form-card">
    <h2>Existing careers</h2>
    <div style="overflow-x:auto;">
        <table style="width:100%;border-collapse:collapse;font-size:0.82rem;">
            <thead>
            <tr style="background:#f3f4ff;">
                <th style="padding:0.4rem;text-align:left;">Title</th>
                <th style="padding:0.4rem;text-align:left;">Category</th>
                <th style="padding:0.4rem;text-align:left;">Level</th>
                <th style="padding:0.4rem;text-align:left;">Status</th>
                <th style="padding:0.4rem;text-align:left;">Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($careers as $c): ?>
                <tr style="border-bottom:1px solid #e5e7eb;">
                    <td style="padding:0.4rem;"><?php echo htmlspecialchars($c['title']); ?></td>
                    <td style="padding:0.4rem;"><?php echo htmlspecialchars($c['category']); ?></td>
                    <td style="padding:0.4rem;"><?php echo htmlspecialchars($c['level']); ?></td>
                    <td style="padding:0.4rem;"><?php echo htmlspecialchars($c['status']); ?></td>
                    <td style="padding:0.4rem;">
                        <a href="admin_careers.php?edit=<?php echo (int)$c['id']; ?>" class="btn-card" style="font-size:0.75rem;">Edit</a>
                        <a href="admin_careers.php?delete=<?php echo (int)$c['id']; ?>" class="btn-card" style="font-size:0.75rem;margin-left:0.25rem;">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>

<?php include 'admin_footer.php'; ?>
