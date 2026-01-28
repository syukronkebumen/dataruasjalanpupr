@extends('landingpage')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
        <div class="flex flex-col gap-4 p-6 rounded-xl bg-surface shadow-card relative overflow-hidden group hover:shadow-md transition-shadow">
            <div class="absolute right-0 top-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
            <span class="material-symbols-outlined text-6xl text-primary">route</span>
            </div>
            <div class="flex items-center gap-2 text-primary">
            <span class="bg-primary/10 p-1 rounded text-primary">
                <span class="material-symbols-outlined text-xl block">timeline</span>
            </span>
            <span class="text-xs font-bold uppercase tracking-wider text-text-muted">Total Panjang</span>
            </div>
            <p class="text-3xl font-bold text-text-main"> {{ $totalPanjangFull }} <span class="text-lg text-text-muted font-normal">km</span></p>
            <div class="w-full bg-gray-100 h-1.5 rounded-full mt-1">
            <div class="bg-primary h-1.5 rounded-full" style="width: 75%"></div>
            </div>
        </div>
        <div class="flex flex-col gap-4 p-6 rounded-xl bg-surface shadow-card relative overflow-hidden group hover:shadow-md transition-shadow">
            <div class="absolute right-0 top-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
            <span class="material-symbols-outlined text-6xl text-blue-500">traffic</span>
            </div>
            <div class="flex items-center gap-2 text-blue-500">
            <span class="bg-blue-50 p-1 rounded text-blue-500">
                <span class="material-symbols-outlined text-xl block">speed</span>
            </span>
            <span class="text-xs font-bold uppercase tracking-wider text-text-muted">Indeks Kemantapan</span>
            </div>
            <p class="text-3xl font-bold text-text-main">{{ $indeksKemantapan }}% <span class="text-lg text-text-muted font-normal"></span></p>
            <div class="w-full bg-gray-100 h-1.5 rounded-full mt-1">
            <div class="bg-blue-400 h-1.5 rounded-full" style="width: 85%"></div>
            </div>
        </div>
        <div class="flex flex-col gap-4 p-6 rounded-xl bg-surface shadow-card relative overflow-hidden group hover:shadow-md transition-shadow">
            <div class="absolute right-0 top-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
            <span class="material-symbols-outlined text-6xl text-purple-500">verified</span>
            </div>
            <div class="flex items-center gap-2 text-purple-500">
            <span class="bg-purple-50 p-1 rounded text-purple-500">
                <span class="material-symbols-outlined text-xl block">check_circle</span>
            </span>
            <span class="text-xs font-bold uppercase tracking-wider text-text-muted">Jumlah Jembatan</span>
            </div>
            <p class="text-3xl font-bold text-text-main">{{ $totalJembatan }} buah</span></p>
            <div class="w-full bg-gray-100 h-1.5 rounded-full mt-1">
            <div class="bg-purple-400 h-1.5 rounded-full" style="width: 90%"></div>
            </div>
        </div>
    </div>
    
    <div class="flex flex-col xl:flex-row gap-6 justify-between items-start xl:items-end">
    <div class="flex flex-col gap-2">
        <h1 class="text-3xl md:text-4xl font-bold tracking-tight text-text-main">Data Ruas Jalan</h1>
        <p class="text-text-muted text-lg">Data mengenai ruas jalan dan kondisi infrastruktur di Lampung Timur.</p>
    </div>
    <div class="flex gap-3">
        <button class="flex items-center gap-2 h-10 px-5 rounded-full bg-white border border-border-light text-text-main hover:bg-surface-highlight hover:border-gray-300 transition-all text-sm font-medium shadow-sm" onclick="exportToExcel()">
            <span class="material-symbols-outlined text-[18px]">download</span>
            Export Data
        </button>

        <script>
        
        </script>
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
        subdomains:['mt0','mt1','mt2','mt3']
        }),

        "OpenStreetMap": L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19
        }),

        "Google Hybrid": L.tileLayer('https://{s}.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
        maxZoom: 20,
        subdomains:['mt0','mt1','mt1','mt3']
        }),

        "Google Satellite": L.tileLayer('https://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
        maxZoom: 20,
        subdomains:['mt0','mt1','mt2','mt3']
        }),

        "Google Terrain": L.tileLayer('https://{s}.google.com/vt/lyrs=p&x={x}&y={y}&z={z}', {
        maxZoom: 20,
        subdomains:['mt0','mt1','mt2','mt3']
        })
    };

    // Default base map
    baseLayers["Google Map"].addTo(map);

    // Set map center to Lampung Timur, Indonesia
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: 'lampungtimurkab.go.id',
        maxZoom: 19
    }).addTo(map);

    // Overlay Batas Wilayah Lampung Timur
    const batasWilayahLamtim = L.geoJSON(null, {
        style: function (feature) {
        return {
            color: '#2c3e50',
            weight: 2,
            fillColor: '#3498db',
            fillOpacity: 0.1
        };
        }
    });

    const batasKecamatanLamtim = L.geoJSON(null, {
        style: function (feature) {
        return {
            color: '#27ae60',
            weight: 1,
            fillColor: '#2ecc71',
            fillOpacity: 0.1
        };
        },
        onEachFeature: function (feature, layer) {
        layer.bindPopup(`
            <div><strong>Kecamatan:</strong> ${feature.properties.nm_kecamatan}</div>`);
        }
    });

    const batasKelurahanLamtim = L.geoJSON(null, {
        style: function (feature) {
        return {
            color: '#8e44ad',
            weight: 1,
            fillColor: '#9b59b6',
            fillOpacity: 0.2
        };
        },
        onEachFeature: function (feature, layer) {
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
    <h1 class="text-3xl md:text-4xl font-bold tracking-tight text-text-main">Data Jalan</h1>
    <p class="text-text-muted text-lg">source : Dinas PUPR Lampung Timur.</p>
    </div>

    <div class="flex flex-col lg:flex-row gap-4 justify-between items-center bg-surface border border-border-light p-2 rounded-xl shadow-sm">
    <div class="flex gap-2 overflow-x-auto w-full lg:w-auto px-2 pb-2 lg:pb-0 scrollbar-hide">
        <button class="flex h-9 shrink-0 items-center justify-center gap-x-2 rounded-full bg-primary text-white px-4 text-sm font-semibold shadow-sm transition-transform active:scale-95">
        <span>Semua</span>
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
        <input class="bg-transparent border-none text-sm text-text-main placeholder-text-muted focus:ring-0 w-full lg:w-64 h-full" placeholder="Cari ruasjalan..." type="text" id="searchInputRuas" />
    </div>
    </div>

    <div id="data-wrapper">
        @include('landingpage.partials.list')
    </div>
            
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script>
    $(document).ready(function() {

    $('#searchInputRuas').on('keyup', function() {
        var query = $(this).val();
        $.ajax({
        url: '/api/ruasjalan/search',
        method: 'GET',
        data: { query: query },
        success: function(data) {
            // Update the table with the search results
            // Assuming you have a function to update the table
            updateTable(data);
        },
        error: function() {
            console.error('Error fetching search results');
        }
        });
    });
    });

    function updateTable(data) {
    // Clear existing rows
    $('tbody#ruasjalanTable').empty();
    // Append new rows based on the search results
    data.forEach(function(item) {
        $('tbody#ruasjalanTable').append(`
        <tr class="hover:bg-primary-light/30 transition-colors group cursor-pointer">
            <td class="p-4">
                <a href="/detail/${item.id_ruasjln}" target="_blank" class="flex items-center gap-2 px-3 py-2 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 transition-colors text-sm font-medium border border-blue-200">
                <span class="material-symbols-outlined text-[18px]">visibility</span>
                Detail
                </a>
            </td>
            <td class="p-4 font-semibold text-text-main">${item.nama_ruasjln}</td>
            <td class="p-4 text-text-muted">${item.panjang_jln}</td>
            <td class="p-4 font-medium">${item.id_fungsijln}</td>
            <td class="p-4">${item.kec_jalan}</td>
            <td class="p-4">
                <span class="px-2.5 py-1 rounded-md bg-green-50 text-green-600 border border-green-100 text-xs font-semibold">${item.wilayah}</span>
            </td>
            <td class="p-4 font-mono">${item.no_ruasjln}</td>
            <td class="p-4 text-center">${item.jumlah_titik}</td>
        </tr>
        `);
    });
    }

    // Export to Excel function
    function exportToExcel() {
        fetch('/api/ruasjalan/export', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
            }
        })
        .then(response => response.blob())
        .then(blob => {
            const url = window.URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.href = url;
            link.setAttribute('download', `Data_Ruas_Jalan_${new Date().toISOString().split('T')[0]}.xlsx`);
            document.body.appendChild(link);
            link.click();
            link.parentNode.removeChild(link);
            window.URL.revokeObjectURL(url);
        })
        .catch(error => {
            console.error('Error exporting data:', error);
            alert('Gagal mengekspor data');
        });
    }

    // pagination
    $(document).on('click', 'nav[aria-label="Pagination Navigation"] a[href]', function(e) {
        e.preventDefault();

        let url = $(this).attr('href');

        $.ajax({
            url: url,
            type: "GET",

            beforeSend: function () {
                $('#data-wrapper').html(`
                    <div class="flex justify-center py-6">
                        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-gray-900"></div>
                    </div>
                `);
            },

            success: function(data) {
                $('#data-wrapper').html(data);
                window.history.pushState("", "", url);
            },
            error: function(e) {
                console.error('Gagal load data:', e);
                alert('Gagal load data');
            }
        });
    });
</script>