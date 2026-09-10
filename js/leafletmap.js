document.addEventListener('DOMContentLoaded', function () { //Added listner for DOM and then a function that creates the map and adds a tile layer
    var mapElement = document.getElementById('map'); //Choose element to add it in
    var map = window.L.map(mapElement).setView([51.505, -0.09], 13); //Create the map

    window.mapInstance = map; //Scaling js connection

    window.L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', { //Use openstreetmaps tilelayer
        maxZoom: 15, //Max zoom in 
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    map.on('click', async function(e) {
        var coords = e.latlng;
        console.log(coords);
    });
});