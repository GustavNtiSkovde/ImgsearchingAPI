function createCardElement(item, index) {
  const tagList = item.tags ? item.tags.split(",").map(t => t.trim()) : [];
  const topTags = tagList.slice(0, 3);
  const remainingTags = tagList.slice(3);

  return `
    <div class="card-item" data-id="${item.id}">
      <div class="picture-box">
        ${item.webformatURL 
          ? `<img src="${item.webformatURL}" alt="${item.tags}" />`
          : `<span class="label">Picture ${index + 1}</span>`
        }
      </div>

      <div class="hover-dropdown-wrapper">
        <div class="hover-dropdown">
          <div class="tags-container">
            ${topTags.map(tag => `<span class="tag-chip">${tag}</span>`).join("")}
          </div>

          <div class="meta-list">
            <div class="meta-row">
              <span>Views</span>
              <span>${item.views ? item.views.toLocaleString() : "X"}</span>
            </div>
            <div class="meta-row">
              <span>Media type</span>
              <span>${item.type || "JPG"}</span>
            </div>
            <div class="meta-row">
              <span>Resolution</span>
              <span>${item.imageWidth || 0} x ${item.imageHeight || 0}</span>
            </div>
            <div class="meta-row">
              <span>Published date</span>
              <span>${item.publishedDate || "August 7, 2026"}</span>
            </div>
          </div>

          <button type="button" class="details-toggle-btn">
            ${document.body.classList.contains("show-all-details") ? "Hide details" : "Show details"}
          </button>

          <div class="extra-details-block">
            ${item.isEditorsChoice ? `<span class="badge-tag">Editor's Choice</span>` : ""}
            <div><strong>${topTags.join(", ")} image. Free for use.</strong></div>

            <div class="author-info">
              <span class="author-name">${item.user || "Unknown"}</span>
              <span class="author-followers"> · ${item.userFollowers || 0} followers</span>
            </div>
            <p class="author-bio">${item.userBio || ""}</p>

            ${remainingTags.length > 0 ? `
              <div class="tags-container">
                ${remainingTags.map(tag => `<span class="tag-chip">${tag}</span>`).join("")}
              </div>
            ` : ""}

            <div class="legal-box">
              Free for use under the Pixabay Content License
            </div>
          </div>
        </div>
      </div>
    </div>
  `;
}

function renderImageGrid(items) {
  const grid = document.getElementById("imageGrid");
  if (!grid) return;

  grid.innerHTML = items.map((item, index) => createCardElement(item, index)).join("");

  if (typeof bindCardEvents === "function") {
    bindCardEvents();
  }
}