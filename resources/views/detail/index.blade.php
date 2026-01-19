@extends('landingpage')
@section('styles')
<style>
    #video-section {
        flex: 1;
        background: #000;
        position: relative;
        min-width: 300px;
    }

    #player {
        width: 100%;
        height: 100%;
    }

    /* === MAP === */
    #roadmap {
        width: 100%;
        height: 100%;
    }

    .status-overlay {
        position: absolute;
        bottom: 10px;
        left: 10px;
        background: rgba(0, 0, 0, 0.8);
        color: #00ff00;
        padding: 5px 12px;
        border-radius: 4px;
        font-size: 11px;
        z-index: 1000;
    }

    /* === RESPONSIVE MOBILE === */
    @media (max-width: 768px) {
        .container {
            flex-direction: column;
        }

        #video-section {
            height: 40%;
        }

        #roadmap {
            height: 60%;
        }
    }
</style>
@endsection
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
                <a href="/ruasjalan" class="flex items-center gap-2 h-10 px-5 rounded-full bg-white border border-border-light text-text-main hover:bg-surface-highlight hover:border-gray-300 transition-all text-sm font-medium shadow-sm">
                    <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                    Kembali
                </a>
            </div>
        </div>
    </div>
    <!-- <div id="map" class="w-full h-96 rounded-lg"></div> -->
</div>

@if ($data->id_ruasjln == 15)
<div class="bg-surface border border-border-light rounded-xl overflow-hidden shadow-card">
    <div class="flex flex-col xl:flex-row gap-6 h-96">
        <div class="xl:w-[50%]">
            <div id="video-section">
                <video id="player" controls>
                </video>

                <div class="status-overlay" id="status">
                </div>
            </div>
        </div>
        <div class="xl:w-[50%] flex-col gap-4 p-6 bg-surface-highlight">
            <div id="roadmap" style="height: 100%"></div>
        </div>
    </div>
