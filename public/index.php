<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Google & Pixabay Layout</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="style.css" />
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
      <select id="imageTypeFilter" class="filter-select">
        <option value="all">All Types</option>
        <option value="photo">Photos</option>
        <option value="illustration">Illustrations</option>
        <option value="vector">Vectors</option>
      </select>
    </div>
  </header>

  <main class="main-content">
    <section class="image-grid-section">
      <div class="section-header">
        <div class="section-title">Image grid layout</div>
        <div id="searchStatus" class="search-status"></div>
      </div>

      <div class="grid-viewport-wrapper">
        <div id="loadingOverlay" class="loading-overlay">Searching Pixabay...</div>
        
        <div class="grid-container" id="imageGrid"></div>
      </div>
    </section>

    <aside class="map-section" id="mapSection">
      <div class="map-toolbar">
        <button type="button" class="extend-btn" id="extendToggle">Extend map arrow</button>
      </div>

      <div class="map-canvas-placeholder">MAP</div>
    </aside>
  </main>

  <script src="js/app.js"></script>
</body>
</html>