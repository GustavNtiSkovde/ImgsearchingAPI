<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Base Layout</title>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
  <link rel="stylesheet" href="style.css" />
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
  <script type="module" src="js/api.js" defer ></script>
  <script src="js/ux.js" defer ></script>
  <script src="js/ui.js" defer ></script>
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
      <div class="grid-container" id="imageGrid"></div>
    </section>

    <aside class="map-section" id="mapSection">
      <button type="button" id="extendToggle" class="extend-btn">Toggle Map</button>
      <div id="map"></div>
      <script src="js/leafletmap.js"></script> <!-- Script file has to come after the css, link to js and the div element -->
    </aside>
  </main>
</body>
</html>