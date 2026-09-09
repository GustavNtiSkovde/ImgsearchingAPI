const input = document.getElementById('searchInput');
const button = document.getElementById('searchSubmit');
const form = document.getElementById('searchForm');
const imageGrid = document.getElementById('imageGrid');

async function performSearch() {
    const search = encodeURIComponent(input.value.trim() || 'flower');

    try {
        const response = await fetch(`/api.php?q=${search}`);
        const data = await response.json();

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
                        <div>Location:</span> ${image.location}</div>
                        <div>Resolution:${image.imageWidth}x${image.imageHeight}</div>
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
});

form.addEventListener('submit', (event) => {
    event.preventDefault();
    performSearch();
});

input.addEventListener('input', () => {
    input.value = input.value.replace(/[^a-zA-Z0-9åäöÅÄÖ &%]/g, '');
});


