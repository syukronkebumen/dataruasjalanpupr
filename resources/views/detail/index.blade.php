@extends('landingpage')

@section('content')
<div class="flex flex-col xl:flex-row gap-6 justify-between items-start xl:items-end">
    <div class="flex flex-col gap-2">
        <h1 class="text-3xl md:text-4xl font-bold tracking-tight text-text-main">Data Statistik Per Ruas Jalan</h1>
        <p class="text-text-muted text-lg">Detail Statistik Setiap Ruas Jalan.</p>
    </div>
    <div class="flex gap-3">
        
    </div>
</div>

<div class="bg-surface border border-border-light rounded-xl overflow-hidden shadow-card">
    <div class="flex flex-col xl:flex-row gap-6 h-96">
        <div class="xl:w-[70%]">
            <div id="map" class="w-full h-96 rounded-lg"></div>
        </div>
        <div class="xl:w-[30%] flex flex-col gap-4 p-6 bg-surface-highlight rounded-lg border border-border-light overflow-y-auto">
            <h3 class="text-lg font-bold text-text-main">Informasi Ruas Jalan</h3>
            <div class="space-y-3">
                <div class="flex flex-col gap-1">
                    <p class="text-sm text-text-muted font-medium">Nama Ruas Jalan</p>
                    <p class="text-text-main font-semibold" id="nama-ruas">({{ $data->no_ruasjln }}) {{ $data->nama_ruasjln }}</p>
                </div>
                <div class="flex flex-col gap-1">
                    <p class="text-sm text-text-muted font-medium">Panjang Jalan</p>
                    <p class="text-text-main font-semibold" id="panjang-ruas">{{ $data->panjang_jln }} m</p>
                </div>
                <div class="flex flex-col gap-1">
                    <p class="text-sm text-text-muted font-medium">Kecamatan yang dilalui</p>
                    <p class="text-text-main font-semibold" id="kecamatan-ruas">{{ $data->kec_jalan }}</p>
                </div>
                <div class="flex flex-col gap-1">
                    <p class="text-sm text-text-muted font-medium">Fungsi</p>
                    <p class="text-text-main font-semibold" id="fungsi-ruas">{{ $data->id_fungsijln }}</p>
                </div>
            </div>
            <div class="flex gap-3 pt-4 border-t border-border-light mt-4">
                <a href="/" class="flex items-center gap-2 h-10 px-5 rounded-full bg-white border border-border-light text-text-main hover:bg-surface-highlight hover:border-gray-300 transition-all text-sm font-medium shadow-sm">
                    <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                    Kembali
                </a>
            </div>
        </div>
    </div>
    <!-- <div id="map" class="w-full h-96 rounded-lg"></div> -->
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<script>
    // Initialize map
    const map = L.map('map').setView([-4.7477, 105.2381], 10);

    // Base layers
    const baseLayers = {
        "Google Map": L.tileLayer('https://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
        }),

        "OpenStreetMap": L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19
        }),

        "Google Hybrid": L.tileLayer('https://{s}.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            subdomains: ['mt0', 'mt1', 'mt1', 'mt3']
        }),

        "Google Satellite": L.tileLayer('https://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
        }),

        "Google Terrain": L.tileLayer('https://{s}.google.com/vt/lyrs=p&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
        })
    };

    // Default base map
    baseLayers["Google Map"].addTo(map);

    // Set map center to Lampung Timur, Indonesia
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© diskominfo.lampungtimurkab.go.id',
        maxZoom: 19
    }).addTo(map);

    // Overlay Batas Wilayah Lampung Timur
    const batasWilayahLamtim = L.geoJSON(null, {
        style: function(feature) {
            return {
                color: '#2c3e50',
                weight: 2,
                fillColor: '#3498db',
                fillOpacity: 0.1
            };
        }
    });

    const batasKecamatanLamtim = L.geoJSON(null, {
        style: function(feature) {
            return {
                color: '#27ae60',
                weight: 1,
                fillColor: '#2ecc71',
                fillOpacity: 0.1
            };
        },
        onEachFeature: function(feature, layer) {
            layer.bindPopup(`
            <div><strong>Kecamatan:</strong> ${feature.properties.nm_kecamatan}</div>`);
        }
    });

    const batasKelurahanLamtim = L.geoJSON(null, {
        style: function(feature) {
            return {
                color: '#8e44ad',
                weight: 1,
                fillColor: '#9b59b6',
                fillOpacity: 0.2
            };
        },
        onEachFeature: function(feature, layer) {
            layer.bindPopup(`
            <div><strong>Kelurahan:</strong> ${feature.properties.nm_kelurahan}</div>`);
        }
    });

    const overlays = {
        "Batas Adm. Kabupaten": batasWilayahLamtim,
        "Batas Adm. Kecamatan": batasKecamatanLamtim,
        "Batas Adm. Kelurahan": batasKelurahanLamtim
    };

    L.control.layers(baseLayers, overlays, {
        collapsed: true,
        position: 'topright'
    }).addTo(map);


    // Fetch road data from Excel
    // Show loading indicator
    const loadingIndicator = document.createElement('div');
    loadingIndicator.id = 'map-loading';
    loadingIndicator.className = 'absolute inset-0 flex items-center justify-center bg-white/80 rounded-lg z-10';
    loadingIndicator.innerHTML = `
        <div class="flex flex-col items-center gap-3">
        <div class="w-8 h-8 border-4 border-border-light border-t-primary rounded-full animate-spin"></div>
        <p class="text-sm text-text-muted font-medium">Loading road data...</p>
        </div>
    `;
    document.getElementById('map').parentElement.style.position = 'relative';
    document.getElementById('map').parentElement.appendChild(loadingIndicator);

    fetch("/api/ruasjalan/detail/{{ $data->id_ruasjln }}")
        .then(res => res.json())
        .then(data => {
            const latlngs = data.coords.map(item => {
                const [lat, lng] = item.split(',').map(Number);
                return [lat, lng];
            });

            if (window.ruasLayer) {
                map.removeLayer(window.ruasLayer);
            }

            if (window.startMarker) map.removeLayer(window.startMarker);
            if (window.endMarker) map.removeLayer(window.endMarker);

            window.ruasLayer = L.polyline(latlngs, {
                color: 'red',
                weight: 5
            }).addTo(map);

            // Pangkal & Ujung
            const start = latlngs[0];
            const end   = latlngs[latlngs.length - 1];

            window.startMarker = L.circleMarker(start, {
                radius: 7,
                color: 'green',
                fillColor: 'green',
                fillOpacity: 1
            }).addTo(map).bindPopup('📍 Pangkal Jalan');

            window.endMarker = L.circleMarker(end, {
                radius: 7,
                color: 'red',
                fillColor: 'red',
                fillOpacity: 1
            }).addTo(map).bindPopup('🏁 Ujung Jalan');

            window.ruasLayer.bindPopup(`
                <b>${data.nama_ruasjln}</b><br>
                Panjang: ${data.panjang_jln} m<br>
                Kecamatan: ${data.kec_jalan}
            `);

            map.fitBounds(window.ruasLayer.getBounds());
        })
        .catch(error => {
            console.error('Error loading data:', error);
            alert('Gagal memuat data ruas jalan');
        })
        .finally(() => {
            // Remove loading indicator
            loadingIndicator.remove();
        });

    fetch('/api/batas-wilayah')
        .then(res => res.json())
        .then(data => {
            batasWilayahLamtim.addData(data);
        })
        .catch(err => console.error('Gagal load GeoJSON:', err));

    fetch('/api/batas-kecamatan')
        .then(res => res.json())
        .then(data => {
            batasKecamatanLamtim.addData(data);
        })

    fetch('/api/batas-kelurahan')
        .then(res => res.json())
        .then(data => {
            batasKelurahanLamtim.addData(data);
        })
        .catch(err => console.error('Gagal load GeoJSON:', err));
