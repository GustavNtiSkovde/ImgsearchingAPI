<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Base Layout</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>

  <header class="top-bar">
    <div class="search-wrapper">
      <input type="text" id="searchInput" class="search-input" placeholder="Search..." />
      <button type="button" id="searchSubmit" class="enter-btn">↵</button>
    </div>

    <div class="filter-wrapper">
      <select id="imageTypeFilter" class="filter-select">
        <option value="all">All</option>
        <option value="photo">Photos</option>
        <option value="illustration">Illustrations</option>
        <option value="vector">Vectors</option>
      </select>
    </div>
  </header>

  <main class="main-content">
    <section class="image-grid-section">
      <!-- ID for inserting image cards -->
      <div class="grid-container" id="imageGrid">
        
        <!--Placeholder-->
        <div class="card-item">
          <div class="picture-box">Picture Placeholder</div>
          <div class="hover-dropdown-wrapper">
            <div class="hover-dropdown">
              <div>Tags: <span class="card-tags">Tag1, Tag2</span></div>
              <div>Views: <span class="card-views">0</span></div>
              <div>Resolution: <span class="card-res">0x0</span></div>
            </div>
          </div>
        </div>

      </div>
    </section>

    <aside class="map-section" id="mapSection">
      <button type="button" id="extendToggle" class="extend-btn">Toggle Map</button>
      <div class="map-placeholder">MAP</div>
    </aside>
  </main>

  <script src="js/ux.js"></script>
  <script src="js/ui.js"></script>
  <script src="js/api.js"></script>
</body>
</html>