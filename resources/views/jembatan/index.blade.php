@extends('landingpage')

@section('content')


<div class="flex flex-col xl:flex-row gap-6 justify-between items-start xl:items-end">
    <div class="flex flex-col gap-2">
        <h1 class="text-3xl md:text-4xl font-bold tracking-tight text-text-main">Data Jembatan</h1>
        <p class="text-text-muted text-lg">Informasi lengkap data jembatan beserta kondisi dan detail teknis.</p>
    </div>
    <div class="flex gap-3">
        <button class="flex items-center gap-2 h-10 px-5 rounded-full bg-white border border-border-light text-text-main hover:bg-surface-highlight hover:border-gray-300 transition-all text-sm font-medium shadow-sm">
            <span class="material-symbols-outlined text-[18px]">download</span>
            Export Data
        </button>
        <button class="flex items-center gap-2 h-10 px-5 rounded-full bg-primary text-white hover:bg-primary-dark transition-all text-sm font-bold shadow-lg shadow-primary/30 hover:shadow-primary/40">
            <span class="material-symbols-outlined text-[18px]">add</span>
            Tambah Data
        </button>
    </div>
</div>

<div class="bg-surface border border-border-light rounded-xl overflow-hidden shadow-card">
    <div id="map" class="w-full h-96 rounded-lg"></div>
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

    function parseLatLng(coords) {
        if (!coords || typeof coords !== 'string') return null;

        // bersihkan spasi
        coords = coords.trim();

        // split
        const parts = coords.split(',');

        // harus 2 nilai
        if (parts.length !== 2) return null;

        const lat = parseFloat(parts[0].trim());
        const lng = parseFloat(parts[1].trim());

        // validasi angka
        if (isNaN(lat) || isNaN(lng)) return null;

        // validasi range
        if (lat < -90 || lat > 90) return null;
        if (lng < -180 || lng > 180) return null;

        return [lat, lng];
    }

    fetch("/api/ruasjalan")
        .then(res => res.json())
        .then(data => {
        let bounds = [];
        data.forEach(function(item) {
            if (!item.coords || item.coords.length === 0) return;
            var line = L.polyline(item.coords, {
                weight: 4,
                color: "blue",
            }).addTo(map);
            
            bounds.push(...item.coords);
            line.bindPopup(`
                <b>${item.nama_ruasjln}</b><br>
                Panjang: ${item.panjang_jln}<br>
                Fungsi: ${item.id_fungsijln}<br>
                Kecamatan: ${item.kec_jalan}<br>
                Wilayah: ${item.wilayah}<br>
                No Ruas: ${item.no_ruasjln}<br>
            `);
        });
        if (bounds.length > 0) {
            map.fitBounds(bounds);
        }
        })
        .catch(error => {
            console.error('Error loading data:', error);
            alert('Gagal memuat data ruas jalan');
        })

    fetch("/api/jembatan/list")
        .then(res => res.json())
        .then(data => {
            let bounds = [];
            const layerJembatan = L.layerGroup();
            data.forEach(function(item) {
                const latlng = parseLatLng(item.coords);

                // jika coords rusak → skip
                if (!latlng) {
                    console.warn('Koordinat invalid:', item.nama_jemb, item.coords);
                    return;
                }

                const marker = L.marker(latlng);
                layerJembatan.addTo(map);

                bounds.push(latlng);
                marker.bindPopup(`
                <b>${item.nama_jemb}</b><br>
                No Jembatan: ${item.no_jemb}<br>
                Nama Ruas Jembatan: ${item.nama_ruas_jemb}<br>
            `);

                layerJembatan.addLayer(marker);

            });
            if (bounds.length > 0) {
                map.fitBounds(bounds);
            }
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

<div class="flex flex-col gap-2">
    <h1 class="text-3xl md:text-4xl font-bold tracking-tight text-text-main">Jembatan</h1>
    <p class="text-text-muted text-lg">source : Dinas PUPR Lampung Timur.</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-6 mt-6">
    <div class="bg-surface border border-border-light rounded-xl p-4 md:p-6 shadow-card">
        <h3 class="text-base md:text-lg font-bold text-text-main mb-4">Kondisi Jembatan</h3>
        <div class="h-64">
            <canvas id="bridgeConditionChart"></canvas>
        </div>
    </div>
    <div class="bg-surface border border-border-light rounded-xl overflow-hidden flex flex-col shadow-card">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs md:text-sm">
                <thead>
                    <tr class="bg-gray-50/80 border-b border-border-light text-text-muted uppercase tracking-wider font-semibold">
                        <th class="p-3 md:p-4 whitespace-nowrap">Kondisi</th>
                        <th class="p-3 md:p-4 whitespace-nowrap text-right md:text-left">Jumlah</th>
                        <th class="p-3 md:p-4 whitespace-nowrap text-right">Presentase</th>
                    </tr>
                </thead>
                <tbody class="text-text-main divide-y divide-border-light">
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="p-3 md:p-4"><span class="inline-flex items-center gap-2"><span class="w-2 h-2 md:w-3 md:h-3 rounded-full" style="background-color: #2ecc71;"></span><span>Baik</span></span></td>
                        <td class="p-3 md:p-4 text-right md:text-left">45</td>
                        <td class="p-3 md:p-4 text-right">45%</td>
                    </tr>
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="p-3 md:p-4"><span class="inline-flex items-center gap-2"><span class="w-2 h-2 md:w-3 md:h-3 rounded-full" style="background-color: #f39c12;"></span>Cukup</span></td>
                        <td class="p-3 md:p-4 text-right md:text-left">28</td>
                        <td class="p-3 md:p-4 text-right">28%</td>
                    </tr>
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="p-3 md:p-4"><span class="inline-flex items-center gap-2"><span class="w-2 h-2 md:w-3 md:h-3 rounded-full" style="background-color: #e74c3c;"></span>Rusak Ringan</span></td>
                        <td class="p-3 md:p-4 text-right md:text-left">18</td>
                        <td class="p-3 md:p-4 text-right">18%</td>
                    </tr>
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="p-3 md:p-4"><span class="inline-flex items-center gap-2"><span class="w-2 h-2 md:w-3 md:h-3 rounded-full" style="background-color: #c0392b;"></span>Rusak Berat</span></td>
                        <td class="p-3 md:p-4 text-right md:text-left">9</td>
                        <td class="p-3 md:p-4 text-right">9%</td>
                    </tr>
                    <tr class="bg-gray-50/80 border-t-2 border-border-light font-semibold">
                        <td class="p-3 md:p-4">Total</td>
                        <td class="p-3 md:p-4 text-right md:text-left">100</td>
                        <td class="p-3 md:p-4 text-right">100%</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Bridge Condition Chart
    const conditionCtx = document.getElementById('bridgeConditionChart').getContext('2d');
    new Chart(conditionCtx, {
        type: 'doughnut',
        data: {
            labels: ['Baik', 'Cukup', 'Rusak Ringan', 'Rusak Berat'],
            datasets: [{
                data: [45, 28, 18, 9],
                backgroundColor: ['#2ecc71', '#f39c12', '#e74c3c', '#c0392b'],
                borderColor: '#fff',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        font: { size: 11 },
                        color: '#333',
                        padding: 10
                    }
                }
            }
        }
    });
</script>

<div class="flex flex-col lg:flex-row gap-4 justify-between items-center bg-surface border border-border-light p-2 rounded-xl shadow-sm">
    <div class="flex gap-2 overflow-x-auto w-full lg:w-auto px-2 pb-2 lg:pb-0 scrollbar-hide">
        <button class="flex h-9 shrink-0 items-center justify-center gap-x-2 rounded-full bg-primary text-white px-4 text-sm font-semibold shadow-sm transition-transform active:scale-95">
            <span>All Segments</span>
        </button>
        <button class="flex h-9 shrink-0 items-center justify-center gap-x-2 rounded-full bg-white border border-border-light hover:bg-gray-50 text-text-muted hover:text-text-main px-4 text-sm transition-colors">
            <span>High Priority</span>
            <span class="material-symbols-outlined text-[18px]">arrow_drop_down</span>
        </button>
        <button class="flex h-9 shrink-0 items-center justify-center gap-x-2 rounded-full bg-white border border-border-light hover:bg-gray-50 text-text-muted hover:text-text-main px-4 text-sm transition-colors">
            <span>Region: North</span>
            <span class="material-symbols-outlined text-[18px]">arrow_drop_down</span>
        </button>
        <button class="flex h-9 shrink-0 items-center justify-center gap-x-2 rounded-full bg-white border border-border-light hover:bg-gray-50 text-text-muted hover:text-text-main px-4 text-sm transition-colors">
            <span>Status: Active</span>
            <span class="material-symbols-outlined text-[18px]">arrow_drop_down</span>
        </button>
    </div>
    <div class="w-full lg:w-auto flex items-center bg-gray-50 rounded-full px-3 h-10 border border-transparent focus-within:border-primary focus-within:bg-white focus-within:shadow-sm mx-2 lg:mx-0 transition-all">
        <span class="material-symbols-outlined text-text-muted text-[20px]">filter_list</span>
        <input class="bg-transparent border-none text-sm text-text-main placeholder-text-muted focus:ring-0 w-full lg:w-64 h-full" placeholder="Filter by keywords..." type="text" />
    </div>
</div>

<div class="bg-surface border border-border-light rounded-xl overflow-hidden flex flex-col shadow-card">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50/80 border-b border-border-light text-text-muted text-xs uppercase tracking-wider font-semibold">
                    <th class="p-4 whitespace-nowrap">Aksi</th>
                    <th class="p-4 whitespace-nowrap">Nama</th>
                    <th class="p-4 whitespace-nowrap">Panjang (m)</th>
                    <th class="p-4 whitespace-nowrap">Fungsi</th>
                    <th class="p-4 whitespace-nowrap">Kecamatan</th>
                    <th class="p-4 whitespace-nowrap">Wilayah</th>
                    <th class="p-4 whitespace-nowrap">No Ruas</th>
                    <th class="p-4 whitespace-nowrap">Jumlah Titik</th>
                </tr>
            </thead>
            <tbody class="text-text-main text-sm divide-y divide-border-light">

            </tbody>
        </table>
    </div>

</div>

<div class="w-full h-48 rounded-2xl overflow-hidden relative border border-border-light mt-4 shadow-card">
    <div class="absolute inset-0 bg-cover bg-center transition-all duration-700 hover:scale-105" data-alt="Map view showing road networks with heatmaps overlaid on city streets" data-location="Toronto" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuASDfGZvelAlpriNvt4bHUkbl4dq0R-H-FiVJ4mUpc05kjh5YmFvLhl1sNDEQa1qpGRj4TOjUDEfJgEXHrYXXYfOIeN8s8aHF29G7Jh0TrxTb3t1nhb7okwzgapU3j4GHXxkmzHjLdU2bZdM9qyqTyXRoV66U9rXuDf1zvuj3mnNVEvVIEmV3Yu5PdYiXzzOo7mXsHraKn-IEn5iXkVEZ-fJsbvCHQEMZeFg81JED4eq-kvSII3MCzbvrtTcwFUo5IC9WA7tFBXxw_U");'>
    </div>

</div>
@endsection