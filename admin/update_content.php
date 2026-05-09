<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}
require_once __DIR__ . '/../includes/db.php';

$id = (int)$_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM places WHERE id = $id");
$row = mysqli_fetch_assoc($result);
if (!$row) {
    header('Location: dashboard.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $type = mysqli_real_escape_string($conn, $_POST['type']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $main_image = mysqli_real_escape_string($conn, $_POST['main_image']);
    $quick_info = mysqli_real_escape_string($conn, $_POST['quick_info']);
    $historical_info = mysqli_real_escape_string($conn, $_POST['historical_info']);
    $cultural_info = mysqli_real_escape_string($conn, $_POST['cultural_info']);
    $landmarks = mysqli_real_escape_string($conn, $_POST['landmarks']);
    $extra_image1 = mysqli_real_escape_string($conn, $_POST['extra_image1']);
    $extra_image2 = mysqli_real_escape_string($conn, $_POST['extra_image2']);
    $extra_image3 = mysqli_real_escape_string($conn, $_POST['extra_image3']);

    $query = "UPDATE places SET
              name='$name', type='$type', description='$description', main_image='$main_image', quick_info='$quick_info',
              historical_info='$historical_info', cultural_info='$cultural_info', landmarks='$landmarks',
              extra_image1='$extra_image1', extra_image2='$extra_image2', extra_image3='$extra_image3'
              WHERE id=$id";
    if (mysqli_query($conn, $query)) {
        header('Location: dashboard.php?msg=updated');
        exit();
    } else {
        $error = "خطأ: " . mysqli_error($conn);
    }
}

$page_title = 'تعديل المكان';
$active_page = 'admin';
include __DIR__ . '/../includes/header.php';
?>

<style>
.form-container { background: var(--surface); padding: 30px; border-radius: var(--radius-lg); border: 1px solid var(--border); max-width: 800px; margin: 30px auto; }
.form-group { margin-bottom: 15px; }
.form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
.form-group input, .form-group textarea { width: 100%; padding: 8px; border: 1px solid var(--border); border-radius: 6px; background: var(--bg); color: var(--text-primary); }
button { background: var(--gold); color: #000; padding: 10px 20px; border: none; border-radius: 8px; cursor: pointer; }
.error { color: red; margin-bottom: 15px; }
</style>

<div class="container pt-nav">
    <div class="form-container">
        <h2>تعديل المكان: <?= htmlspecialchars($row['name']) ?></h2>
        <?php if (isset($error)) echo "<div class='error'>$error</div>"; ?>
        <form method="post">
            <div class="form-group"><label>الاسم:</label><input type="text" name="name" value="<?= htmlspecialchars($row['name']) ?>" required></div>
            <div class="form-group"><label>النوع:</label><input type="text" name="type" value="<?= htmlspecialchars($row['type']) ?>" required></div>
            <div class="form-group"><label>الوصف:</label><textarea name="description" rows="3"><?= htmlspecialchars($row['description']) ?></textarea></div>
            <div class="form-group"><label>الصورة الرئيسية:</label><input type="text" name="main_image" value="<?= htmlspecialchars($row['main_image']) ?>"></div>
            <div class="form-group"><label>معلومات سريعة (مفصولة بفواصل):</label><textarea name="quick_info" rows="2"><?= htmlspecialchars($row['quick_info']) ?></textarea></div>
            <div class="form-group"><label>معلومات تاريخية:</label><textarea name="historical_info" rows="3"><?= htmlspecialchars($row['historical_info']) ?></textarea></div>
            <div class="form-group"><label>معلومات ثقافية:</label><textarea name="cultural_info" rows="3"><?= htmlspecialchars($row['cultural_info']) ?></textarea></div>
            <div class="form-group"><label>أبرز المعالم (مفصولة بفواصل):</label><textarea name="landmarks" rows="2"><?= htmlspecialchars($row['landmarks']) ?></textarea></div>
            <div class="form-group"><label>صورة إضافية 1:</label><input type="text" name="extra_image1" value="<?= htmlspecialchars($row['extra_image1']) ?>"></div>
            <div class="form-group"><label>صورة إضافية 2:</label><input type="text" name="extra_image2" value="<?= htmlspecialchars($row['extra_image2']) ?>"></div>
            <div class="form-group"><label>صورة إضافية 3:</label><input type="text" name="extra_image3" value="<?= htmlspecialchars($row['extra_image3']) ?>"></div>
            <button type="submit">حفظ التعديلات</button>
            <a href="/admin/dashboard.php" style="margin-right:10px;">إلغاء</a>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>