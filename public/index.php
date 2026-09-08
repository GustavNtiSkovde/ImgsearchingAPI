<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Google & Pixabay Layout</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet" />
  <style>
    :root {
      --bg-main: #ffffff;
      --bg-subtle: #f8f9fa;
      --border-color: #dfe1e5;
      --text-primary: #202124;
      --text-secondary: #5f6368;
      --shadow-subtle: 0 1px 3px rgba(60, 64, 67, 0.12), 0 1px 2px rgba(60, 64, 67, 0.08);
      --shadow-dropdown: 0 4px 14px rgba(60, 64, 67, 0.18);
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: 'Roboto', -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    }

    body {
      background-color: var(--bg-main);
      color: var(--text-primary);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      padding: 16px 24px;
      gap: 16px;
    }

    .top-bar {
      display: flex;
      align-items: center;
      gap: 16px;
      width: 100%;
    }

    .search-wrapper {
      flex: 1;
      display: flex;
      align-items: center;
      background: #ffffff;
      border: 1px solid var(--border-color);
      border-radius: 24px;
      padding: 8px 16px;
      box-shadow: var(--shadow-subtle);
    }

    .search-wrapper:hover,
    .search-wrapper:focus-within {
      box-shadow: 0 1px 6px rgba(32, 33, 36, 0.28);
    }

    .search-input {
      flex: 1;
      border: none;
      outline: none;
      font-size: 15px;
      color: var(--text-primary);
      background: transparent;
    }

    .enter-btn {
      background: none;
      border: 1px solid var(--border-color);
      border-radius: 50%;
      width: 32px;
      height: 32px;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      color: var(--text-secondary);
      flex-shrink: 0;
    }

    .enter-btn:hover {
      background: var(--bg-subtle);
      color: var(--text-primary);
    }

    .enter-btn svg {
      width: 16px;
      height: 16px;
      fill: currentColor;
    }

    .filter-wrapper {
      position: relative;
    }

    .filter-select {
      background: var(--bg-subtle);
      color: var(--text-primary);
      border: 1px solid var(--border-color);
      border-radius: 18px;
      padding: 9px 18px;
      font-size: 14px;
      font-weight: 500;
      cursor: pointer;
      outline: none;
    }

    .main-content {
      display: flex;
      gap: 20px;
      flex: 1;
      min-height: 700px;
    }

    .image-grid-section {
      flex: 1;
      border: 1px solid var(--border-color);
      border-radius: 16px;
      padding: 20px;
      display: flex;
      flex-direction: column;
      gap: 16px;
      background: #ffffff;
      position: relative;
    }

    .section-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .section-title {
      font-size: 13px;
      font-weight: 500;
      text-transform: uppercase;
      letter-spacing: 0.8px;
      color: var(--text-secondary);
    }

    .search-status {
      font-size: 13px;
      color: var(--text-secondary);
      display: none;
    }

   .loading-overlay {
  display: none;
  position: absolute;
  inset: 0; 
  background: rgba(255, 255, 255, 0.88);
  border-radius: 16px;
  align-items: center;
  justify-content: center;
  font-size: 15px;
  font-weight: 500;
  color: var(--text-secondary);
  z-index: 200;
}

    .grid-container {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
      gap: 20px;
      align-items: start;
    }

    .card-item {
      position: relative;
      width: 100%;
    }

    .picture-box {
      width: 100%;
      height: 200px;
      background: var(--bg-subtle);
      border: 1px solid var(--border-color);
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      user-select: none;
      box-shadow: var(--shadow-subtle);
    }

    .picture-box .label {
      font-size: 15px;
      font-weight: 500;
      color: var(--text-secondary);
    }

    .hover-dropdown-wrapper {
      display: none;
      position: absolute;
      top: 100%;
      left: 0;
      right: 0;
      padding-top: 14px;
      z-index: 100;
    }

    .card-item:hover .hover-dropdown-wrapper,
    .card-item.is-locked .hover-dropdown-wrapper {
      display: block;
    }

    .hover-dropdown {
      background: #ffffff;
      border: 1px solid var(--border-color);
      border-radius: 12px;
      padding: 14px;
      box-shadow: var(--shadow-dropdown);
      font-size: 13px;
      display: flex;
      flex-direction: column;
      gap: 10px;
    }

    .tags-container {
      display: flex;
      flex-wrap: wrap;
      gap: 6px;
    }

    .tag-chip {
      background: var(--bg-subtle);
      border: 1px solid var(--border-color);
      border-radius: 12px;
      padding: 2px 8px;
      font-size: 12px;
      color: var(--text-secondary);
    }

    .meta-list {
      display: flex;
      flex-direction: column;
      gap: 6px;
      border-top: 1px solid var(--border-color);
      border-bottom: 1px solid var(--border-color);
      padding: 8px 0;
    }

    .meta-row {
      display: flex;
      justify-content: space-between;
      font-size: 12px;
    }

    .meta-row span:first-child {
      color: var(--text-secondary);
    }

    .meta-row span:last-child {
      font-weight: 500;
      color: var(--text-primary);
    }

    .details-toggle-btn {
      background: none;
      border: none;
      color: var(--text-primary);
      font-size: 12px;
      font-weight: 500;
      text-decoration: underline;
      cursor: pointer;
      text-align: left;
      width: fit-content;
      padding: 2px 0;
    }

    .extra-details-block {
      display: none;
      flex-direction: column;
      gap: 8px;
      background: var(--bg-subtle);
      padding: 10px;
      border-radius: 8px;
      border: 1px solid var(--border-color);
    }

    body.show-all-details .extra-details-block {
      display: flex;
    }

    .badge-tag {
      display: inline-block;
      align-self: flex-start;
      background: #ffffff;
      border: 1px solid var(--border-color);
      padding: 2px 6px;
      border-radius: 6px;
      font-size: 11px;
      font-weight: 500;
    }

    .author-info {
      font-size: 12px;
    }

    .author-name {
      font-weight: 700;
      color: var(--text-primary);
    }

    .author-followers {
      color: var(--text-secondary);
    }

    .author-bio {
      font-size: 11px;
      color: var(--text-secondary);
      line-height: 1.35;
    }

    .legal-box {
      border-top: 1px solid var(--border-color);
      padding-top: 6px;
      font-size: 11px;
      color: var(--text-secondary);
    }

    .map-section {
      width: 300px;
      border: 1px solid var(--border-color);
      border-radius: 16px;
      background: var(--bg-subtle);
      display: flex;
      flex-direction: column;
      overflow: hidden;
      box-shadow: var(--shadow-subtle);
    }

    .map-toolbar {
      display: flex;
      align-items: center;
      padding: 12px 14px;
      border-bottom: 1px solid var(--border-color);
      background: #ffffff;
    }

    .extend-btn {
      background: var(--bg-subtle);
      border: 1px solid var(--border-color);
      border-radius: 14px;
      padding: 6px 14px;
      font-size: 12px;
      font-weight: 500;
      color: var(--text-secondary);
      cursor: pointer;
    }

    .extend-btn:hover {
      background: #f1f3f4;
      color: var(--text-primary);
    }

    .map-canvas-placeholder {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 2.2rem;
      font-weight: 700;
      color: #70757a;
      letter-spacing: 1px;
      user-select: none;
    }
  </style>
