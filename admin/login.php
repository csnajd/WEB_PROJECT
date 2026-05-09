<?php
session_start();
require_once '../includes/db.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];
    
    $result = mysqli_query($conn, "SELECT * FROM admin WHERE username = '$username'");
    if ($row = mysqli_fetch_assoc($result)) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['admin_id'] = $row['id'];
            header('Location: dashboard.php');
            exit();
        } else {
            $error = 'كلمة المرور غير صحيحة';
        }
    } else {
        $error = 'اسم المستخدم غير موجود';
    }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تسجيل دخول المشرف</title>
    <link rel="stylesheet" href="/style.css">
    <style>
        body { display: flex; justify-content: center; align-items: center; height: 100vh; }
        .login-box { background: var(--surface); padding: 40px; border-radius: var(--radius-lg); width: 350px; text-align: center; border: 1px solid var(--border); }
        .login-box h2 { margin-bottom: 24px; color: var(--text-primary); }
        input { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid var(--border); border-radius: var(--radius-md); background: var(--bg); color: var(--text-primary); font-family: var(--font-display); font-size: 0.95rem; }
        button { background: var(--green-main); color: white; padding: 12px; border: none; width: 100%; border-radius: var(--radius-md); cursor: pointer; font-family: var(--font-display); font-size: 1rem; font-weight: 700; margin-top: 10px; }
        button:hover { background: var(--green-light); }
        .error { color: red; margin-bottom: 10px; font-family: var(--font-display); }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>تسجيل دخول المشرف</h2>
        <?php if ($error): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>
        <form method="post">
            <input type="text" name="username" placeholder="اسم المستخدم" required>
            <input type="password" name="password" placeholder="كلمة المرور" required>
            <button type="submit">دخول</button>
        </form>

        <a href="/index.php" class="btn btn-outline" style="margin-top:12px;">العودة إلى الصفحة الرئيسية</a>
    </div>
</body>
</html>