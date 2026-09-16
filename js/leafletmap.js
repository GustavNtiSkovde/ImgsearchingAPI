document.addEventListener('DOMContentLoaded', function () { //Added listner for DOM and then a function that creates the map and adds a tile layer
    var mapElement = document.getElementById('map'); //Choose element to add it in
    var map = window.L.map(mapElement).setView([51.505, -0.09], 13); //Create the map

    window.mapInstance = map;

    window.L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', { //Use openstreetmaps tilelayer
        maxZoom: 15, //Max zoom in 
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    //Variable for map pin icon
    let currentMarker = null;

    // Cards are rendered dynamically, so handle all image clicks from the document.
    document.addEventListener('click', async function(event) {
        const card = event.target.closest('.card-item');
        if (!card) return;

        const imageId = card.dataset.imageId;

        try {
            // Fetch coordinates and statistics for this image only after it is clicked.
            const detailUrl = `./api.php?id=${encodeURIComponent(imageId)}`;
            const statsUrl = `${detailUrl}&stats=1`;
            const [detailResponse, statsResponse] = await Promise.all([
                fetch(detailUrl),
                fetch(statsUrl)
            ]);
            const data = await detailResponse.json();
            const statsData = await statsResponse.json();

            if (!detailResponse.ok || data.error || !data.hits?.[0]) {
                throw new Error(data.error || 'Could not find image details');
            }

            if (!statsResponse.ok) {
                throw new Error(statsData.error);
            }

            const image = data.hits[0];
            const locationLabel = card.querySelector('.card-location');
            if (locationLabel && image.location) {
                locationLabel.textContent = image.location;
            }

            const latitude = Number(image.latitude);
            const longitude = Number(image.longitude);

            // Images without coordinate data cannot be placed on the map.
            if (image.latitude == null || image.latitude === '' || image.longitude == null || image.longitude === ''
                || !Number.isFinite(latitude) || !Number.isFinite(longitude)) { //IsFinite checks if number is a real numer = true or if numer is infinity or negative infinity
                window.alert('No coordinates given for this image.');
                return;
            }

            const imageCoords = [latitude, longitude];
            if (currentMarker) currentMarker.remove();

            currentMarker = L.marker(imageCoords).addTo(map).bindPopup(`<b>${image.location}</b><br>Coordinates: ${image.longitude} ${image.latitude}`).openPopup();

            map.setView(imageCoords, 13);
        } catch (error) {
            console.error('Error fetching image location', error);
        }
    });

    map.on('click', async function(e) {
        let coords = e.latlng; 
        console.log(coords);

        if (currentMarker) {
            currentMarker.remove();
        }
        currentMarker = L.marker([coords.lat, coords.lng]).addTo(map);

        try {
            let response = await fetch(`../nominatimapi.php?lat=${coords.lat}&lng=${coords.lng}`);
            let data = await response.json();

            //Error handling if no location given
            if (!response.ok || data.error) {
                throw new Error(data.error || 'Could not find this location');
            }
            
            //Show city and country on the marker
            if (data.city ?? data.country) {
                currentMarker.bindPopup(`<b>${data.city}</b>, ${data.country}`).openPopup();
            }

            // If data has anything add it into the query to be used in api.js
            if (data.search_query) {
                const searchInput = document.getElementById('searchInput');
                const searchForm = document.getElementById('searchForm');

                searchInput.value = data.search_query;
                searchForm.requestSubmit(); //RequestSubmit to simulate a submit button to trigger search
            }
        }
        catch (error) {
                console.error("Error fetching location", error);
        }
    });
});