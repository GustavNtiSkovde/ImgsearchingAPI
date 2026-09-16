// Image grid scale slider logic
const gridScale = document.getElementById("gridScale");
const gridContainer = document.getElementById("imageGrid");

if (gridScale && gridContainer) {
  gridScale.addEventListener("input", (e) => {
    gridContainer.style.setProperty("--grid-min-size", `${e.target.value}px`);
  });
}

// Devider logic for the image grid and map panel
const mapSection = document.getElementById("mapSection");
const resizeHandle = document.getElementById("mapResizeHandle");

if (resizeHandle && mapSection) {
  let isResizing = false;
  let startX = 0;
  let startWidth = 0;

  //initialize drag state
  resizeHandle.addEventListener("pointerdown", (e) => {
    isResizing = true;
    startX = e.clientX;
    startWidth = mapSection.getBoundingClientRect().width;
    resizeHandle.setPointerCapture(e.pointerId);
    
    // Ovveride cursor when dragging
    document.body.classList.add("is-resizing");
    document.body.style.cursor = "ew-resize";
    document.body.style.userSelect = "none";
  });

  //calculate width when moving
  resizeHandle.addEventListener("pointermove", (e) => {
    if (!isResizing) return;
    const deltaX = startX - e.clientX;
    let newWidth = startWidth + deltaX;

    //Map closed if too small
    if (newWidth < 80) newWidth = 0;

    //Map cant take over entire screen, leave room for the image grid
    const maxAllowedWidth = window.innerWidth - 250;
    const clampedWidth = Math.min(newWidth, maxAllowedWidth);
    
    mapSection.style.width = `${clampedWidth}px`;

    //collapse class
    if (clampedWidth === 0) {
        mapSection.classList.add("is-collapsed");
    } else {
        mapSection.classList.remove("is-collapsed");
    }
  });

  //cleanup and reset state when done dragging
  const stopDrag = (e) => {
    if (!isResizing) return;
    isResizing = false;
    if (resizeHandle.hasPointerCapture(e.pointerId)) {
        resizeHandle.releasePointerCapture(e.pointerId);
    }
    document.body.classList.remove("is-resizing");
    document.body.style.cursor = "";
    document.body.style.userSelect = "";
  };

  resizeHandle.addEventListener("pointerup", stopDrag);
  resizeHandle.addEventListener("pointercancel", stopDrag);

  // Force the map to recalculate its size when the container is resized
  const mapObserver = new ResizeObserver(() => {
    if (window.mapInstance) {
      requestAnimationFrame(() => {
        window.mapInstance.invalidateSize();
      });
    }
  });
  mapObserver.observe(mapSection);
}

// mobile map toggle logic
const mobileMapBtn = document.getElementById("mobileMapBtn");
const closeMapBtn = document.getElementById("closeMapBtn");

if (mobileMapBtn && closeMapBtn && mapSection) {
  mobileMapBtn.addEventListener("click", () => {
    mapSection.classList.add("is-open");
  });

  closeMapBtn.addEventListener("click", () => {
    mapSection.classList.remove("is-open");
  });
}

//card dropdown logic and sticky state
document.addEventListener("click", (e) => {
  const box = e.target.closest(".picture-box");
  if (box) {
    const card = box.closest(".card-item");
    card.classList.toggle("is-locked");
    return;
  }
  //clears the locked state if clicking outside of a card
  if (!e.target.closest(".card-item")) {
    document.querySelectorAll(".card-item.is-locked").forEach((c) => c.classList.remove("is-locked"));
  }
});

//filter dropdown logic 
const filterContainer = document.getElementById('customFilterContainer');
const filterTrigger = document.getElementById('customFilterTrigger');
const filterOptions = document.querySelectorAll('.custom-filter-option');
const groupHeaders = document.querySelectorAll('.custom-filter-group-header');
const hiddenSelect = document.getElementById('imageTypeFilter');

if (filterContainer && filterTrigger) {
  
  //visually toggles the dropdown open/closed
  filterTrigger.addEventListener('click', (e) => {
    e.stopPropagation();
    filterContainer.classList.toggle('is-open');
  });

  //subgroup toggling logic for the filter dropdown
  groupHeaders.forEach(header => {
    header.addEventListener('click', (e) => {
      e.stopPropagation();
      const wrapper = header.closest('.custom-filter-group-wrapper');
      wrapper.classList.toggle('is-expanded');
    });
  });

  //sync visual selection with the hidden select input for backend 
  filterOptions.forEach(option => {
    option.addEventListener('click', (e) => {
      e.stopPropagation();
      const val = option.dataset.value;
      const text = option.innerText;
      
      // Update visual trigger label
      filterTrigger.querySelector('span').innerText = text;
      
      // Manually dispatch change event to hidden input for backend 
      if (hiddenSelect) {
        hiddenSelect.value = val;
        hiddenSelect.dispatchEvent(new Event('change'));
      }
      
      filterContainer.classList.remove('is-open');
    });
  });

  // utomatically close dropdown if clicking outside the container 
  document.addEventListener('click', (e) => {
    if (!filterContainer.contains(e.target)) {
      filterContainer.classList.remove('is-open');
    }
  });
}
// dark mode
const themeToggleBtn = document.getElementById('themeToggle');

if (themeToggleBtn) {
  //check if user has used dark before and apply it on page load
  const currentTheme = localStorage.getItem('theme');
  if (currentTheme === 'dark') {
    document.body.classList.add('dark-theme');
  }

  //swap themes on click and save choice to local storage
  themeToggleBtn.addEventListener('click', () => {
    document.body.classList.toggle('dark-theme');
    
    if (document.body.classList.contains('dark-theme')) {
      localStorage.setItem('theme', 'dark');
    } else {
      localStorage.setItem('theme', 'light');
    }
  });
}