</head>
<body>

  <header class="top-bar">
    <div class="search-wrapper">
      <input type="text" id="searchInput" class="search-input" placeholder="Search images or locations..." />
      <button type="button" id="searchSubmit" class="enter-btn" title="Search">
        <svg viewBox="0 0 24 24">
          <path d="M19 7v4H5.83l3.58-3.59L8 6l-6 6 6 6 1.41-1.41L5.83 13H21V7h-2z"/>
        </svg>
      </button>
    </div>

    <div class="filter-wrapper">
      <select class="filter-select">
        <option value="all">Filter dropdown</option>
        <option value="photos">Photos</option>
        <option value="illustrations">Illustrations</option>
        <option value="vectors">Vectors</option>
      </select>
    </div>
  </header>

  <main class="main-content">
    
    <section class="image-grid-section">
      <div class="section-header">
        <div class="section-title">Image grid layout</div>
        <div id="searchStatus" class="search-status"></div>
      </div>

      <div id="loadingOverlay" class="loading-overlay">
        Searching...
      </div>

      <div class="grid-container">
        
        <div class="card-item">
          <div class="picture-box">
            <span class="label">Picture 1</span>
          </div>

          <div class="hover-dropdown-wrapper">
            <div class="hover-dropdown">
              <div class="tags-container">
                <span class="tag-chip">Children</span>
                <span class="tag-chip">Playing</span>
                <span class="tag-chip">Beach</span>
              </div>

              <div class="meta-list">
                <div class="meta-row">
                  <span>Views</span>
                  <span>224</span>
                </div>
                <div class="meta-row">
                  <span>Media type</span>
                  <span>JPG</span>
                </div>
                <div class="meta-row">
                  <span>Resolution</span>
                  <span>6000 x 4000</span>
                </div>
                <div class="meta-row">
                  <span>Published date</span>
                  <span>August 7, 2026</span>
                </div>
              </div>

              <button type="button" class="details-toggle-btn">Show details</button>

              <div class="extra-details-block">
                <span class="badge-tag">Editor's Choice</span>
                <div><strong>Children, Playing, Beach image. Free for use.</strong></div>
                
                <div class="author-info">
                  <span class="author-name">yazidnasuha</span>
                  <span class="author-followers"> · 17 followers</span>
                </div>
                <p class="author-bio">
                  My camera had stolen by the robber. Please appreciate my photo by donating me a cup of coffee ^-^<br />
                  I'm also a Shutterstock Contributor named as Y.NASX. Thank you
                </p>

                <div class="tags-container">
                  <span class="tag-chip">Ocean</span>
                  <span class="tag-chip">Coastline</span>
                  <span class="tag-chip">Sea</span>
                  <span class="tag-chip">Dark Sand</span>
                  <span class="tag-chip">Volcanic</span>
                  <span class="tag-chip">Summer</span>
                  <span class="tag-chip">Vacation</span>
                </div>

                <div class="legal-box">
                  Free for use under the Pixabay Content License
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="card-item">
          <div class="picture-box">
            <span class="label">Picture 2</span>
          </div>

          <div class="hover-dropdown-wrapper">
            <div class="hover-dropdown">
              <div class="tags-container">
                <span class="tag-chip">Mountain</span>
                <span class="tag-chip">Peak</span>
                <span class="tag-chip">Alps</span>
              </div>

              <div class="meta-list">
                <div class="meta-row">
                  <span>Views</span>
                  <span>512</span>
                </div>
                <div class="meta-row">
                  <span>Media type</span>
                  <span>JPG</span>
                </div>
                <div class="meta-row">
                  <span>Resolution</span>
                  <span>7952 x 5304</span>
                </div>
                <div class="meta-row">
                  <span>Published date</span>
                  <span>June 14, 2026</span>
                </div>
              </div>

              <button type="button" class="details-toggle-btn">Show details</button>

              <div class="extra-details-block">
                <span class="badge-tag">Editor's Choice</span>
                <div><strong>Alpine Ridge Morning Mist</strong></div>
                <div class="author-info">
                  <span class="author-name">mountain_scout</span>
                  <span class="author-followers"> · 89 followers</span>
                </div>
                <p class="author-bio">Landscape photographer based in Switzerland.</p>

                <div class="tags-container">
                  <span class="tag-chip">Snow</span>
                  <span class="tag-chip">Glacier</span>
                  <span class="tag-chip">Altitude</span>
                  <span class="tag-chip">Hiking</span>
                </div>

                <div class="legal-box">
                  Free for use under the Pixabay Content License
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="card-item">
          <div class="picture-box">
            <span class="label">Picture 3</span>
          </div>

          <div class="hover-dropdown-wrapper">
            <div class="hover-dropdown">
              <div class="tags-container">
                <span class="tag-chip">City</span>
                <span class="tag-chip">Night</span>
                <span class="tag-chip">Street</span>
              </div>

              <div class="meta-list">
                <div class="meta-row">
                  <span>Views</span>
                  <span>1,048</span>
                </div>
                <div class="meta-row">
                  <span>Media type</span>
                  <span>PNG</span>
                </div>
                <div class="meta-row">
                  <span>Resolution</span>
                  <span>4000 x 3000</span>
                </div>
                <div class="meta-row">
                  <span>Published date</span>
                  <span>January 22, 2026</span>
                </div>
              </div>

              <button type="button" class="details-toggle-btn">Show details</button>

              <div class="extra-details-block">
                <div><strong>Rainy Tokyo Alley Neon Lights</strong></div>
                <div class="author-info">
                  <span class="author-name">urban_lens</span>
                  <span class="author-followers"> · 340 followers</span>
                </div>
                <p class="author-bio">Street and neon photography collections.</p>

                <div class="tags-container">
                  <span class="tag-chip">Tokyo</span>
                  <span class="tag-chip">Neon</span>
                  <span class="tag-chip">Rain</span>
                  <span class="tag-chip">Cyberpunk</span>
                </div>

                <div class="legal-box">
                  Free for use under the Pixabay Content License
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </section>

    <aside class="map-section" id="mapSection">
      <div class="map-toolbar">
        <button type="button" class="extend-btn" id="extendToggle">Extend map arrow</button>
      </div>

      <div class="map-canvas-placeholder">MAP</div>
    </aside>

  </main>

  <script>
    const searchInput = document.getElementById("searchInput");
    const searchSubmit = document.getElementById("searchSubmit");
    const loadingOverlay = document.getElementById("loadingOverlay");
    const searchStatus = document.getElementById("searchStatus");
    let isSearching = false;

    function triggerSearch() {
      const query = searchInput.value.trim();
      if (!query || isSearching) return;

      isSearching = true;
      loadingOverlay.style.display = "flex";
      searchStatus.style.display = "block";
      searchStatus.textContent = `Searching for "${query}"...`;

      setTimeout(() => {
        loadingOverlay.style.display = "none";
        searchStatus.textContent = `Results for "${query}"`;
        isSearching = false;
      }, 2000);
    }

    searchSubmit.addEventListener("click", triggerSearch);

    searchInput.addEventListener("keydown", (e) => {
      if (e.key === "Enter") {
        triggerSearch();
      }
    });

    document.querySelectorAll('.picture-box').forEach(box => {
      box.addEventListener('click', (e) => {
        e.stopPropagation();
        const card = box.closest('.card-item');
        const isLocked = card.classList.contains('is-locked');

        document.querySelectorAll('.card-item.is-locked').forEach(c => {
          if (c !== card) c.classList.remove('is-locked');
        });

        card.classList.toggle('is-locked', !isLocked);
      });
    });

    document.addEventListener('click', (e) => {
      if (!e.target.closest('.card-item')) {
        document.querySelectorAll('.card-item.is-locked').forEach(card => {
          card.classList.remove('is-locked');
        });
      }
    });

    let areDetailsVisible = false;
    document.querySelectorAll('.details-toggle-btn').forEach(btn => {
      btn.addEventListener('click', (e) => {
        e.stopPropagation();
        areDetailsVisible = !areDetailsVisible;

        document.body.classList.toggle('show-all-details', areDetailsVisible);

        document.querySelectorAll('.details-toggle-btn').forEach(b => {
          b.textContent = areDetailsVisible ? 'Hide details' : 'Show details';
        });
      });
    });

    const extendBtn = document.getElementById("extendToggle");
    const mapSection = document.getElementById("mapSection");
    let isMapExtended = false;

    extendBtn.addEventListener("click", () => {
      isMapExtended = !isMapExtended;
      mapSection.style.width = isMapExtended ? "500px" : "300px";
      extendBtn.textContent = isMapExtended ? "Collapse map arrow" : "Extend map arrow";
    });
  </script>

</body>
</html>