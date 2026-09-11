
let currentPage = 1;
let currentQuery = '';

const input = document.getElementById('searchInput');
const button = document.getElementById('searchSubmit');
const form = document.getElementById('searchForm');
const imageGrid = document.getElementById('imageGrid');

async function fetchTenImages() {
    let collectedImages = [];

    // Fortsätt loopen så länge vi har färre än 10 bilder 📦
    while (collectedImages.length < 10) {
        // 1. Bygg URL med sökord och nuvarande sidnummer
        const apiUrl = new URL('../api.php', import.meta.url);
        apiUrl.searchParams.set('q', currentQuery);
        apiUrl.searchParams.set('page', currentPage);

        // 2. Höj sidnumret till nästa anrop 📄
        currentPage++;

        // 3. Hämta datan från PHP
        const response = await fetch(apiUrl);
        const data = await response.json();

        if (!response.ok || data.error) {
            throw new Error(data.error || 'Request failed');
        }

        // 4. Om Unsplash inte har fler bilder alls, bryt loopen 
        if (data.hits.length === 0) {
            break;
        }

        // 5. Lägg till bilderna (som PHP redan filtrerat) i vår lista 
        collectedImages.push(...data.hits);
    }

    return collectedImages;
}

async function performSearch() {
    // Hämtar användarens sökterm och säkrar den för att användas i URL-parametern.
    const search = encodeURIComponent(input.value.trim() || null);
    currentQuery = search;
    currentPage = 1; // Återställ sidnumret för en ny sökning
    try {

        //Hämtar minst 10 bildobjekt via vår hjälpfunktion 
        const images = await fetchTenImages();
        // Renderar varje hittad bild som ett kort i gridet.
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
        // Visar ett tydligt felmeddelande om sökningen misslyckas.
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