</script>

<div class="w-full h-48 rounded-2xl overflow-hidden relative border border-border-light mt-4 shadow-card">
    <div class="absolute inset-0 bg-cover bg-center transition-all duration-700 hover:scale-105" data-alt="Map view showing road networks with heatmaps overlaid on city streets" data-location="Toronto" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuASDfGZvelAlpriNvt4bHUkbl4dq0R-H-FiVJ4mUpc05kjh5YmFvLhl1sNDEQa1qpGRj4TOjUDEfJgEXHrYXXYfOIeN8s8aHF29G7Jh0TrxTb3t1nhb7okwzgapU3j4GHXxkmzHjLdU2bZdM9qyqTyXRoV66U9rXuDf1zvuj3mnNVEvVIEmV3Yu5PdYiXzzOo7mXsHraKn-IEn5iXkVEZ-fJsbvCHQEMZeFg81JED4eq-kvSII3MCzbvrtTcwFUo5IC9WA7tFBXxw_U");'>
    </div>
    <div class="absolute inset-0 bg-gradient-to-r from-white via-white/90 to-transparent flex items-center p-8 lg:p-12">
        <div class="flex flex-col gap-4 max-w-lg">
            <h3 class="text-2xl font-bold text-text-main">Geospatial Overview</h3>
            <p class="text-text-muted font-medium">Switch to map view to visualize road conditions, traffic incidents, and maintenance crews in real-time across the entire network.</p>
            <button class="w-fit flex items-center gap-2 px-5 py-2.5 rounded-full bg-white hover:bg-gray-50 text-primary border border-primary/20 hover:border-primary/50 shadow-sm transition-all text-sm font-bold">
                <span class="material-symbols-outlined">map</span>
                Launch Map View
            </button>
        </div>
    </div>
</div>
@endsection