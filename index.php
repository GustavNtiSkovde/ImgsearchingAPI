<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Base Layout</title>
  <link rel="icon" type="image/svg+xml" href="js/icon.svg" />
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
  <link rel="stylesheet" href="./style.css" />
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
  <script type="module" src="./js/api.js" defer ></script>
  <script src="./js/ux.js" defer ></script>
  <script src="./js/ui.js" defer ></script>
</head>
<body>
  <header class="top-bar">
    <div class="search-row">
      
      <a href="#" class="logo-link" aria-label="Home">
        <img src="js/icon.svg" alt="ImgSearchingAPI Logo" class="site-logo" />
      </a>

      <form id="searchForm" class="search-wrapper">
        <input type="text" id="searchInput" class="search-input" placeholder="Search..." />
        <button type="submit" id="searchSubmit" class="enter-btn">↵</button>
      </form>
      
      <button id="themeToggle" class="theme-toggle-btn" aria-label="Toggle Dark Mode">
        <svg class="moon-icon" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>
        <svg class="sun-icon" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: none;"><circle cx="12" cy="12" r="5"></circle><line x1="12" y1="1" x2="12" y2="3"></line><line x1="12" y1="21" x2="12" y2="23"></line><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line><line x1="1" y1="12" x2="3" y2="12"></line><line x1="21" y1="12" x2="23" y2="12"></line><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line></svg>
      </button>
    </div>

    <div class="filter-wrapper">
      <div class="scale-slider-wrapper">
        <label for="gridScale" class="scale-label">Size:</label>
        <input type="range" id="gridScale" min="120" max="450" value="300" step="10" class="scale-slider">

      </div>
      <div class="custom-filter-container" id="customFilterContainer">
        <div class="custom-filter-trigger" id="customFilterTrigger">
          <span>All</span>
          <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
        </div>
        <div class="custom-filter-dropdown">
          <div class="custom-filter-option" data-value="all">All</div>
          
          <div class="custom-filter-group-wrapper">
            <div class="custom-filter-group-header">
              Filter 1
              <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="group-arrow"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="custom-filter-group-content">
              <div class="custom-filter-option sub-option" data-value="f1_1">Filter 1_1</div>
              <div class="custom-filter-option sub-option" data-value="f1_2">Filter 1_2</div>
            </div>
          </div>

          <div class="custom-filter-group-wrapper">
            <div class="custom-filter-group-header">
              Filter 2
              <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="group-arrow"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="custom-filter-group-content">
              <div class="custom-filter-option sub-option" data-value="f2_1">Filter 2_1</div>
              <div class="custom-filter-option sub-option" data-value="f2_2">Filter 2_2</div>
            </div>
          </div>
        </div>
        <select id="imageTypeFilter" style="display: none;">
          <option value="all">All</option>
          <option value="f1_1">Filter 1_1</option>
          <option value="f1_2">Filter 1_2</option>
          <option value="f2_1">Filter 2_1</option>
          <option value="f2_2">Filter 2_2</option>
        </select>
      </div>
    </div>
  </header>

  <div class="quick-suggestions" id="quickSuggestions">
    <button type="button" class="suggestion-chip" data-tag="forest">
      <img src="https://images.unsplash.com/photo-1518531933037-91b2f5f229cc?w=50&h=50&fit=crop" alt="Forest" class="suggestion-thumb">
      <span>Forest</span>
    </button>
    <button type="button" class="suggestion-chip" data-tag="city">
      <img src="https://images.unsplash.com/photo-1449844908441-8829872d2607?w=50&h=50&fit=crop" alt="City" class="suggestion-thumb">
      <span>City</span>
    </button>
    <button type="button" class="suggestion-chip" data-tag="landscape">
      <img src="https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=50&h=50&fit=crop" alt="Landscape" class="suggestion-thumb">
      <span>Landscape</span>
    </button>
    <button type="button" class="suggestion-chip" data-tag="ocean">
      <img src="https://images.unsplash.com/photo-1505118380757-91f5f5632de0?w=50&h=50&fit=crop" alt="Ocean" class="suggestion-thumb">
      <span>Ocean</span>
    </button>
    <button type="button" class="suggestion-chip" data-tag="animals">
      <img src="https://images.unsplash.com/photo-1474511320723-9a56873867b5?w=50&h=50&fit=crop" alt="Animals" class="suggestion-thumb">
      <span>Animals</span>
    </button>
    <button type="button" class="suggestion-chip" data-tag="deserts">
      <img src="https://images.unsplash.com/photo-1473580044384-7ba9967e16a0?w=50&h=50&fit=crop" alt="Deserts" class="suggestion-thumb">
      <span>Deserts</span>
    </button>
  </div>

  <main class="main-content">
    <section class="image-grid-section">
      <div class="grid-container" id="imageGrid"></div>

      <div class="load-more-wrapper">
        <button id="loadMoreBtn" class="load-more-btn">Load More Images</button>
      </div>
    </section>
    
    <div class="split-divider" id="mapResizeHandle"></div>
    <button class="mobile-map-fab" id="mobileMapBtn">
      <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
        <path d="M20.5 3l-.16.03L15 5.1 9 3 3.36 4.9c-.21.07-.36.25-.36.48V20.5c0 .28.22.5.5.5l.16-.03L9 18.9l6 2.1 5.64-1.9c.21-.07.36-.25.36-.48V3.5c0-.28-.22-.5-.5-.5zM15 19l-6-2.11V5l6 2.11V19z"/>
      </svg>
    </button>
    <aside class="map-section" id="mapSection">
      <div class="map-header-mobile">
        <span class="map-title-mobile">Map View</span>
        <button class="close-map-btn" id="closeMapBtn">&times;</button>
      </div>
      <div id="map"></div>
      <script src="./js/leafletmap.js"></script> 
    </aside>
  </main>
  
  <footer class="site-footer">
    <p>&copy; 2026 ImgSearchingAPI Solutions. All rights reserved.</p>
    <p>123 Pixel Avenue, Suite 404, Tech District, Web City, WC 90210</p>
    <p>Contact: dummy@imgsearchingapi.ddev.site | 1-800-FAKE-IMG</p>
  </footer>
</body>
</html>