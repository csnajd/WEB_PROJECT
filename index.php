<?php
$page_title  = 'اكتشف السعودية — الصفحة الرئيسية';
$active_page = 'home';
include __DIR__ . '/includes/header.php';
?>

<style>
/* ══ HERO ══════════════════════════════════════════════════ */
.hero { padding: 40px 0 0; }

.hero-inner {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 20px;
  align-items: stretch;
}

.hero-text-card {
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: var(--radius-lg);
  padding: 40px 36px;
  display: flex;
  flex-direction: column;
  justify-content: center;
}
.hero-text-card h1 {
  font-size: clamp(1.6rem, 3vw, 2.2rem);
  font-weight: 900;
  margin-bottom: 14px;
  line-height: 1.3;
}
.hero-text-card p {
  font-size: 0.95rem;
  color: var(--text-secondary);
  line-height: 1.8;
  margin-bottom: 28px;
}

.hero-green-card {
  background: linear-gradient(150deg, var(--green-dark), var(--green-mid));
  border-radius: var(--radius-lg);
  padding: 40px 36px;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  text-align: center;
  min-height: 280px;
}
.hero-green-card h2 {
  color: #fff;
  font-size: 2rem;
  font-weight: 900;
  margin-bottom: 10px;
}
.hero-green-card p { color: rgba(255,255,255,0.75); font-size: 0.9rem; }

.hero-wave {
  font-size: 2.5rem;
  margin-bottom: 12px;
  display: block;
  animation: wave 2s ease-in-out infinite;
}
@keyframes wave {
  0%,100% { transform: rotate(0deg); }
  25%      { transform: rotate(20deg); }
  75%      { transform: rotate(-10deg); }
}

/* ══ FEATURES ══════════════════════════════════════════════ */
.features { margin-top: 20px; padding-bottom: 40px; }

.features-grid {
  display: grid;
  grid-template-columns: repeat(3,1fr);
  gap: 16px;
}

.feature-card {
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: var(--radius-lg);
  padding: 24px 20px;
  transition: transform var(--transition), box-shadow var(--transition);
}
.feature-card:hover { transform: translateY(-4px); box-shadow: 0 12px 32px var(--shadow-lg); }
.feature-card-icon { font-size: 1.3rem; margin-bottom: 10px; display: block; }
.feature-card h3 { font-size: 1rem; font-weight: 700; margin-bottom: 8px; }
.feature-card p  { font-size: 0.82rem; color: var(--text-muted); line-height: 1.65; }

/* ══ RESPONSIVE ════════════════════════════════════════════ */
@media (max-width: 768px) {
  .hero-inner    { grid-template-columns: 1fr; }
  .features-grid { grid-template-columns: 1fr; }
}
</style>

<main class="pt-nav">
  <div class="container">

    <!-- HERO -->
    <section class="hero">
      <div class="hero-inner">

        <div class="hero-text-card animate-fade-up">
          <h1>موقع ثقافي تفاعلي للتعريف بالمملكة</h1>
          <p>
            استكشف مناطق المملكة العربية السعودية وتعرّف على أهم
            المعالم التاريخية والثقافية. اختر منطقة من المعرض للانتقال إلى
            صفحة التفاصيل.
          </p>
          <a href="/gallery.php" class="btn btn-primary" style="align-self:flex-start;">ابدأ الاستكشاف</a>
        </div>

        <div class="hero-green-card animate-fade-up delay-2">
          <span class="hero-wave">👋</span>
          <h2>أهلاً بك</h2>
          <p>ابدأ رحلتك لاكتشاف مناطق المملكة</p>
        </div>

      </div>
    </section>

    <!-- FEATURES -->
    <section class="features">
      <div class="features-grid">

        <div class="feature-card animate-fade-up delay-1">
          <span class="feature-card-icon">⭐</span>
          <h3>الهدف</h3>
          <p>تقديم معلومات عربية موثوقة عن مناطق المملكة وأبرز الوجهات.</p>
        </div>

        <div class="feature-card animate-fade-up delay-2">
          <span class="feature-card-icon">🗺️</span>
          <h3>المناطق</h3>
          <p>معرض تفاعلي يتيح للمستخدم التنقل بين المناطق (صور + عناوين + روابط).</p>
        </div>

        <div class="feature-card animate-fade-up delay-3">
          <span class="feature-card-icon">📍</span>
          <h3>التفاصيل</h3>
          <p>صفحة تعرض وصفاً وصوراً ومعلومات تاريخية عن المكان المختار.</p>
        </div>

      </div>
    </section>

  </div>

  <div class="footer-simple">
    © اكتشف السعودية — جامعة الملك سعود
  </div>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>