<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= htmlspecialchars($page_title ?? 'اكتشف السعودية') ?></title>
  <link rel="stylesheet" href="/saudi/style.css" />
</head>
<body>

<!-- ══ NAVBAR ══════════════════════════════════════════════ -->
<nav class="navbar" id="navbar">
  <div class="container nav-inner">

    <!-- الشعار -->
    <a href="/index.php" class="nav-logo">
      <span class="nav-logo-dot"></span>
      اكتشف السعودية
    </a>

    <!-- روابط الصفحات -->
    <ul class="nav-links">
      <li><a href="/index.php"        class="<?= ($active_page ?? '') === 'home'    ? 'active' : '' ?>">الرئيسية</a></li>
      <li><a href="/gallery.php"      class="<?= ($active_page ?? '') === 'gallery' ? 'active' : '' ?>">معرض المناطق</a></li>
      <li><a href="/admin/login.php"  class="<?= ($active_page ?? '') === 'admin'   ? 'active' : '' ?>">دخول المشرف</a></li>
    </ul>

    <!-- الأزرار -->
    <div class="nav-actions">
      <button class="night-toggle" id="nightToggle">
        <span class="toggle-icon">🌙</span>
        <span id="toggleLabel">الوضع الليلي</span>
      </button>
      <button class="nav-hamburger" id="hamburger" aria-label="القائمة">
        <span></span><span></span><span></span>
      </button>
    </div>

  </div>
</nav>

<!-- القائمة في الموبايل -->
<div class="nav-drawer" id="navDrawer">
  <a href="/index.php">🏠 الرئيسية</a>
  <a href="/gallery.php">🗺️ معرض المناطق</a>
  <a href="/admin/login.php">🔐 دخول المشرف</a>
</div>

<!-- ══ NIGHT MODE JS ════════════════════════════════════════ -->
<script>
  if (localStorage.getItem('dark_mode') === 'true') {
    document.body.classList.add('dark');
  }
  document.addEventListener('DOMContentLoaded', function () {
    const toggle    = document.getElementById('nightToggle');
    const label     = document.getElementById('toggleLabel');
    const navbar    = document.getElementById('navbar');
    const hamburger = document.getElementById('hamburger');
    const drawer    = document.getElementById('navDrawer');

    function updateToggle() {
      const isDark = document.body.classList.contains('dark');
      document.querySelector('.toggle-icon').textContent = isDark ? '☀️' : '🌙';
      label.textContent = isDark ? 'الوضع النهاري' : 'الوضع الليلي';
    }
    updateToggle();

    toggle.addEventListener('click', function () {
      document.body.classList.toggle('dark');
      localStorage.setItem('dark_mode', document.body.classList.contains('dark'));
      updateToggle();
    });

    window.addEventListener('scroll', function () {
      navbar.classList.toggle('scrolled', window.scrollY > 20);
    });

    hamburger.addEventListener('click', function () {
      drawer.classList.toggle('open');
    });

    document.addEventListener('click', function (e) {
      if (!navbar.contains(e.target) && !drawer.contains(e.target)) {
        drawer.classList.remove('open');
      }
    });
  });
</script>