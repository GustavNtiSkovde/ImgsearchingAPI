const input = document.getElementById('searchInput');
const button = document.getElementById('searchSubmit');
const form = document.getElementById('searchForm');
const imageGrid = document.getElementById('imageGrid');

async function performSearch() {
    const search = encodeURIComponent(input.value.trim() || null); //EncodeURI func encodes part of the address replacing special characters into UTF-8 escape characters, ?, =, / into %3F or %26

    try {
        const apiUrl = new URL('../api.php', import.meta.url);
        apiUrl.searchParams.set('q', search); //creates / updates the query in an URLs search string 
        const response = await fetch(apiUrl); // an expression that pauses an async func until server respondes with meta data
        const data = await response.json(); //Parses an HTTP response into a usable object

        if (!response.ok || data.error) {
            throw new Error(data.error || 'Request failed');
        }

        //"Print" out the html elements per img from hits
        imageGrid.innerHTML = data.hits.map(image => `
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
    } catch (error) { //Error handling if no imgs found or loadble
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
    input.value = input.value.replace(/[^a-zA-Z0-9åäöÅÄÖ &%]/g, ''); //Symboles to ignore/replace and with what 
});