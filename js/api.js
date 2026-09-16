const input = document.getElementById('searchInput');
const button = document.getElementById('searchSubmit');
const form = document.getElementById('searchForm');
const imageGrid = document.getElementById('imageGrid');
const loadMoreBtn = document.getElementById("loadMoreBtn");
let currentPage = 1;
let currentQuery = '';
let randomMode = false;

if (loadMoreBtn) {
    loadMoreBtn.style.display = 'none';
}

function renderCardHTML(image) {
    return `
        <div class="card-item" data-image-id="${image.ID}">
            <div class="picture-box">
                <img class="picture-box-img" src="${image.webformatURL}" alt="${image.tags}">
            </div>

            <div class="hover-dropdown-wrapper">
                <div class="hover-dropdown">
                    <div>Tags: <span class="card-tags"></span> ${image.tags}</div>
                    <div>Location: <span class="card-location">${image.location || 'N/A'}</span></div>
                    <div>Resolution: ${image.imageWidth}x${image.imageHeight}</div>
                </div>
            </div>
        </div>
    `;
}

async function performSearch() {
    
    randomMode = false;

    // Guard clause: Stop execution immediately if the button is disabled
    if (button.disabled) return;

    // Disable the button immediately when a new search starts
    button.disabled = true;

    if (loadMoreBtn) {
    loadMoreBtn.style.display = 'none';
    }  

    // Start a timer to re-enable the button after 5 seconds
    setTimeout(() => {
        button.disabled = false;
    }, 5000);

    // URLSearchParams encodes the query when the request URL is built.
    currentQuery = input.value.trim();
    currentPage = 1;

    try {
        // Fetches at least 10 image objects via our helper function 
        const images = await fetchTenImages();
        
        // Handle zero results
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

        // Render each found image as a card in the grid
        imageGrid.innerHTML = images.slice(0, 10).map(renderCardHTML).join('');
        //Visa "Load More"-knappen eftersom vi har resultat!
        if (loadMoreBtn) loadMoreBtn.style.display = 'block';
    } catch (error) {
        imageGrid.textContent = `Error loading images: ${error.message}`;
    }
}

async function loadRandomImages() {
    randomMode = true;
    currentPage = 1;
    try {
        const images = await fetchTenImages(true);
        imageGrid.innerHTML = images.slice(0, 10).map(renderCardHTML).join('');
    } catch (error) {
        imageGrid.textContent = `Error loading images: ${error.message}`;
    }
}

async function loadMore() {
    try {
        const images = await fetchTenImages(randomMode);
        const newCardsHTML = images.slice(0, 10).map(renderCardHTML).join('');
        imageGrid.insertAdjacentHTML('beforeend', newCardsHTML);
    } catch(error) {
        imageGrid.textContent = `Error loading more images: ${error.message}`;
    }
}

async function fetchTenImages(random = false) {
    let collectedImages = [];

    while (collectedImages.length < 10) {
        const apiUrl = new URL('../api.php', import.meta.url);
        if (random) {
            apiUrl.searchParams.set('random', '1');
        } else {
            apiUrl.searchParams.set('q', currentQuery);
            apiUrl.searchParams.set('page', currentPage);
        }

        // Increment the page number for the next request
        currentPage++;

        // Fetch data from PHP
        const response = await fetch(apiUrl);
        const data = await response.json();

        if (!response.ok || data.error) {
            throw new Error(data.error || 'Request failed');
        }

        // If Unsplash has no more images at all, break the loop
        if (data.hits.length === 0) {
            break;
        }

        // Add the images (which PHP has already filtered) to our list
        collectedImages.push(...data.hits);
    }

    return collectedImages;
}

document.addEventListener('DOMContentLoaded', function () {
    loadRandomImages();
});

// Trigger search when the search button is clicked
button.addEventListener('click', async () => {
    performSearch();
});

// Prevent page reload on form submission and trigger search
form.addEventListener('submit', (event) => {
    event.preventDefault();
    performSearch();
});

// Sanitize search input to allow only allowed characters in real time
input.addEventListener('input', () => {
    input.value = input.value.replace(/[^a-zA-Z0-9åäöÅÄÖ &%]/g, '');
});

// Attach event listener for loading more images if the button exists in the DOM
if (loadMoreBtn) {
    loadMoreBtn.addEventListener("click", async () => {
        const originalText = loadMoreBtn.innerText;
        
        // Ändra knappens utseende under laddning
        loadMoreBtn.innerText = "Loading...";
        loadMoreBtn.disabled = true;
        loadMoreBtn.style.opacity = "0.7";
        loadMoreBtn.style.cursor = "wait";

        try {
            // Hämta fler bilder
            await loadMore();
        } finally {
            // Återställ knappen när laddningen är klar
            loadMoreBtn.innerText = originalText;
            loadMoreBtn.disabled = false;
            loadMoreBtn.style.opacity = "1";
            loadMoreBtn.style.cursor = "pointer";
        }
    });
};