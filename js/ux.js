const imgGrid = document.getElementById('imageGrid');
const searchInp = document.getElementById('searchInput');
const searchFrm = document.getElementById('searchForm');
const quickSuggestions = document.getElementById('quickSuggestions');

if (searchInp && searchFrm) {
    if (imgGrid) {
        imgGrid.addEventListener('click', (event) => {
            if (event.target.classList.contains('tag-pill')) {
                searchInp.value = event.target.dataset.tag;
                searchFrm.dispatchEvent(new Event('submit', { cancelable: true, bubbles: true }));
            }
        });
    }

    if (quickSuggestions) {
        quickSuggestions.addEventListener('click', (event) => {
            const chip = event.target.closest('.suggestion-chip');
            if (chip) {
                searchInp.value = chip.dataset.tag;
                searchFrm.dispatchEvent(new Event('submit', { cancelable: true, bubbles: true }));
            }
        });
    }
}