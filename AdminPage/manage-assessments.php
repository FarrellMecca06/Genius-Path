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
$table = 'user_assessments';

if (isset($_GET['action']) && $_GET['action'] === 'delete' && !empty($_GET['id'])) {
    $id = intval($_GET['id']);
    $wpdb->delete($table, ['id' => $id]);
    wp_redirect(home_url('/wp-content/themes/Genius-Path/AdminPage/manage-assessments.php'));
    exit;
}

$assessments = $wpdb->get_results("SELECT ua.id, ua.user_id, u.full_name, ua.score, ua.completed_at FROM {$table} ua LEFT JOIN users u ON ua.user_id = u.id ORDER BY ua.completed_at DESC LIMIT 500", ARRAY_A);

get_header();
?>
<div style="max-width:960px;margin:2rem auto;padding:1rem">
    <h1>Manage Assessments</h1>
    <p><a href="<?php echo esc_url(home_url('/wp-content/themes/Genius-Path/AdminPage/')); ?>">← Back to Dashboard</a></p>
    <?php if (empty($assessments)): ?>
        <p>No assessments found.</p>
    <?php else: ?>
        <table style="width:100%;border-collapse:collapse">
            <thead>
                <tr>
                    <th style="text-align:left;padding:8px;border-bottom:1px solid #ddd">ID</th>
                    <th style="text-align:left;padding:8px;border-bottom:1px solid #ddd">User</th>
                    <th style="text-align:left;padding:8px;border-bottom:1px solid #ddd">Score</th>
                    <th style="text-align:left;padding:8px;border-bottom:1px solid #ddd">Created</th>
                    <th style="text-align:left;padding:8px;border-bottom:1px solid #ddd">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($assessments as $a): ?>
                    <tr>
                        <td style="padding:8px;border-bottom:1px solid #eee"><?php echo esc_html($a['id']); ?></td>
                        <td style="padding:8px;border-bottom:1px solid #eee"><?php echo esc_html($a['full_name'] ?: ('#'.$a['user_id'])); ?></td>
                        <td style="padding:8px;border-bottom:1px solid #eee"><?php echo esc_html($a['score']); ?></td>
                        <td style="padding:8px;border-bottom:1px solid #eee"><?php echo esc_html($a['completed_at']); ?></td>
                        <td style="padding:8px;border-bottom:1px solid #eee">
                            <a href="<?php echo esc_url(add_query_arg(['action'=>'delete','id'=>$a['id']], home_url('/wp-content/themes/Genius-Path/AdminPage/manage-assessments.php'))); ?>" onclick="return confirm('Delete assessment?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
<?php get_footer();
