// js/filter.js — بحث وفلتر صفحة المعرض

const searchInput    = document.getElementById('searchInput');
const categoryFilter = document.getElementById('categoryFilter');
const cards          = document.querySelectorAll('.place-card');
const resultsCount   = document.getElementById('resultsCount');
const noResults      = document.getElementById('noResults');

function addHighlight(text, term) {
  if (!term) return text;
  const regex = new RegExp(term, 'gi');
  return text.replace(regex, '<mark>$&</mark>');
}

function filterCards() {
  const term    = searchInput.value.trim().toLowerCase();
  const selType = categoryFilter.value;
  let   visible = 0;

  cards.forEach(card => {
    const nameEl = card.querySelector('h2');
    const descEl = card.querySelector('p');

    // إزالة هايلايت سابق
    if (nameEl) nameEl.innerHTML = nameEl.textContent;
    if (descEl) descEl.innerHTML = descEl.textContent;

    const name = (card.dataset.name || '').toLowerCase();
    const desc = (card.dataset.desc || '').toLowerCase();
    const type =  card.dataset.type || '';

    const matchSearch = !term || name.includes(term) || desc.includes(term);
    const matchType   = selType === 'all' || type === selType;

    if (matchSearch && matchType) {
      card.style.display = 'block';
      visible++;
      if (nameEl && term) nameEl.innerHTML = addHighlight(nameEl.textContent, term);
      if (descEl && term) descEl.innerHTML = addHighlight(descEl.textContent, term);
    } else {
      card.style.display = 'none';
    }
  });

  if (resultsCount) resultsCount.textContent = `عدد النتائج: ${visible}`;
  if (noResults)    noResults.style.display  = visible === 0 ? 'block' : 'none';
}

// تشغيل أولي
filterCards();

if (searchInput)    searchInput.addEventListener('input',  filterCards);
if (categoryFilter) categoryFilter.addEventListener('change', filterCards);