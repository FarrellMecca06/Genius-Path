<?php
require_once __DIR__ . '/../../../../wp-load.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['admin_id'])) {
    wp_redirect(home_url('/login.php?type=admin'));
    exit;
}

global $wpdb;
$table = 'users';

$action = $_GET['action'] ?? '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['create_user'])) {
        $name = sanitize_text_field($_POST['full_name'] ?? '');
        $email = sanitize_email($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        if ($name && $email && $password) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $wpdb->insert($table, [
                'full_name' => $name,
                'email' => $email,
                'password_hash' => $hash,
                'created_at' => current_time('mysql')
            ]);
        }
        wp_redirect(home_url('/wp-content/themes/Genius-Path/AdminPage/manage-users.php'));
        exit;
    }
    if (!empty($_POST['edit_user']) && !empty($_POST['id'])) {
        $id = intval($_POST['id']);
        $name = sanitize_text_field($_POST['full_name'] ?? '');
        $email = sanitize_email($_POST['email'] ?? '');
        $data = ['full_name' => $name, 'email' => $email];
        if (!empty($_POST['password'])) {
            $data['password_hash'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
        }
        $wpdb->update($table, $data, ['id' => $id]);
        wp_redirect(home_url('/wp-content/themes/Genius-Path/AdminPage/manage-users.php'));
        exit;
    }
}

if ($action === 'delete' && !empty($_GET['id'])) {
    $id = intval($_GET['id']);
    $wpdb->delete($table, ['id' => $id]);
    wp_redirect(home_url('/wp-content/themes/Genius-Path/AdminPage/manage-users.php'));
    exit;
}

$users = $wpdb->get_results("SELECT id, full_name, email, created_at FROM {$table} ORDER BY created_at DESC LIMIT 500", ARRAY_A);

get_header();
?>
<div style="max-width:960px;margin:2rem auto;padding:1rem">
    <h1>Manage Local Users</h1>
    <p><a href="<?php echo esc_url(home_url('/wp-content/themes/Genius-Path/AdminPage/')); ?>">← Back to Dashboard</a></p>

    <h2>Create User</h2>
    <form method="POST" style="margin-bottom:1rem;max-width:480px">
        <input type="text" name="full_name" placeholder="Full name" required style="width:100%;padding:.5rem;margin-bottom:.5rem">
        <input type="email" name="email" placeholder="Email" required style="width:100%;padding:.5rem;margin-bottom:.5rem">
        <input type="password" name="password" placeholder="Password" required style="width:100%;padding:.5rem;margin-bottom:.5rem">
        <button name="create_user" type="submit" style="padding:.5rem 1rem">Create</button>
    </form>

    <?php if (empty($users)): ?>
        <p>No local users found.</p>
    <?php else: ?>
        <table style="width:100%;border-collapse:collapse">
            <thead>
                <tr>
                    <th style="text-align:left;padding:8px;border-bottom:1px solid #ddd">ID</th>
                    <th style="text-align:left;padding:8px;border-bottom:1px solid #ddd">Name</th>
                    <th style="text-align:left;padding:8px;border-bottom:1px solid #ddd">Email</th>
                    <th style="text-align:left;padding:8px;border-bottom:1px solid #ddd">Created</th>
                    <th style="text-align:left;padding:8px;border-bottom:1px solid #ddd">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $u): ?>
                    <tr>
                        <td style="padding:8px;border-bottom:1px solid #eee"><?php echo esc_html($u['id']); ?></td>
                        <td style="padding:8px;border-bottom:1px solid #eee"><?php echo esc_html($u['full_name']); ?></td>
                        <td style="padding:8px;border-bottom:1px solid #eee"><?php echo esc_html($u['email']); ?></td>
                        <td style="padding:8px;border-bottom:1px solid #eee"><?php echo esc_html($u['created_at']); ?></td>
                        <td style="padding:8px;border-bottom:1px solid #eee">
                            <a href="<?php echo esc_url(add_query_arg(['action'=>'edit','id'=>$u['id']], home_url('/wp-content/themes/Genius-Path/AdminPage/manage-users.php'))); ?>">Edit</a>
                            |
                            <a href="<?php echo esc_url(add_query_arg(['action'=>'delete','id'=>$u['id']], home_url('/wp-content/themes/Genius-Path/AdminPage/manage-users.php'))); ?>" onclick="return confirm('Delete user?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <?php if ($action === 'edit' && !empty($_GET['id'])):
        $edit = $wpdb->get_row($wpdb->prepare("SELECT id, full_name, email FROM {$table} WHERE id = %d LIMIT 1", intval($_GET['id'])), ARRAY_A);
        if ($edit): ?>
            <hr>
            <h2>Edit User #<?php echo esc_html($edit['id']); ?></h2>
            <form method="POST" style="max-width:480px">
                <input type="hidden" name="id" value="<?php echo esc_attr($edit['id']); ?>">
                <input type="text" name="full_name" value="<?php echo esc_attr($edit['full_name']); ?>" required style="width:100%;padding:.5rem;margin-bottom:.5rem">
                <input type="email" name="email" value="<?php echo esc_attr($edit['email']); ?>" required style="width:100%;padding:.5rem;margin-bottom:.5rem">
                <input type="password" name="password" placeholder="Leave blank to keep current password" style="width:100%;padding:.5rem;margin-bottom:.5rem">
                <button name="edit_user" type="submit" style="padding:.5rem 1rem">Save</button>
            </form>
        <?php endif;
    endif; ?>
</div>
<?php get_footer();
