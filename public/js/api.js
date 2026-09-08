const input = document.getElementById('searchInput');
const button = document.getElementById('searchSubmit');
const gallery = document.getElementById('gallery');

button.addEventListener('click', async () => {
    const search = encodeURIComponent(input.value.trim() || 'flower');

    try {
        const response = await fetch(`/api.php?q=${search}`);
        const data = await response.json();

        if (!response.ok || data.error) {
            throw new Error(data.error || 'Request failed');
        }

        gallery.innerHTML = data.hits.map(image => `
            <img src="${image.webformatURL}" alt="${image.tags}" width="250">
        `).join('');
    } catch (error) {
        gallery.textContent = `Error loading images: ${error.message}`;
    }
});