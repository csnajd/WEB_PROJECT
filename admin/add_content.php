<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}
$page_title = 'إضافة مكان جديد';
$active_page = 'admin';
include __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/db.php';

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

    $query = "INSERT INTO places (name, type, description, main_image, quick_info, historical_info, cultural_info, landmarks, extra_image1, extra_image2, extra_image3)
              VALUES ('$name', '$type', '$description', '$main_image', '$quick_info', '$historical_info', '$cultural_info', '$landmarks', '$extra_image1', '$extra_image2', '$extra_image3')";
    if (mysqli_query($conn, $query)) {
        header('Location: dashboard.php?msg=added');
        exit();
    } else {
        $error = "خطأ: " . mysqli_error($conn);
    }
}
?>

<style>
.form-container { background: var(--surface); padding: 30px; border-radius: var(--radius-lg); border: 1px solid var(--border); max-width: 800px; margin: 30px auto; }
.form-group { margin-bottom: 15px; }
.form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
.form-group input, .form-group textarea { width: 100%; padding: 8px; border: 1px solid var(--border); border-radius: 6px; background: var(--bg); color: var(--text-primary); }
button { background: var(--green-main); color: white; padding: 10px 20px; border: none; border-radius: 8px; cursor: pointer; }
.error { color: red; margin-bottom: 15px; }
</style>

<div class="container pt-nav">
    <div class="form-container">
        <h2>إضافة مكان جديد</h2>
        <?php if (isset($error)) echo "<div class='error'>$error</div>"; ?>
        <form method="post">
            <div class="form-group"><label>الاسم:</label><input type="text" name="name" required></div>
            <div class="form-group"><label>النوع (منطقة، معلم، إلخ):</label><input type="text" name="type" required></div>
            <div class="form-group"><label>الوصف:</label><textarea name="description" rows="3"></textarea></div>
            <div class="form-group"><label>الصورة الرئيسية (مسار):</label><input type="text" name="main_image" placeholder="images/example.jpg"></div>
            <div class="form-group"><label>معلومات سريعة (مفصولة بفواصل):</label><textarea name="quick_info" rows="2"></textarea></div>
            <div class="form-group"><label>معلومات تاريخية:</label><textarea name="historical_info" rows="3"></textarea></div>
            <div class="form-group"><label>معلومات ثقافية:</label><textarea name="cultural_info" rows="3"></textarea></div>
            <div class="form-group"><label>أبرز المعالم (مفصولة بفواصل):</label><textarea name="landmarks" rows="2"></textarea></div>
            <div class="form-group"><label>صورة إضافية 1:</label><input type="text" name="extra_image1"></div>
            <div class="form-group"><label>صورة إضافية 2:</label><input type="text" name="extra_image2"></div>
            <div class="form-group"><label>صورة إضافية 3:</label><input type="text" name="extra_image3"></div>
            <button type="submit">حفظ المكان</button>
            <a href="/admin/dashboard.php" style="margin-right:10px;">إلغاء</a>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>