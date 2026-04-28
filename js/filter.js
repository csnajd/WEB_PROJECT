// this script is for the filter & search functionality used in the gallery page
const searchInput = document.getElementById("searchInput");
const categoryFilter = document.getElementById("categoryFilter");
const cards = document.querySelectorAll(".card");
const resultsCount = document.getElementById("resultsCount");

function addHighlight(text, searchText) { // to dynamically highlight search term in results
    if (searchText === "") { // no highlight if search box is empty
        return text;
    }

    const regex = new RegExp(searchText, "gi"); // "g" means find all occurences of the searched term (not just the first one), "i" means case-insensitive
    return text.replace(regex, "<mark>$&</mark>"); // $& represents the matched substring
}

function filterCards() {
    const searchText = searchInput.value.trim().toLowerCase();
    const selectedType = categoryFilter.value;
    let visibleCount = 0; // to count number of results after searching

    cards.forEach(card => {
        const nameElement = card.querySelector("h1"); // selects <h1> element and its contents
        const descriptionElement = card.querySelector("p"); // same with <p>

        nameElement.innerHTML = nameElement.textContent; // remove any elements inside <h1> (to remove previously placed <mark> elements)
        descriptionElement.innerHTML = descriptionElement.textContent; // same thing with the <p> element

        const name = card.querySelector("h1").textContent.toLowerCase();
        const description = card.querySelector("p").textContent.toLowerCase();
        const type = card.dataset.type;
        const matchesSearch = name.includes(searchText) || description.includes(searchText); // search returns all results that mention desired term
        const matchesType = selectedType === "all" || type === selectedType;

        if (matchesSearch && matchesType) {
            card.style.display = "block";
            visibleCount++;

            nameElement.innerHTML = addHighlight(nameElement.textContent, searchText); // searches card name for matches and highlights them
            descriptionElement.innerHTML = addHighlight(descriptionElement.textContent, searchText); // same with card description
        } else {
            card.style.display = "none";
        }
    });
    resultsCount.textContent = `عدد النتائج: ${visibleCount}`;
}

searchInput.addEventListener("input", filterCards); // runs when user types
categoryFilter.addEventListener("change", filterCards); // runs when chosen option changes