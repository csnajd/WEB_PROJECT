<?php
include __DIR__ . '/includes/db.php';

$id  = (int)($_GET['id'] ?? 0);
$sql = "SELECT * FROM places WHERE id = $id LIMIT 1";
$res = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($res);

if (!$row) {
    $page_title  = 'اكتشف السعودية — غير موجود';
    $active_page = '';
    include __DIR__ . '/includes/header.php';
    echo '<div class="container pt-nav" style="padding-top:120px;text-align:center;">
            <h2>المنطقة غير موجودة</h2>
            <a href="gallery.php" class="btn btn-primary mt-3">العودة للمعرض</a>
          </div>';
    include __DIR__ . '/includes/footer.php';
    exit;
}

$page_title  = 'اكتشف السعودية — ' . $row['name'];
$active_page = '';
include __DIR__ . '/includes/header.php';

// الصور الإضافية
$extras = array_values(array_filter([
    $row['extra_image1'],
    $row['extra_image2'],
    $row['extra_image3'],
]));

// المعالم كقائمة
$landmarks = array_filter(array_map('trim', explode('،', $row['landmarks'])));
?>

<style>
/* ══ HERO IMAGE ═══════════════════════════════════════════ */
.details-hero {
  padding-top: var(--nav-h);
  position: relative;
  height: 420px;
  overflow: hidden;
}
.details-hero img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
}
.details-hero-overlay {
  position: absolute;
  inset: 0;
  background: linear-gradient(to top, rgba(0,0,0,0.65) 0%, transparent 55%);
}
.details-hero-title {
  position: absolute;
  bottom: 32px;
  right: 40px;
  color: #fff;
}
.badge-white {
  display: inline-block;
  background: rgba(255,255,255,0.2);
  backdrop-filter: blur(6px);
  color: #fff;
  font-family: var(--font-display);
  font-size: 0.8rem;
  font-weight: 700;
  padding: 4px 14px;
  border-radius: 99px;
  margin-bottom: 10px;
}
.details-hero-title h1 {
  color: #fff;
  font-size: clamp(1.8rem, 4vw, 2.8rem);
  text-shadow: 0 2px 12px rgba(0,0,0,0.4);
}

/* ══ LAYOUT ═══════════════════════════════════════════════ */
.details-body { padding: 40px 0 60px; }
.details-grid {
  display: grid;
  grid-template-columns: 1fr 320px;
  gap: 28px;
  align-items: start;
}

/* ══ MAIN COLUMN ══════════════════════════════════════════ */
.details-main { display: flex; flex-direction: column; gap: 20px; }

.info-card {
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: var(--radius-lg);
  padding: 28px 30px;
}
.info-card h3 {
  font-size: 1.1rem;
  font-weight: 800;
  color: var(--text-primary);
  margin-bottom: 14px;
  display: flex;
  align-items: center;
  gap: 8px;
}
.info-card p {
  font-size: 0.93rem;
  color: var(--text-secondary);
  line-height: 1.9;
}

/* ══ SIDEBAR ══════════════════════════════════════════════ */
.details-sidebar { display: flex; flex-direction: column; gap: 20px; }

.quick-info-card,
.landmarks-card {
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: var(--radius-lg);
  padding: 24px;
}
.quick-info-card h4,
.landmarks-card h4 {
  font-family: var(--font-display);
  font-size: 0.95rem;
  font-weight: 800;
  margin-bottom: 16px;
  color: var(--text-primary);
}

.quick-item {
  display: flex;
  align-items: flex-start;
  gap: 10px;
  padding: 8px 0;
  border-bottom: 1px solid var(--border);
  font-family: var(--font-display);
  font-size: 0.86rem;
  color: var(--text-secondary);
}
.quick-item:last-child { border-bottom: none; }
.qi-icon { font-size: 1rem; flex-shrink: 0; margin-top: 1px; }

.landmark-item {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 9px 0;
  border-bottom: 1px solid var(--border);
  font-family: var(--font-display);
  font-size: 0.88rem;
  color: var(--text-secondary);
}
.landmark-item:last-child { border-bottom: none; }
.landmark-dot {
  width: 7px; height: 7px;
  background: var(--green-main);
  border-radius: 50%;
  flex-shrink: 0;
}

/* ══ GALLERY / SLIDER ══════════════════════════════════════ */
.gallery-section {
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: var(--radius-lg);
  padding: 28px 30px;
}
.gallery-section h3 {
  font-size: 1.1rem;
  font-weight: 800;
  margin-bottom: 18px;
  display: flex;
  align-items: center;
  gap: 8px;
}

.slider-wrap {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 14px;
}
.slider-main-img {
  width: 100%;
  max-height: 340px;
  object-fit: cover;
  border-radius: var(--radius-md);
  display: block;
}
.slider-controls {
  display: flex;
  align-items: center;
  gap: 16px;
}
.slider-btn {
  width: 40px; height: 40px;
  border-radius: 50%;
  background: var(--green-main);
  color: #fff;
  border: none;
  font-size: 1.4rem;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: background var(--transition), transform var(--transition);
  line-height: 1;
}
.slider-btn:hover { background: var(--green-light); transform: scale(1.08); }
.slider-counter {
  font-family: var(--font-display);
  font-size: 0.85rem;
  color: var(--text-muted);
  min-width: 50px;
  text-align: center;
}
.single-img { width: 100%; border-radius: var(--radius-md); display: block; }

