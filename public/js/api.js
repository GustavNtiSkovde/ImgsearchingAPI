//Searching using unsplash api call, this part sending in the input data into api.php where it calls the api with responding input and then returns JSON data that the js adds onto the html 

let searchTerm = '';

const input = document.getElementById('searchInput');
const form = document.getElementById('searchForm');
const imageGrid = document.getElementById('imageGrid');

async function performSearch() {
    const search = input.value.trim() || 'flower';

    try {
        const apiUrl = new URL('../api.php', import.meta.url);
        apiUrl.searchParams.set('q', search);
        const response = await fetch(apiUrl);
        const responseText = await response.text();
        let data;

        try {
            data = JSON.parse(responseText);
        } catch {
            throw new Error(`Server returned invalid JSON (${response.status})`);
        }

        if (!response.ok || data.error) {
            throw new Error(data.error || 'Request failed');
        }

        imageGrid.innerHTML = data.hits.map(image => `
            <div class="card-item">
                <div class="picture-box">
                    <img class="picture-box-img" src="${image.webformatURL}" alt="${image.tags}">
                </div>

                <div class="hover-dropdown-wrapper">
                    <div class="hover-dropdown">
                        <div>Tags: <span class="card-tags"></span> ${image.tags}</div>
                        <div>Views: <span class="card-views">0</span> ${image.views}</div>
                        <div>Resolution: <span class="card-res">0x0</span> ${image.imageWidth}x${image.imageHeight}</div>
                    </div>
                </div>
            </div>
        `).join('');
    } catch (error) {
        imageGrid.textContent = `Error loading images: ${error.message}`;
    }
}


button.addEventListener('click', async () => {
    performSearch();
}

form.addEventListener('submit', (event) => {
    event.preventDefault();
    performSearch();
});

