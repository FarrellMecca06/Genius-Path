<?php
include __DIR__ . '/config.php';
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['user_id'])) { wp_redirect(home_url('/login.php')); exit; }

$user_id = $_SESSION['user_id'];
$message = "";

$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_profile'])) {
        $full_name = $_POST['full_name'];
        $edu = $_POST['education_level'];
        $major = $_POST['grade_or_major'];
        $pic_name = $user['profile_picture'];

        if (!empty($_FILES['profile_picture']['name'])) {
            $target_dir = __DIR__ . "/../image/uploads/";
            if (!file_exists($target_dir)) mkdir($target_dir, 0777, true);
            $pic_name = uniqid() . '.' . pathinfo($_FILES["profile_picture"]["name"], PATHINFO_EXTENSION);
            move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_dir . $pic_name);
            if ($user['profile_picture'] && file_exists($target_dir . $user['profile_picture'])) {
                unlink($target_dir . $user['profile_picture']);
            }
        }

        $update = $pdo->prepare("UPDATE users SET full_name=?, education_level=?, grade_or_major=?, profile_picture=? WHERE id=?");
        if ($update->execute([$full_name, $edu, $major, $pic_name, $user_id])) {
            $_SESSION['user_full_name'] = $full_name;
            header("Location: profile.php?success=1");
            exit;
        }
    }

    if (isset($_POST['delete_pic'])) {
        $target_dir = __DIR__ . "/../image/uploads/";
        if ($user['profile_picture'] && file_exists($target_dir . $user['profile_picture'])) {
            unlink($target_dir . $user['profile_picture']);
        }
        $pdo->prepare("UPDATE users SET profile_picture=NULL WHERE id=?")->execute([$user_id]);
        header("Location: profile.php");
        exit;
    }

    if (isset($_POST['delete_account'])) {
        $target_dir = __DIR__ . "/../image/uploads/";
        if ($user['profile_picture'] && file_exists($target_dir . $user['profile_picture'])) {
            unlink($target_dir . $user['profile_picture']);
        }
        $pdo->prepare("DELETE FROM users WHERE id = ?")->execute([$user_id]);
        session_destroy();
        wp_redirect(home_url());
        exit;
    }
}

include __DIR__ . '/header.php';
?>
<main class="page narrow">
    <div class="form-card">
        <h1 style="text-align: center; margin-bottom: 2rem;">My Profile</h1>
        
        <div style="text-align: center; margin-bottom: 2rem;">
            <?php 
            $img_path = $user['profile_picture'] ? get_template_directory_uri().'/../image/uploads/'.$user['profile_picture'] : get_template_directory_uri().'/../image/default-user.png';
            ?>
            <img src="<?php echo $img_path; ?>" style="width: 150px; height: 150px; border-radius: 50%; object-fit: cover; border: 4px solid var(--primary-color);">
            <?php if($user['profile_picture']): ?>
                <form method="POST" style="margin-top: 10px;">
                    <button type="submit" name="delete_pic" style="color: red; background: none; border: none; cursor: pointer; font-size: 0.8rem;">Remove Photo</button>
                </form>
            <?php endif; ?>
        </div>

        <form method="POST" enctype="multipart/form-data" class="form-grid">
            <div class="form-field">
                <label>Update Profile Picture</label>
                <input type="file" name="profile_picture" accept="image/*">
            </div>
            <div class="form-field">
                <label>Full Name</label>
                <input type="text" name="full_name" value="<?php echo htmlspecialchars($user['full_name']); ?>" required>
            </div>
            <div class="form-field">
                <label>Email (Read Only)</label>
                <input type="text" value="<?php echo htmlspecialchars($user['email']); ?>" disabled style="background: #f0f0f0;">
            </div>
            <div class="form-field">
                <label>Education Level</label>
                <select name="education_level">
                    <option value="High School" <?php echo $user['education_level'] == 'High School' ? 'selected' : ''; ?>>High School</option>
                    <option value="University" <?php echo $user['education_level'] == 'University' ? 'selected' : ''; ?>>University</option>
                </select>
            </div>
            <div class="form-field">
                <label>Grade / Major</label>
                <input type="text" name="grade_or_major" value="<?php echo htmlspecialchars($user['grade_or_major']); ?>">
            </div>
            <button type="submit" name="update_profile" class="btn-primary full-width">Save Changes</button>
        </form>

        <div style="margin-top: 3rem; padding-top: 2rem; border-top: 1px solid #eee;">
            <form method="POST" onsubmit="return confirm('Delete account permanently?');">
                <button type="submit" name="delete_account" style="background: #ef4444; color: white; border: none; padding: 0.8rem; border-radius: 0.75rem; cursor: pointer; width: 100%;">Delete My Account</button>
            </form>
        </div>
    </div>
</main>
<?php include __DIR__ . '/footer.php'; ?>