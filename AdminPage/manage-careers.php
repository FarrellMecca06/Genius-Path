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
$table = 'career_paths';

$action = $_GET['action'] ?? '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['create_career'])) {
        $name = sanitize_text_field($_POST['name'] ?? '');
        $desc = sanitize_textarea_field($_POST['description'] ?? '');
        if ($name) {
            $wpdb->insert($table, ['name' => $name, 'description' => $desc, 'created_at' => current_time('mysql')]);
        }
        wp_redirect(home_url('/wp-content/themes/Genius-Path/AdminPage/manage-careers.php'));
        exit;
    }
    if (!empty($_POST['edit_career']) && !empty($_POST['id'])) {
        $id = intval($_POST['id']);
        $name = sanitize_text_field($_POST['name'] ?? '');
        $desc = sanitize_textarea_field($_POST['description'] ?? '');
        $wpdb->update($table, ['name' => $name, 'description' => $desc], ['id' => $id]);
        wp_redirect(home_url('/wp-content/themes/Genius-Path/AdminPage/manage-careers.php'));
        exit;
    }
}

if ($action === 'delete' && !empty($_GET['id'])) {
    $id = intval($_GET['id']);
    $wpdb->delete($table, ['id' => $id]);
    wp_redirect(home_url('/wp-content/themes/Genius-Path/AdminPage/manage-careers.php'));
    exit;
}

$careers = $wpdb->get_results("SELECT id, name, description, created_at FROM {$table} ORDER BY created_at DESC LIMIT 500", ARRAY_A);

get_header();
?>
<div style="max-width:960px;margin:2rem auto;padding:1rem">
    <h1>Manage Career Paths</h1>
    <p><a href="<?php echo esc_url(home_url('/wp-content/themes/Genius-Path/AdminPage/')); ?>">← Back to Dashboard</a></p>

    <h2>Create Career Path</h2>
    <form method="POST" style="margin-bottom:1rem;max-width:640px">
        <input type="text" name="name" placeholder="Career path name" required style="width:100%;padding:.5rem;margin-bottom:.5rem">
        <textarea name="description" placeholder="Short description" style="width:100%;padding:.5rem;margin-bottom:.5rem" rows="4"></textarea>
        <button name="create_career" type="submit" style="padding:.5rem 1rem">Create</button>
    </form>

    <?php if (empty($careers)): ?>
        <p>No career paths found.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($careers as $c): ?>
                <li style="margin-bottom:.5rem;padding:.5rem;border:1px solid #eee;border-radius:6px">
                    <strong><?php echo esc_html($c['name']); ?></strong>
                    <div style="font-size:.9rem;color:#666"><?php echo esc_html($c['created_at']); ?></div>
                    <div style="margin-top:.5rem"><?php echo esc_html($c['description']); ?></div>
                    <div style="margin-top:.5rem">
                        <a href="<?php echo esc_url(add_query_arg(['action'=>'edit','id'=>$c['id']], home_url('/wp-content/themes/Genius-Path/AdminPage/manage-careers.php'))); ?>">Edit</a>
                        |
                        <a href="<?php echo esc_url(add_query_arg(['action'=>'delete','id'=>$c['id']], home_url('/wp-content/themes/Genius-Path/AdminPage/manage-careers.php'))); ?>" onclick="return confirm('Delete career path?')">Delete</a>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <?php if ($action === 'edit' && !empty($_GET['id'])):
        $edit = $wpdb->get_row($wpdb->prepare("SELECT id, name, description FROM {$table} WHERE id = %d LIMIT 1", intval($_GET['id'])), ARRAY_A);
        if ($edit): ?>
            <hr>
            <h2>Edit Career #<?php echo esc_html($edit['id']); ?></h2>
            <form method="POST" style="max-width:640px">
                <input type="hidden" name="id" value="<?php echo esc_attr($edit['id']); ?>">
                <input type="text" name="name" value="<?php echo esc_attr($edit['name']); ?>" required style="width:100%;padding:.5rem;margin-bottom:.5rem">
                <textarea name="description" rows="6" style="width:100%;padding:.5rem;margin-bottom:.5rem"><?php echo esc_textarea($edit['description']); ?></textarea>
                <button name="edit_career" type="submit" style="padding:.5rem 1rem">Save</button>
            </form>
        <?php endif;
    endif; ?>
</div>
<?php get_footer();
