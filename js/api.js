const input = document.getElementById('searchInput');
const button = document.getElementById('searchSubmit');
const form = document.getElementById('searchForm');
const imageGrid = document.getElementById('imageGrid');
let currentPage = 1;
let currentQuery = '';

function renderCardHTML(image) {
    return `
        <div class="card-item">
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
    // Dörrvakt: Om knappen redan är avstängd, stoppar vi direkt!
    if (button.disabled) return;

    // Lås knappen direkt när en ny sökning startar
    button.disabled = true;

    // Starta timern som låser upp knappen igen efter 2 sekunder
    setTimeout(() => {
        button.disabled = false;
    }, 5000);

    // 4. Hämta och koda sökordet
    const search = encodeURIComponent(input.value.trim() || null);
    currentQuery = search;
    currentPage = 1;

    try {
        const images = await fetchTenImages();
        
        // Hantera 0 resultat 🎨
        if (images.length === 0) {
            imageGrid.innerHTML = `
                <div class="no-results-container">
                    <svg class="no-results-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                    <p class="no-results-text">No images found for "${currentQuery}".</p>
                </div>
            `;
            return;
        }

        // Rita ut bilderna i galleriet 🖼️
        imageGrid.innerHTML = images.slice(0, 10).map(renderCardHTML).join('');
    } catch (error) {
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