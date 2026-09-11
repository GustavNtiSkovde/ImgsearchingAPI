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
            console.log("Location details:", data.country, data.city);
            
            //Show city and country on the marker
            if (data.city ?? data.country) {
                currentMarker.bindPopup(`<b>${data.city}</b>, ${data.country}`).openPopup();
            }
        }
        catch (error) {
                console.error("Error fetching location", error);
        }
    });
});
