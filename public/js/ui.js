
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
    e.preventDefault();
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
    const newWidth = startWidth + deltaX;

    const maxAllowedWidth = window.innerWidth - 250;
    if (newWidth >= 60 && newWidth <= maxAllowedWidth) {
      mapSection.style.width = `${newWidth}px`;
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