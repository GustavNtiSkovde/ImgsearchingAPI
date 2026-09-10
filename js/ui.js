const gridScale = document.getElementById("gridScale");
const gridContainer = document.getElementById("imageGrid");

if (gridScale && gridContainer) {
  gridScale.addEventListener("input", (e) => {
    gridContainer.style.setProperty("--grid-min-size", `${e.target.value}px`);
  });
}

const mapSection = document.getElementById("mapSection");
const resizeHandle = document.getElementById("mapResizeHandle");

if (resizeHandle && mapSection) {
  let isResizing = false;
  let startX = 0;
  let startWidth = 0;

  resizeHandle.addEventListener("pointerdown", (e) => {
    isResizing = true;
    startX = e.clientX;
    startWidth = mapSection.getBoundingClientRect().width;
    resizeHandle.setPointerCapture(e.pointerId);
    document.body.classList.add("is-resizing");
    document.body.style.cursor = "ew-resize";
    document.body.style.userSelect = "none";
  });

  resizeHandle.addEventListener("pointermove", (e) => {
    if (!isResizing) return;
    const deltaX = startX - e.clientX;
    let newWidth = startWidth + deltaX;

    if (newWidth < 80) newWidth = 0;

    const maxAllowedWidth = window.innerWidth - 250;
    const clampedWidth = Math.min(newWidth, maxAllowedWidth);
    
    mapSection.style.width = `${clampedWidth}px`;

    if (clampedWidth === 0) {
        mapSection.classList.add("is-collapsed");
    } else {
        mapSection.classList.remove("is-collapsed");
    }
  });

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

  const mapObserver = new ResizeObserver(() => {
    if (window.mapInstance) {
      requestAnimationFrame(() => {
        window.mapInstance.invalidateSize();
      });
    }
  });
  mapObserver.observe(mapSection);
}

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

document.addEventListener("click", (e) => {
  const box = e.target.closest(".picture-box");
  if (box) {
    const card = box.closest(".card-item");
    card.classList.toggle("is-locked");
    return;
  }
  if (!e.target.closest(".card-item")) {
    document.querySelectorAll(".card-item.is-locked").forEach((c) => c.classList.remove("is-locked"));
  }
});

const filterContainer = document.getElementById('customFilterContainer');
const filterTrigger = document.getElementById('customFilterTrigger');
const filterOptions = document.querySelectorAll('.custom-filter-option');
const groupHeaders = document.querySelectorAll('.custom-filter-group-header');
const hiddenSelect = document.getElementById('imageTypeFilter');

if (filterContainer && filterTrigger) {
  filterTrigger.addEventListener('click', (e) => {
    e.stopPropagation();
    filterContainer.classList.toggle('is-open');
  });

  groupHeaders.forEach(header => {
    header.addEventListener('click', (e) => {
      e.stopPropagation();
      const wrapper = header.closest('.custom-filter-group-wrapper');
      wrapper.classList.toggle('is-expanded');
    });
  });

  filterOptions.forEach(option => {
    option.addEventListener('click', (e) => {
      e.stopPropagation();
      const val = option.dataset.value;
      const text = option.innerText;
      
      filterTrigger.querySelector('span').innerText = text;
      
      if (hiddenSelect) {
        hiddenSelect.value = val;
        hiddenSelect.dispatchEvent(new Event('change'));
      }
      
      filterContainer.classList.remove('is-open');
    });
  });

  document.addEventListener('click', (e) => {
    if (!filterContainer.contains(e.target)) {
      filterContainer.classList.remove('is-open');
    }
  });
}