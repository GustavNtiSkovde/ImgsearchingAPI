const input = document.getElementById('searchInput');
const button = document.getElementById('searchSubmit');
const imageGrid = document.getElementById('imageGrid');

button.addEventListener('click', async () => {
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
                        <div>Views: <span class="card-views">0</span> ${image.views}</div>
                        <div>Resolution: <span class="card-res">0x0</span> ${image.imageWidth}x${image.imageHeight}</div>
                    </div>
                </div>
            </div>
        `).join('');
    } catch (error) {
        imageGrid.textContent = `Error loading images: ${error.message}`;
    }
});