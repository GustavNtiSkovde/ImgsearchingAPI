const input = document.getElementById('searchInput');
const button = document.getElementById('searchSubmit');
const form = document.getElementById('searchForm');
const imageGrid = document.getElementById('imageGrid');
let currentPage = 1;
let currentQuery = '';

function renderCardHTML(image) {
    return `
        <div class="card-item" data-image-id="${image.ID}">
            <div class="picture-box">
                <img class="picture-box-img" src="${image.webformatURL}" alt="${image.tags}">
            </div>

            <div class="hover-dropdown-wrapper">
                <div class="hover-dropdown">
                    <div>Tags: <span class="card-tags"></span> ${image.tags}</div>
                    <div>Location: ${image.location || 'N/A'}</div>
                    <div>Resolution: ${image.imageWidth}x${image.imageHeight}</div>
                </div>
            </div>
        </div>
    `;
}

async function performSearch() {
    // URLSearchParams encodes the query when the request URL is built.
    currentQuery = input.value.trim();
    currentPage = 1; // Reset page number for a new search
    try {
        // Fetches at least 10 image objects via our helper function 
        const images = await fetchTenImages();
        // Renders each found image as a card in the grid.
        imageGrid.innerHTML = images.slice(0,10).map(renderCardHTML).join('');
    } catch (error) {
        // Displays a clear error message if the search fails.
        imageGrid.textContent = `Error loading images: ${error.message}`;
    }
}

async function loadMore() {
    try {
        const images = await fetchTenImages();
        const newCardsHTML = images.slice(0, 10).map(renderCardHTML).join('');
        imageGrid.insertAdjacentHTML('beforeend', newCardsHTML);
    }catch(error){
        imageGrid.textContent = `Error loading more images: ${error.message}`;
    }
}

async function fetchTenImages() {
    let collectedImages = [];

    while (collectedImages.length < 10) {
        const apiUrl = new URL('../api.php', import.meta.url);
        apiUrl.searchParams.set('q', currentQuery);
        apiUrl.searchParams.set('page', currentPage);

        // 2. Increment the page number for the next request 
        currentPage++;

        // 3. Fetch data from PHP
        const response = await fetch(apiUrl);
        const data = await response.json();

        if (!response.ok || data.error) {
            throw new Error(data.error || 'Request failed');
        }

        // 4. If Unsplash has no more images at all, break the loop 
        if (data.hits.length === 0) {
            break;
        }

        // 5. Add the images (which PHP has already filtered) to our list 
        collectedImages.push(...data.hits);
    }

    return collectedImages;
}



button.addEventListener('click', async () => {
    performSearch();
});

form.addEventListener('submit', (event) => {
    event.preventDefault();
    performSearch();
});

input.addEventListener('input', () => {
    input.value = input.value.replace(/[^a-zA-Z0-9åäöÅÄÖ &%]/g, '');
});

document.addEventListener('keydown', (event) => {
  // Kontrollera om tangenten som tryckts ner är 'r' eller 'R'
    if (event.key === 'r' || event.key === 'R') {
        console.log('Du tryckte på tangenten r!');
        loadMore();
        // Skriv din kod här som ska händer när man trycker på r
    }
});