/* ══ BACK LINK ════════════════════════════════════════════ */
.back-link {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  font-family: var(--font-display);
  font-size: 0.88rem;
  font-weight: 600;
  color: var(--text-muted);
  margin-bottom: 20px;
  transition: color var(--transition);
}
.back-link:hover { color: var(--green-main); }

/* ══ RESPONSIVE ═══════════════════════════════════════════ */
@media (max-width: 900px) {
  .details-grid    { grid-template-columns: 1fr; }
  .details-sidebar { order: -1; }
}
@media (max-width: 580px) {
  .details-hero          { height: 280px; }
  .details-hero-title    { right: 20px; bottom: 20px; }
}
</style>

<!-- HERO -->
<div class="details-hero">
  <img src="<?= htmlspecialchars($row['main_image']) ?>" alt="<?= htmlspecialchars($row['name']) ?>">
  <div class="details-hero-overlay"></div>
  <div class="details-hero-title">
    <span class="badge-white"><?= htmlspecialchars($row['type']) ?></span>
    <h1><?= htmlspecialchars($row['name']) ?></h1>
  </div>
</div>

<!-- BODY -->
<main class="details-body">
  <div class="container">

    <a href="gallery.php" class="back-link">&#8592; العودة إلى معرض المناطق</a>

    <div class="details-grid">

      <!-- العمود الرئيسي -->
      <div class="details-main">

        <div class="info-card animate-fade-up delay-1">
          <h3>🗺️ عن <?= htmlspecialchars($row['name']) ?></h3>
          <p><?= htmlspecialchars($row['description']) ?></p>
        </div>

        <div class="info-card animate-fade-up delay-2">
          <h3>📜 المعلومات التاريخية</h3>
          <p><?= htmlspecialchars($row['historical_info']) ?></p>
        </div>

        <div class="info-card animate-fade-up delay-3">
          <h3>🎭 المعلومات الثقافية</h3>
          <p><?= htmlspecialchars($row['cultural_info']) ?></p>
        </div>

        <!-- معرض الصور -->
        <?php if (!empty($extras)): ?>
          <div class="gallery-section animate-fade-up delay-4">
            <h3>🖼️ معرض الصور</h3>
            <?php if (count($extras) === 1): ?>
              <img class="single-img" src="<?= htmlspecialchars($extras[0]) ?>" alt="">
            <?php else: ?>
              <div class="slider-wrap">
                <img id="sliderImage" class="slider-main-img" src="<?= htmlspecialchars($extras[0]) ?>" alt="">
                <div class="slider-controls">
                  <button class="slider-btn" onclick="prevImage()">&#8250;</button>
                  <span class="slider-counter" id="sliderCounter">1 / <?= count($extras) ?></span>
                  <button class="slider-btn" onclick="nextImage()">&#8249;</button>
                </div>
              </div>
            <?php endif; ?>
          </div>
        <?php endif; ?>

      </div><!-- /details-main -->

      <!-- الشريط الجانبي -->
      <div class="details-sidebar">

        <div class="quick-info-card animate-fade-up delay-1">
          <h4>معلومات سريعة</h4>
          <div class="quick-item">
            <span class="qi-icon">📍</span>
            <span>الموقع: <?= htmlspecialchars($row['type']) ?></span>
          </div>
          <div class="quick-item">
            <span class="qi-icon">🚗</span>
            <span>أفضل المسارات: الأماكن السياحية والتراثية</span>
          </div>
          <div class="quick-item">
            <span class="qi-icon">📅</span>
            <span>أفضل وقت للزيارة: الربيع والشتاء</span>
          </div>
          <div class="quick-item">
            <span class="qi-icon">🍽️</span>
            <span>أشهر الأطعمة: المطاعم والمقاهي المحلية</span>
          </div>
        </div>

        <?php if (!empty($landmarks)): ?>
          <div class="landmarks-card animate-fade-up delay-2">
            <h4>أبرز المعالم</h4>
            <?php foreach ($landmarks as $lm): ?>
              <div class="landmark-item">
                <span class="landmark-dot"></span>
                <span><?= htmlspecialchars(trim($lm)) ?></span>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>

      </div><!-- /details-sidebar -->

    </div><!-- /details-grid -->
  </div>
</main>

<!-- سكريبت السلايدر -->
<?php if (count($extras) > 1): ?>
<script>
  const _images = <?= json_encode($extras) ?>;
  let _idx = 0;
  function nextImage() {
    _idx = (_idx + 1) % _images.length;
    document.getElementById('sliderImage').src = _images[_idx];
    document.getElementById('sliderCounter').textContent = (_idx + 1) + ' / ' + _images.length;
  }
  function prevImage() {
    _idx = (_idx - 1 + _images.length) % _images.length;
    document.getElementById('sliderImage').src = _images[_idx];
    document.getElementById('sliderCounter').textContent = (_idx + 1) + ' / ' + _images.length;
  }
</script>
<?php endif; ?>

<?php include __DIR__ . '/includes/footer.php'; ?>