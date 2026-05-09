<?php
$page_title  = 'اكتشف السعودية — معرض المناطق';
$active_page = 'gallery';
include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/db.php';

$sql    = "SELECT * FROM places";
$result = mysqli_query($conn, $sql);
$places = [];
while ($row = mysqli_fetch_assoc($result)) {
    $places[] = $row;
}

$types = array_unique(array_column($places, 'type'));
?>

<style>
/* ══ PAGE HEADER ══════════════════════════════════════════ */
.page-header {
  padding: 48px 0 32px;
  text-align: center;
}
.page-header h1 { margin-bottom: 10px; }
.page-header p  { color: var(--text-secondary); font-size: 0.95rem; }

/* ══ FILTER BAR ═══════════════════════════════════════════ */
.filter-bar {
  display: flex;
  align-items: center;
  justify-content: space-between;
  flex-wrap: wrap;
  gap: 12px;
  padding: 16px 20px;
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: var(--radius-lg);
  margin-bottom: 28px;
}
.filter-right {
  display: flex;
  align-items: center;
  gap: 12px;
  flex-wrap: wrap;
}
.results-count {
  font-family: var(--font-display);
  font-size: 0.88rem;
  color: var(--text-muted);
  white-space: nowrap;
}

.search-wrap { position: relative; display: flex; align-items: center; }
.search-wrap input {
  width: 240px;
  padding: 10px 40px 10px 14px;
  background: var(--bg);
  border: 1.5px solid var(--border);
  border-radius: var(--radius-md);
  font-family: var(--font-display);
  font-size: 0.9rem;
  color: var(--text-primary);
  direction: rtl;
  transition: border-color var(--transition);
}
.search-wrap input:focus { outline: none; border-color: var(--green-main); }
.search-wrap input::placeholder { color: var(--text-muted); }
.search-icon {
  position: absolute;
  right: 12px;
  color: var(--text-muted);
  font-size: 0.95rem;
  pointer-events: none;
}

.filter-select {
  padding: 10px 14px;
  background: var(--bg);
  border: 1.5px solid var(--border);
  border-radius: var(--radius-md);
  font-family: var(--font-display);
  font-size: 0.9rem;
  color: var(--text-primary);
  direction: rtl;
  cursor: pointer;
  transition: border-color var(--transition);
}
.filter-select:focus { outline: none; border-color: var(--green-main); }

/* ══ GALLERY GRID ═════════════════════════════════════════ */
.gallery-grid {
  display: grid;
  grid-template-columns: repeat(3,1fr);
  gap: 24px;
  padding-bottom: 60px;
}

.place-card {
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: var(--radius-lg);
  overflow: hidden;
  cursor: pointer;
  transition: transform var(--transition), box-shadow var(--transition);
  text-decoration: none;
  color: inherit;
  display: block;
}
.place-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 16px 40px var(--shadow-lg);
}
.place-card-img-wrap { overflow: hidden; }
.place-card-img {
  width: 100%;
  aspect-ratio: 16/10;
  object-fit: cover;
  display: block;
  transition: transform 0.4s ease;
}
.place-card:hover .place-card-img { transform: scale(1.04); }

.place-card-body { padding: 18px 20px; }
.place-card-type {
  display: inline-block;
  font-family: var(--font-display);
  font-size: 0.72rem;
  font-weight: 700;
  color: var(--green-main);
  background: rgba(45,122,80,0.1);
  padding: 3px 10px;
  border-radius: 99px;
  margin-bottom: 8px;
}
.place-card h2 {
  font-size: 1.15rem;
  font-weight: 800;
  margin-bottom: 6px;
  color: var(--text-primary);
}
.place-card p {
  font-size: 0.83rem;
  color: var(--text-muted);
  line-height: 1.65;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.no-results {
  grid-column: 1 / -1;
  text-align: center;
  padding: 60px 20px;
  color: var(--text-muted);
  font-family: var(--font-display);
}
.no-results .no-icon { font-size: 2.5rem; margin-bottom: 12px; }

/* ══ RESPONSIVE ═══════════════════════════════════════════ */
@media (max-width: 900px) { .gallery-grid { grid-template-columns: repeat(2,1fr); } }
@media (max-width: 580px) {
  .gallery-grid          { grid-template-columns: 1fr; }
  .search-wrap input     { width: 100%; }
  .filter-bar            { flex-direction: column; align-items: stretch; }
  .filter-right          { flex-direction: column; }
}
</style>

<main class="pt-nav">
  <div class="container">

    <div class="page-header animate-fade-up">
      <h1>معرض المناطق</h1>
      <p>ابحث أو وصّح النتائج ثم اضغط على أي منطقة للانتقال إلى صفحة التفاصيل</p>
    </div>

    <div class="filter-bar animate-fade-up delay-1">
      <span class="results-count" id="resultsCount"></span>
      <div class="filter-right">
        <div class="search-wrap">
          <input type="text" id="searchInput" placeholder="ابحث عن منطقة أو مدينة...">
          <span class="search-icon">🔍</span>
        </div>
        <select class="filter-select" id="categoryFilter">
          <option value="all">كل المناطق</option>
          <?php foreach ($types as $type): ?>
            <option value="<?= htmlspecialchars($type) ?>"><?= htmlspecialchars($type) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>

    <div class="gallery-grid" id="galleryGrid">
      <?php foreach ($places as $i => $place): ?>
        <a
          href="/details.php?id=<?= $place['id'] ?>"
          class="place-card animate-fade-up delay-<?= min($i + 1, 6) ?>"
          data-type="<?= htmlspecialchars($place['type']) ?>"
          data-name="<?= htmlspecialchars($place['name']) ?>"
          data-desc="<?= htmlspecialchars($place['description']) ?>"
        >
          <div class="place-card-img-wrap">
            <img
              class="place-card-img"
              src="<?= htmlspecialchars($place['main_image']) ?>"
              alt="<?= htmlspecialchars($place['name']) ?>"
              loading="lazy"
            >
          </div>
          <div class="place-card-body">
            <span class="place-card-type"><?= htmlspecialchars($place['type']) ?></span>
            <h2><?= htmlspecialchars($place['name']) ?></h2>
            <p><?= htmlspecialchars($place['description']) ?></p>
          </div>
        </a>
      <?php endforeach; ?>

      <div class="no-results" id="noResults" style="display:none;">
        <div class="no-icon">🔍</div>
        <p>لا توجد نتائج مطابقة للبحث</p>
      </div>
    </div>

  </div>

  <div class="footer-simple">© اكتشف السعودية — جامعة الملك سعود</div>
</main>

<script src="/WEB_PROJECT/js/filter.js"></script>
<?php include __DIR__ . '/includes/footer.php'; ?>