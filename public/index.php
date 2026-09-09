<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Image Gallery</title>
  <link rel="stylesheet" href="style.css" />
<script src="js/api.js" defer></script>
<script src="js/ui.js" defer></script>
</head>
<body>

  <header class="top-bar">
    <form id="searchForm" class="search-wrapper">
      <input type="text" id="searchInput" class="search-input" placeholder="Search..." />
      <button type="submit" id="searchSubmit" class="enter-btn">↵</button>
    </form>

    <div class="filter-wrapper">
      <div class="scale-slider-wrapper">
        <label for="gridScale" class="scale-label">Size:</label>
        <input type="range" id="gridScale" min="120" max="450" value="240" step="10" class="scale-slider">
      </div>

      <select id="imageTypeFilter" class="filter-select">
        <option value="all">All</option>
        <option value="Filter 1">Filter</option>
        <option value="Filter 2 ">Filter 2</option>
        <option value="Filter 3">Filter 3</option>
      </select>
    </div>
  </header>

  <main class="main-content">
    <section class="image-grid-section">
      <div class="grid-container" id="imageGrid">
        
        <!-- Card exampel-->
        <div class="card-item">
          <div class="picture-box"> 
            <!-- img url here-->
            <img class="picture-box-img" src="https://images.unsplash.com/photo-1518531933037-91b2f5f229cc" alt="Green forest leaves">
          </div>
          <div class="hover-dropdown-wrapper">
            <div class="hover-dropdown">
                <!-- info -->
              <div>Tags: <span class="card-tags">nature, forest, green, leaves</span></div>
              <div>Views: <span class="card-views">14,280</span></div>
              <div>Resolution: <span class="card-res">1920x1080</span></div>
            </div>
          </div>
        </div>

        <div class="card-item">
          <div class="picture-box"> 
            <img class="picture-box-img" src="https://images.unsplash.com/photo-1441974231531-c6227db76b6e" alt="Dark mossy woods">
          </div>
          <div class="hover-dropdown-wrapper">
            <div class="hover-dropdown">
              <div>Tags: <span class="card-tags">woods, dark, moss, trees</span></div>
              <div>Views: <span class="card-views">8,432</span></div>
              <div>Resolution: <span class="card-res">2560x1440</span></div>
            </div>
          </div>
        </div>

        <div class="card-item">
          <div class="picture-box"> 
            <img class="picture-box-img" src="https://images.unsplash.com/photo-1542273917363-3b1817f69a2d" alt="Tree canopy">
          </div>
          <div class="hover-dropdown-wrapper">
            <div class="hover-dropdown">
              <div>Tags: <span class="card-tags">canopy, sunlight, branches</span></div>
              <div>Views: <span class="card-views">21,050</span></div>
              <div>Resolution: <span class="card-res">3840x2160</span></div>
            </div>
          </div>
        </div>

      </div>
    </section>

    <div class="split-divider" id="mapResizeHandle"></div>

    <aside class="map-section" id="mapSection">
      <div class="map-placeholder">MAP</div>
    </aside>
  </main>

</body>
</html>