document.addEventListener('DOMContentLoaded', function () {
    let userLat = null;
    let userLng = null;

    async function fetchUserIP() {
        try {
            const res = await fetch('https://api.bigdatacloud.net/data/client-ip');
            if (!res.ok) throw new Error('Unable to reach IP service');
            const info = await res.json();
            return info.ipString;
        } catch (err) {
            console.error("Failed to get IP address:", err);
        }
    }

    fetchUserIP().then((ip) => {
        if (ip) {
            retrieveCoordinates(ip);
        } else {
            displayMap(null, null);
            console.log("Could not fetch IP address");
        }
    });

    async function retrieveCoordinates(ip) {
        try {
            const res = await fetch(`https://api.apibundle.io/ip-lookup?apikey=f9fe188eff6648ea8d03353376d7a2c7&ip=${ip}`);
            if (!res.ok) throw new Error('Failed to get coordinates');
            const info = await res.json();
            userLat = info.latitude;
            userLng = info.longitude;
            displayMap(userLat, userLng);
        } catch (err) {
            console.error("Failed to get coordinates:", err);
        }
    }

    let leafletMap;

    function displayMap(lat, lng) {
        if (leafletMap) {
            leafletMap.remove();
        }
        if (lat == null || lng == null) {
            leafletMap = L.map('map').setView([38.4819612, -100.467084], 4);
        } else {
            leafletMap = L.map('map').setView([lat, lng], 5);
            const marker = L.marker([lat, lng]).addTo(leafletMap);
            marker.bindPopup('Your location').openPopup();
        }
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(leafletMap);
        loadStores();
    }

    async function loadStores() {
        try {
            const response = await fetch("https://sae401thibault.alwaysdata.net/api/api.php?actionGet=stores");
            if (!response.ok) throw new Error("Failed to fetch stores");
            const stores = await response.json();
            await Promise.all(stores.map(async (store) => {
                const coords = await geocodeStore(store.city, store.street, store.zip_code, store.state);
                if (coords) {
                    const marker = L.marker([coords.lat, coords.lon]).addTo(leafletMap);
                    marker.bindPopup(`<b>${store.store_name}</b><br> ${store.city}`);
                }
            }));
        } catch (err) {
            console.error("Error loading stores:", err);
        }
    }
    
    async function geocodeStore(city, street, zip, state) {
        try {
            const response = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(street)},${encodeURIComponent(zip)}`);
            if (!response.ok) throw new Error("Failed to geocode store");
            const data = await response.json();
            return data[0];
        } catch (err) {
            console.error("Error geocoding store:", err);
        }
    }
});