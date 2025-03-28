document.addEventListener("DOMContentLoaded", () => {
    initAppMap();
});

async function initAppMap() {
    let locations = [];
    
    try {
        const data = await fetchLocations();
        locations = formatLocations(data);
    } catch (err) {
        console.error("Error fetching locations:", err);
    }
    
    if (document.querySelector('#map') && locations.length > 0) {
        const icons = {
            'branch-fix': L.icon({
                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-blue.png',
                shadowUrl: 'https://unpkg.com/leaflet@1.9.3/dist/images/marker-shadow.png'
            }),
            'branch-pos': L.icon({
                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-black.png',
                shadowUrl: 'https://unpkg.com/leaflet@1.9.3/dist/images/marker-shadow.png'
            }),
            'chapel-own': L.icon({
                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-red.png',
                shadowUrl: 'https://unpkg.com/leaflet@1.9.3/dist/images/marker-shadow.png'
            }),
            'chapel-external': L.icon({
                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-orange.png',
                shadowUrl: 'https://unpkg.com/leaflet@1.9.3/dist/images/marker-shadow.png'
            }),
            'cemetery-own': L.icon({
                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-green.png',
                shadowUrl: 'https://unpkg.com/leaflet@1.9.3/dist/images/marker-shadow.png'
            }),
            'cemetery-external': L.icon({
                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-gold.png',
                shadowUrl: 'https://unpkg.com/leaflet@1.9.3/dist/images/marker-shadow.png'
            }),
            'crematory-own': L.icon({
                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-violet.png',
                shadowUrl: 'https://unpkg.com/leaflet@1.9.3/dist/images/marker-shadow.png'
            }),
            'crematory-external': L.icon({
                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-gray.png',
                shadowUrl: 'https://unpkg.com/leaflet@1.9.3/dist/images/marker-shadow.png'
            }),
        };
        
        const matrix = locations.find(loc =>
            loc.iso.toLowerCase().includes('matriz')
        );
      
        const map = L.map('map').setView([matrix.latitude, matrix.longitude], 25);
      
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
      
        // Añadir un marcador para cada ubicación
        
        locations.forEach(loc => {
            if (loc.latitude && loc.longitude) {
                const key = `${loc.category_type}-${loc.category_subtype}`;
                const icon = icons[key];
          
                if('0' === loc.telephone){
                    L.marker([loc.latitude, loc.longitude], { icon })
                    .addTo(map)
                    .bindPopup(`<strong>${loc.name}</strong><br>${loc.category_name}<br>${loc.address}`);
                } else{
                    L.marker([loc.latitude, loc.longitude], { icon })
                    .addTo(map)
                    .bindPopup(`<strong>${loc.name}</strong><br>${loc.category_name}<br>${loc.address}<br>Teléfono: ${loc.telephone}`);
                }
            }
        });
    }
}

async function fetchLocations() {
    const response = await fetch("/api/locations");
    return await response.json();
}

function formatLocations(data = []) {
    return data.map(item => ({
        id: item.id,
        name: item.name,
        iso: item.iso,
        address: item.address,
        telephone: item.telephone,
        category_type: item.category_type,
        category_subtype: item.category_subtype,
        category_name: item.category_name,
        latitude: item.latitude,
        longitude: item.longitude
    }));
}  