let searchTerm = '';
const input = document.querySelector('#searchInput');
const button = document.querySelector('#searchBtn');
const gallery = document.querySelector('#gallery');

async function performSearch(){
    const search = encodeURIComponent(input.value.trim() || 'flower');

    if (search === '') {
        return;
    }

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

};

input.addEventListener('keydown', (e) =>{
    if (e.key === "Enter") {
        performSearch();
    }
});

button.addEventListener('click', performSearch);

