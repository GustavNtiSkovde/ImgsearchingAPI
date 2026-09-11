let currentPage = 1;
let currentQuery = '';

const input = document.getElementById('searchInput');
const button = document.getElementById('searchSubmit');
const form = document.getElementById('searchForm');
const imageGrid = document.getElementById('imageGrid');

async function fetchTenImages() {
    let collectedImages = [];

    // Continue the loop as long as we have fewer than 10 images 
    while (collectedImages.length < 10) {
        // 1. Build URL with search query and current page number
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

async function performSearch() {
    // Gets the user's search term and encodes it safely for use in the URL parameter.
    const search = encodeURIComponent(input.value.trim() || null);
    currentQuery = search;
    currentPage = 1; // Reset page number for a new search
    try {

        // Fetches at least 10 image objects via our helper function 
        const images = await fetchTenImages();
        // Renders each found image as a card in the grid.
        imageGrid.innerHTML = images.slice(0,10).map(image => `
            <div class="card-item">
                <div class="picture-box">
                    <img class="picture-box-img" src="${image.webformatURL}" alt="${image.tags}">
                </div>

                <div class="hover-dropdown-wrapper">
                    <div class="hover-dropdown">
                        <div>Tags: <span class="card-tags"></span> ${image.tags}</div>
                        <div>Location:</span> ${image.location}</div>
                        <div>Resolution:${image.imageWidth}x${image.imageHeight}</div>
                    </div>
                </div>
            </div>
        `).join('');
    } catch (error) {
        // Displays a clear error message if the search fails.
        imageGrid.textContent = `Error loading images: ${error.message}`;
    }
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