</div>
@endif

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
    
    // visualisasi video dan peta sinkronisasi
    const youtubeId = 'FImt8Q6sOXo';
    const gpxRawUrl = 'https://raw.githubusercontent.com/lampungtimurkominfo-netizen/videomap/refs/heads/main/ruasjalan15.gpx';
    // === DATA JEMBATAN (TANPA UBAH GPX) ===
    
    const bridgePoint = {
        id: "KB-18-0007-0015-J001",
        name: "R.015-J01",
        road: "Adirejo - Batas Kota Metro (Karang Rejo)",
        lat: -5.0900361,
        lng: 105.3394861,
        zoom: 18
    };

    
    

    let roadmap, marker, player, trackLine, bridgeMarker;
    let routeData = []; 
    let isDataLoaded = false;

    // 1. Inisialisasi Peta
    roadmap = L.map('roadmap').setView([-5.094, 105.340], 15);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(roadmap);

    // === MARKER JEMBATAN ===
    bridgeMarker = L.marker(
        [bridgePoint.lat, bridgePoint.lng],
        {
            icon: L.divIcon({
            className: "bridge-icon",
            html: "🏗",
            iconSize: [30, 30],
            iconAnchor: [15, 30]
            })
        }
    ).addTo(roadmap);
    bridgeMarker.bindPopup(`
    <div style="font-size:13px; line-height:1.4">
        <b>🏗 ${bridgePoint.name}</b><br>
        <small>${bridgePoint.road}</small><br><br>

        <button onclick="focusBridge()"
            style="
                width:100%;
                margin-bottom:6px;
                padding:6px 10px;
                background:#2ecc71;
                color:white;
                border:none;
                border-radius:4px;
                cursor:pointer;">
            📍 Fokus ke Jembatan
        </button>

        <a href="https://www.google.com/maps?q=${bridgePoint.lat},${bridgePoint.lng}"
           target="_blank"
           style="
                display:block;
                text-align:center;
                padding:6px 10px;
                background:#3498db;
                color:white;
                text-decoration:none;
                border-radius:4px;">
            🗺 Buka di Google Maps
        </a>
    </div>
    `);

    // 2. Load & Parse GPX
    fetch(gpxRawUrl)
        .then(res => res.text())
        .then(xmlText => {
            const parser = new DOMParser();
            const xml = parser.parseFromString(xmlText, "text/xml");
            const points = xml.getElementsByTagName("wpt"); 
            
            if (points.length === 0) throw new Error("File GPX tidak terbaca atau kosong");

            let firstTime = null;
            let tempRoute = [];

            for (let i = 0; i < points.length; i++) {
                const lat = parseFloat(points[i].getAttribute("lat"));
                const lon = parseFloat(points[i].getAttribute("lon"));
                const timeStr = points[i].getElementsByTagName("time")[0]?.textContent;
                
                if (!isNaN(lat) && !isNaN(lon)) {
                    let seconds = 0;
                    if (timeStr) {
                        const currentTime = new Date(timeStr).getTime();
                        if (firstTime === null) firstTime = currentTime;
                        seconds = (currentTime - firstTime) / 1000;
                    } else {
                        seconds = i * 3; // Fallback jika tidak ada waktu
                    }
                    tempRoute.push({ time: seconds, lat: lat, lng: lon });
                }
            }

            routeData = tempRoute;

            // Gambar Jalur
            trackLine = L.polyline(routeData.map(d => [d.lat, d.lng]), {
                color: '#2ecc71', weight: 6, opacity: 0.8
            }).addTo(roadmap);

            function fixMapAfterIframeLoad() {
                setTimeout(() => {
                roadmap.invalidateSize(true);
            if (trackLine) {
                roadmap.fitBounds(trackLine.getBounds(), {
                    padding: [20, 20],
                    animate: false
                });
                }
                }, 300);
            }       

            roadmap.fitBounds(trackLine.getBounds());
            fixMapAfterIframeLoad();

            // Marker awal
            marker = L.circleMarker([routeData[0].lat, routeData[0].lng], {
                color: '#e74c3c', radius: 8, fillOpacity: 1, fillColor: 'white', weight: 3
            }).addTo(roadmap);

            isDataLoaded = true;
            // document.getElementById('status').innerText = "Selesai: " + routeData.length + " titik sinkron.";
            
            // Klik peta untuk seek video
            trackLine.on('click', (e) => {
                const closest = findClosestPoint(e.latlng);
                if (player) player.seekTo(closest.time, true);
            });
        })
        .catch(err => {
            document.getElementById('status').innerText = "Error: " + err.message;
            console.error(err);
        });

    // 3. YouTube API
    var tag = document.createElement('script');
    tag.src = "https://www.youtube.com/iframe_api";
    document.head.appendChild(tag);

    function onYouTubeIframeAPIReady() {
        player = new YT.Player('player', {
            videoId: youtubeId,
            playerVars: { 'rel': 0, 'showinfo': 0 },
            events: { 'onStateChange': onPlayerStateChange }
        });
    }

    function onPlayerStateChange(event) {
        if (event.data == YT.PlayerState.PLAYING) {
            requestAnimationFrame(smoothUpdate);
        }
    }

    // 4. Interpolasi Smooth
    function smoothUpdate() {
        if (!isDataLoaded || !player || player.getPlayerState() !== 1) return;

        const now = player.getCurrentTime();
        let currentPos = null;

        // Cari posisi di antara dua titik (Interpolasi)
        for (let i = 0; i < routeData.length - 1; i++) {
            const p1 = routeData[i];
            const p2 = routeData[i + 1];

            if (now >= p1.time && now <= p2.time) {
                const ratio = (now - p1.time) / (p2.time - p1.time);
                const lat = p1.lat + (p2.lat - p1.lat) * ratio;
                const lng = p1.lng + (p2.lng - p1.lng) * ratio;
                currentPos = [lat, lng];
                break;
            }
        }

        // Jika waktu video melebihi data GPX, ambil titik terakhir
        if (!currentPos && now > 0) {
            const last = routeData[routeData.length - 1];
            currentPos = [last.lat, last.lng];
        }

        if (currentPos) {
            marker.setLatLng(currentPos);
            // Opsional: aktifkan baris bawah jika ingin peta selalu mengikuti marker
            roadmap.panTo(currentPos); 
        }

        /* === AUTO POPUP SAAT MENDEKATI JEMBATAN === */
        const d = L.latLng(currentPos).distanceTo([bridgePoint.lat, bridgePoint.lng]);
        if (d < 15 && !bridgeMarker.isPopupOpen()) {
            bridgeMarker.openPopup();
        }
        
        requestAnimationFrame(smoothUpdate);
    }

    function findClosestPoint(latlng) {
        return routeData.reduce((prev, curr) => 
            L.latLng(curr.lat, curr.lng).distanceTo(latlng) < L.latLng(prev.lat, prev.lng).distanceTo(latlng) ? curr : prev
        );
    }

    function focusBridge() {
        roadmap.setView(
        [bridgePoint.lat, bridgePoint.lng],
        bridgePoint.zoom,
        { animate: true }
        );
    }
</script>


<div class="w-full h-48 rounded-2xl overflow-hidden relative border border-border-light mt-4 shadow-card">
    <div class="absolute inset-0 bg-cover bg-center transition-all duration-700 hover:scale-105" style='background-image: url("https://images.unsplash.com/photo-1524661135-423995f22d0b?w=1200&h=400&fit=crop");'>
    </div>
    <div class="absolute inset-0 bg-gradient-to-r from-white via-white/90 to-transparent flex items-center p-8 lg:p-12">
        <div class="flex flex-col gap-4 max-w-lg">
            <h3 class="text-2xl font-bold text-text-main">Detail Ruas Jalan</h3>
            <p class="text-text-muted font-medium">Lihat statistik lengkap, kondisi jalan, dan data pemeliharaan untuk ruas jalan {{ $data->nama_ruasjln }} di wilayah {{ $data->kec_jalan }}.</p>
            <a href="/ruasjalan" class="w-fit flex items-center gap-2 px-5 py-2.5 rounded-full bg-white hover:bg-gray-50 text-primary border border-primary/20 hover:border-primary/50 shadow-sm transition-all text-sm font-bold">
                <span class="material-symbols-outlined">arrow_back</span>
                Kembali ke Daftar
            </a>
        </div>
    </div>
</div>
@endsection