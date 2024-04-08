<?php
echo('
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Map Example</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        #map-container {
            width: 40%;
            margin: 0 auto; /* Centre la div horizontalement */
            position: relative; /* Conserve le flux normal du document */
            height: 0;
            padding-bottom: 40%; /* Ratio hauteur/largeur de 40% */
        }
        #map { 
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
        #markers-list {
            margin-top: 20px;
            list-style: none;
            padding: 0;
        }
        #markers-list li {
            margin-bottom: 5px;
        }
        .delete-button {
            margin-left: 10px;
            cursor: pointer;
        }
        #send-form {
            margin-top: 20px;
            text-align: center;
        }
        #search-control {
            position: absolute;
            top: 10px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1000;
            background-color: #fff;
            padding: 5px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div id="map-container">
        <div id="map"></div>
        <div id="search-control">
            <input type="text" id="search-input" placeholder="Rechercher un lieu">
        </div>
    </div>
    <ul id="markers-list"></ul>
    <form id="send-form">
        <button type="submit">Envoyer</button>
    </form>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        var map = L.map("map").setView([49.8486, 3.2879], 13); // Centrage sur Saint-Quentin dans l\'Aisne
        var markersLayer = new L.LayerGroup().addTo(map);
        
        L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
            attribution: "&copy; <a href=\'https://www.openstreetmap.org/copyright\'>OpenStreetMap</a>"
        }).addTo(map);

        var searchInput = document.getElementById("search-input");

        searchInput.addEventListener("keypress", function(e) {
            if (e.key === "Enter") {
                var query = searchInput.value;
                searchPlace(query);
            }
        });

        function searchPlace(query) {
            fetch("https://nominatim.openstreetmap.org/search?format=json&q=" + query)
                .then(function(response) {
                    return response.json();
                })
                .then(function(data) {
                    if (data && data.length > 0) {
                        var result = data[0];
                        map.setView([result.lat, result.lon], 13);
                    } else {
                        alert("Aucun résultat trouvé pour cette recherche.");
                    }
                })
                .catch(function(error) {
                    console.error("Erreur lors de la recherche de lieu :", error);
                    alert("Une erreur s\'est produite lors de la recherche de lieu.");
                });
        }

        map.on("click", function(e) {
            var marker = L.marker(e.latlng).addTo(markersLayer);
            var popupContent = prompt("Entrez le nom du marqueur :");
            marker.bindPopup(popupContent);
            updateMarkersList();
        });

        function updateMarkersList() {
            var markersList = document.getElementById("markers-list");
            markersList.innerHTML = "";
            markersLayer.eachLayer(function(marker) {
                var coords = marker.getLatLng();
                var name = marker.getPopup().getContent();
                var listItem = document.createElement("li");
                listItem.textContent = "Latitude: " + coords.lat.toFixed(6) + ", Longitude: " + coords.lng.toFixed(6) + " - " + name;
                var deleteButton = document.createElement("span");
                deleteButton.className = "delete-button";
                deleteButton.textContent = "Effacer";
                deleteButton.onclick = function() {
                    markersLayer.removeLayer(marker);
                    updateMarkersList();
                };
                listItem.appendChild(deleteButton);
                markersList.appendChild(listItem);
            });
        }

        document.getElementById("send-form").addEventListener("submit", function(event) {
            event.preventDefault();
            var markersData = [];
            markersLayer.eachLayer(function(marker) {
                var coords = marker.getLatLng();
                var name = marker.getPopup().getContent();
                markersData.push({
                    lat: coords.lat,
                    lng: coords.lng,
                    name: name
                });
            });
            // Envoi des données via une requête POST
            fetch("votre_url_d_envoi", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(markersData)
            })
            .then(function(response) {
                if (response.ok) {
                    alert("Marqueurs envoyés avec succès !");
                    // Effacer les marqueurs de la carte et mettre à jour la liste
                    markersLayer.clearLayers();
                    updateMarkersList();
                } else {
                    alert("Une erreur s\'est produite lors de l\'envoi des marqueurs.");
                }
            })
            .catch(function(error) {
                console.error("Erreur lors de l\'envoi des marqueurs :", error);
                alert("Une erreur s\'est produite lors de l\'envoi des marqueurs.");
            });
        });
    </script>
</body>
</html>
');
