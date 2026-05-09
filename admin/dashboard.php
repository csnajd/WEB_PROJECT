<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}
$page_title = 'لوحة التحكم – إدارة المناطق';
$active_page = 'admin';
include __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/db.php';

$msg = '';
if (isset($_GET['msg'])) {
    if ($_GET['msg'] == 'added') $msg = 'تمت إضافة المكان بنجاح.';
    if ($_GET['msg'] == 'updated') $msg = 'تم تحديث المكان بنجاح.';
    if ($_GET['msg'] == 'deleted') $msg = 'تم حذف المكان بنجاح.';
}

$result = mysqli_query($conn, "SELECT * FROM places ORDER BY id ASC");
?>

<style>
.admin-container { max-width: 1200px; margin: 30px auto; background: var(--surface); padding: 25px; border-radius: var(--radius-lg); border: 1px solid var(--border); }
.admin-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
.admin-table th, .admin-table td { border: 1px solid var(--border); padding: 12px; text-align: right; vertical-align: top; }
.admin-table th { background: var(--green-dark); color: white; }
.btn-sm { display: inline-block; padding: 5px 10px; margin: 2px; border-radius: 6px; text-decoration: none; font-size: 0.8rem; }
.btn-edit { background: var(--gold); color: #000; }
.btn-delete { background: #dc3545; color: white; }
.btn-add { background: var(--green-main); color: white; padding: 8px 16px; border-radius: 8px; text-decoration: none; display: inline-block; margin-bottom: 15px; }
.logout-btn { background: #6c757d; color: white; padding: 8px 16px; border-radius: 8px; text-decoration: none; float: left; }
.success-msg { background: #d4edda; color: #155724; padding: 10px; border-radius: 8px; margin-bottom: 20px; }
</style>

<div class="container pt-nav">
    <div class="admin-container">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
            <h2>إدارة المناطق والمعالم</h2>
            <a href="logout.php" class="logout-btn">تسجيل الخروج</a>
        </div>
        <div style="margin: 20px 0;">
            <a href="add_content.php" class="btn-add">إضافة مكان جديد</a>
        </div>
        <?php if ($msg): ?>
            <div class="success-msg"><?= $msg ?></div>
        <?php endif; ?>
        <table class="admin-table">
            <thead>
                <tr><th>#</th><th>الاسم</th><th>النوع</th><th>الوصف المختصر</th><th>الإجراءات</th></tr>
            </thead>
            <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['type']) ?></td>
                    <td><?= htmlspecialchars(mb_substr($row['description'], 0, 80)) ?>...</td>
                    <td>
                        <a href="update_content.php?id=<?= $row['id'] ?>" class="btn-sm btn-edit">تعديل</a>
                        <a href="delete.php?id=<?= $row['id'] ?>" class="btn-sm btn-delete" onclick="return confirm('هل أنت متأكد من الحذف؟')"> حذف</a>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>