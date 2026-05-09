// js/filter.js — بحث وفلتر صفحة المعرض

function escapeRegex(string) {
  return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&'); // replace special characters with the escaped version
}

const searchInput    = document.getElementById('searchInput');
const categoryFilter = document.getElementById('categoryFilter');
const cards          = document.querySelectorAll('.place-card');
const resultsCount   = document.getElementById('resultsCount');
const noResults      = document.getElementById('noResults');

function addHighlight(text, term) { // to dynamically highlight search term in results
  if (!term) return text; // no highlight if search box is empty
  const regex = new RegExp(escapeRegex(term), 'gi'); // "g" means find all occurences of the searched term (not just the first one), "i" means case-insensitive
  return text.replace(regex, '<mark>$&</mark>'); // $& represents the matched substring
}

function filterCards() {
  const term    = searchInput.value.trim().toLowerCase();
  const selType = categoryFilter.value;
  let   visible = 0; // to count number of results after searching

  cards.forEach(card => {
    const nameEl = card.querySelector('h2'); // selects <h2> element and its contents
    const descEl = card.querySelector('p');

    // إزالة هايلايت سابق
    if (nameEl) nameEl.innerHTML = nameEl.textContent; // remove any elements inside <h1> (to remove previously placed <mark> elements)
    if (descEl) descEl.innerHTML = descEl.textContent;

    const name = (card.dataset.name || '').toLowerCase();
    const desc = (card.dataset.desc || '').toLowerCase();
    const type =  card.dataset.type || '';

    const matchSearch = !term || name.includes(term) || desc.includes(term); // card matches if search box is empty or the term exists in the name/description
    const matchType   = selType === 'all' || type === selType;

    if (matchSearch && matchType) {
      card.style.display = 'block';
      visible++;
      if (nameEl && term) nameEl.innerHTML = addHighlight(nameEl.textContent, term); // searches card name for matches and highlights them
      if (descEl && term) descEl.innerHTML = addHighlight(descEl.textContent, term); // same with card description
    } else {
      card.style.display = 'none';
    }
  });

  if (resultsCount) resultsCount.textContent = `عدد النتائج: ${visible}`;
  if (noResults)    noResults.style.display  = visible === 0 ? 'block' : 'none';
}

if (searchInput)    searchInput.addEventListener('input',  filterCards); // runs when user types
if (categoryFilter) categoryFilter.addEventListener('change', filterCards); // runs when chosen option changes