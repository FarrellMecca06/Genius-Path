<?php
include 'admin_header.php';

$isSuperAdmin = ($_SESSION['user_role'] ?? '') === 'super_admin';
$message = "";

/* Handle actions (simple version, via GET) */
if ($isSuperAdmin && isset($_GET['action'], $_GET['id'])) {
    $id     = (int)$_GET['id'];
    $action = $_GET['action'];

    if ($action === 'deactivate') {
        $stmt = $pdo->prepare("UPDATE users SET is_active = 0 WHERE id = ?");
        $stmt->execute([$id]);
        $message = "User deactivated.";
    } elseif ($action === 'activate') {
        $stmt = $pdo->prepare("UPDATE users SET is_active = 1 WHERE id = ?");
        $stmt->execute([$id]);
        $message = "User activated.";
    } elseif ($action === 'resetpw') {
        $newPassword = 'student123'; // default
        $hash = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE users SET password_hash = ? WHERE id = ?");
        $stmt->execute([$hash, $id]);
        $message = "Password reset to: {$newPassword}";
    }
}

/* Role update via POST (super admin only) */
if ($isSuperAdmin && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'], $_POST['role'])) {
    $uid  = (int)$_POST['user_id'];
    $role = $_POST['role'];
    $stmt = $pdo->prepare("UPDATE users SET role = ? WHERE id = ?");
    $stmt->execute([$role, $uid]);
    $message = "User role updated.";
}

/* Fetch all users */
$stmt = $pdo->query("SELECT id, full_name, email, education_level, grade_or_major, role, is_active, created_at FROM users ORDER BY created_at DESC");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="admin-topbar">
    <h1>User Management</h1>
</div>

<?php if ($message): ?>
    <div class="alert-success"><?php echo htmlspecialchars($message); ?></div>
<?php endif; ?>

<section class="form-card">
    <h2>All accounts</h2>
    <p style="font-size:0.85rem;color:#4b5670;margin-bottom:0.7rem;">
        View, change roles, deactivate users, and reset passwords.
    </p>

    <div style="overflow-x:auto;">
        <table style="width:100%;border-collapse:collapse;font-size:0.85rem;">
            <thead>
            <tr style="background:#f3f4ff;">
                <th style="padding:0.45rem;text-align:left;">Name</th>
                <th style="padding:0.45rem;text-align:left;">Email</th>
                <th style="padding:0.45rem;text-align:left;">Education</th>
                <th style="padding:0.45rem;text-align:left;">Role</th>
                <th style="padding:0.45rem;text-align:left;">Status</th>
                <th style="padding:0.45rem;text-align:left;">Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($users as $u): ?>
                <tr style="border-bottom:1px solid #e5e7eb;">
                    <td style="padding:0.45rem;">
                        <?php echo htmlspecialchars($u['full_name']); ?><br>
                        <span style="font-size:0.75rem;color:#6b7280;">
                            Joined: <?php echo htmlspecialchars($u['created_at']); ?>
                        </span>
                    </td>
                    <td style="padding:0.45rem;"><?php echo htmlspecialchars($u['email']); ?></td>
                    <td style="padding:0.45rem;">
                        <?php echo htmlspecialchars($u['education_level']); ?><br>
                        <span style="font-size:0.75rem;color:#6b7280;">
                            <?php echo htmlspecialchars($u['grade_or_major']); ?>
                        </span>
                    </td>
                    <td style="padding:0.45rem;">
                        <?php if ($isSuperAdmin): ?>
                            <form method="POST" action="admin_users.php" style="display:inline;">
                                <input type="hidden" name="user_id" value="<?php echo (int)$u['id']; ?>">
                                <select name="role" onchange="this.form.submit()" style="font-size:0.8rem;padding:0.2rem 0.4rem;border-radius:0.5rem;">
                                    <option value="student"        <?php if ($u['role']==='student')        echo 'selected'; ?>>student</option>
                                    <option value="super_admin"    <?php if ($u['role']==='super_admin')    echo 'selected'; ?>>super_admin</option>
                                    <option value="content_admin"  <?php if ($u['role']==='content_admin')  echo 'selected'; ?>>content_admin</option>
                                    <option value="counselor_admin"<?php if ($u['role']==='counselor_admin')echo 'selected'; ?>>counselor_admin</option>
                                </select>
                            </form>
                        <?php else: ?>
                            <?php echo htmlspecialchars($u['role']); ?>
                        <?php endif; ?>
                    </td>
                    <td style="padding:0.45rem;">
                        <?php if ($u['is_active']): ?>
                            <span style="color:#16a34a;font-weight:600;">Active</span>
                        <?php else: ?>
                            <span style="color:#b91c1c;font-weight:600;">Inactive</span>
                        <?php endif; ?>
                    </td>
                    <td style="padding:0.45rem;">
                        <?php if ($isSuperAdmin && $u['id'] != ($_SESSION['user_id'] ?? 0)): ?>
                            <?php if ($u['is_active']): ?>
                                <a href="admin_users.php?action=deactivate&id=<?php echo (int)$u['id']; ?>" class="btn-card" style="font-size:0.75rem;">Deactivate</a>
                            <?php else: ?>
                                <a href="admin_users.php?action=activate&id=<?php echo (int)$u['id']; ?>" class="btn-card" style="font-size:0.75rem;">Activate</a>
                            <?php endif; ?>
                            <a href="admin_users.php?action=resetpw&id=<?php echo (int)$u['id']; ?>" class="btn-card" style="font-size:0.75rem;margin-left:0.25rem;">Reset PW</a>
                        <?php else: ?>
                            <span style="font-size:0.75rem;color:#9ca3af;">No action</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>

<?php include 'admin_footer.php'; ?>