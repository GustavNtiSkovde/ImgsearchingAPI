imageGrid.addEventListener('click', (event) => {
    if (event.target.classList.contains('tag-pill')) {
        const selectedTag = event.target.dataset.tag;
        input.value = selectedTag;
        performSearch();
    }
});