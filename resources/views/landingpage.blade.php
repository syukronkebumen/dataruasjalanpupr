<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <title>Road Segment Data Display</title>
  <link href="https://fonts.googleapis.com" rel="preconnect" />
  <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
  <link href="https://fonts.googleapis.com/css2?family=Spline+Sans:wght@300;400;500;600;700&amp;family=Noto+Sans:wght@400;500;700&amp;display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  <script id="tailwind-config">
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            "primary": "#10b981", // Emerald 500 for a fresh look
            "primary-dark": "#059669",
            "primary-light": "#ecfdf5",
            "background-base": "#f8fafc", // Very light slate/white
            "surface": "#ffffff",
            "surface-highlight": "#f1f5f9",
            "border-light": "#e2e8f0",
            "text-main": "#1e293b", // Slate 800
            "text-muted": "#64748b", // Slate 500
          },
          fontFamily: {
            "display": ["Spline Sans", "sans-serif"],
            "body": ["Spline Sans", "sans-serif"]
          },
          borderRadius: {
            "DEFAULT": "0.75rem",
            "lg": "1rem",
            "xl": "1.5rem",
            "2xl": "2rem",
            "full": "9999px"
          },
          boxShadow: {
            'soft': '0 4px 6px -1px rgba(0, 0, 0, 0.02), 0 2px 4px -1px rgba(0, 0, 0, 0.02)',
            'card': '0 0 0 1px rgba(226, 232, 240, 1), 0 2px 4px rgba(0,0,0,0.02)',
          }
        },
      },
    }
  </script>
  <style>
    ::-webkit-scrollbar {
      width: 8px;
      height: 8px;
    }

    ::-webkit-scrollbar-track {
      background: #f1f5f9;
    }

    ::-webkit-scrollbar-thumb {
      background: #cbd5e1;
      border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb:hover {
      background: #94a3b8;
    }

    .scrollbar-hide::-webkit-scrollbar {
      display: none;
    }

    .scrollbar-hide {
      -ms-overflow-style: none;
      scrollbar-width: none;
    }
  </style>
</head>

<body class="bg-background-base text-text-main font-display min-h-screen flex flex-col overflow-x-hidden antialiased selection:bg-primary selection:text-white">
  <header class="sticky top-0 z-50 w-full border-b border-border-light bg-surface/80 backdrop-blur-md">
    <div class="px-6 lg:px-10 py-4 flex items-center justify-between">
      <div class="flex items-center gap-8">
        <div class="flex items-center gap-2 text-primary">
          <div class="bg-primary/10 p-1.5 rounded-lg">
            <span class="material-symbols-outlined text-3xl">add_road</span>
          </div>
          <h2 class="text-text-main text-xl font-bold tracking-tight">PUPR</h2>
        </div>
        <nav class="hidden md:flex items-center gap-8 pl-4">
          <a class="text-primary text-sm font-semibold bg-primary-light px-3 py-1.5 rounded-full" href="#">Dashboard</a>
          <a class="text-text-muted hover:text-primary transition-colors text-sm font-medium" href="#">Reports</a>
          <a class="text-text-muted hover:text-primary transition-colors text-sm font-medium" href="#">Settings</a>
        </nav>
      </div>
      <div class="flex items-center gap-6">
        <div class="hidden lg:flex items-center bg-surface-highlight border border-transparent hover:border-border-light rounded-full px-4 h-10 w-64 focus-within:border-primary focus-within:bg-white focus-within:shadow-soft transition-all duration-300">
          <span class="material-symbols-outlined text-text-muted text-[20px]">search</span>
          <input class="bg-transparent border-none text-sm text-text-main placeholder-text-muted focus:ring-0 w-full h-full" placeholder="Search ID or Region..." type="text" />
        </div>
        <button class="relative text-text-muted hover:text-primary transition-colors p-2 hover:bg-surface-highlight rounded-full">
          <span class="material-symbols-outlined">notifications</span>
          <span class="absolute top-2 right-2 size-2 bg-red-500 rounded-full border-2 border-surface"></span>
        </button>
        <div class="h-10 w-10 rounded-full bg-cover bg-center border-2 border-white shadow-sm cursor-pointer ring-2 ring-transparent hover:ring-primary/20 transition-all" data-alt="User profile avatar image showing a person smiling" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuArmfQJt5-eRKu2lLRoPSNFpn7bKtWEJu2Rj8swMobdAZzEQkmcLKZC_e902-tuC02hoVDK1MxlpbCE6VCKOu0h3BABSPN5xJKuHRARwTgsekID464BUt9gdzDyyUG8wSFqA7aurinMTcjk8EM4296SZa2P8oQqdj93WbQEyONL1F4dQvgZklrrdCFIyHrYjVc9yIlsipseMMUuiePRSpvJFmaucy-0aSA7ZK-5T07E97-FQqocJX2bjPRiBYH1LG1Ygx0q4jw9BxqO");'>
        </div>
      </div>
    </div>
  </header>
  <main class="flex-1 flex justify-center py-8 px-4 lg:px-8">
    <div class="w-full max-w-[1400px] flex flex-col gap-8">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
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
            <p class="text-3xl font-bold text-text-main">{{ number_format($datas->sum('panjang'), 0, ',', '.') }} <span class="text-lg text-text-muted font-normal">meter</span></p>
          <div class="w-full bg-gray-100 h-1.5 rounded-full mt-1">
            <div class="bg-primary h-1.5 rounded-full" style="width: 75%"></div>
          </div>
        </div>
        <div class="flex flex-col gap-4 p-6 rounded-xl bg-surface shadow-card relative overflow-hidden group hover:shadow-md transition-shadow">
          <div class="absolute right-0 top-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
            <span class="material-symbols-outlined text-6xl text-orange-500">warning</span>
          </div>
          <div class="flex items-center gap-2 text-orange-500">
            <span class="bg-orange-50 p-1 rounded text-orange-500">
              <span class="material-symbols-outlined text-xl block">construction</span>
            </span>
            <span class="text-xs font-bold uppercase tracking-wider text-text-muted">Ruas Jalan</span>
          </div>
          <p class="text-3xl font-bold text-text-main">{{ $countRuasJalan }} <span class="text-lg text-text-muted font-normal">ruas</span></p>
          <div class="w-full bg-gray-100 h-1.5 rounded-full mt-1">
            <div class="bg-orange-400 h-1.5 rounded-full" style="width: 12%"></div>
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
            <span class="text-xs font-bold uppercase tracking-wider text-text-muted">Traffic Flow</span>
          </div>
          <p class="text-3xl font-bold text-text-main">85% <span class="text-lg text-text-muted font-normal">capacity</span></p>
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
            <span class="text-xs font-bold uppercase tracking-wider text-text-muted">Condition Index</span>
          </div>
          <p class="text-3xl font-bold text-text-main">4.2 <span class="text-lg text-text-muted font-normal">/ 5.0</span></p>
          <div class="w-full bg-gray-100 h-1.5 rounded-full mt-1">
            <div class="bg-purple-400 h-1.5 rounded-full" style="width: 90%"></div>
          </div>
        </div>
      </div>
      
      <div class="flex flex-col xl:flex-row gap-6 justify-between items-start xl:items-end">
        <div class="flex flex-col gap-2">
          <h1 class="text-3xl md:text-4xl font-bold tracking-tight text-text-main">Data Ruas Jalan</h1>
          <p class="text-text-muted text-lg">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Mollitia, facere.</p>
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
          attribution: '© diskominfo.lampungtimurkab.go.id',
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
                    <b>${item.name}</b><br>
                    Panjang: ${item.panjang}<br>
                    Fungsi: ${item.fungsi}<br>
                    Kecamatan: ${item.kecamatan}<br>
                    Wilayah: ${item.wilayah}<br>
                    No Ruas: ${item.no_ruas}<br>
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
                <th class="p-4 whitespace-nowrap">ID</th>
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
              @foreach($datas as $item)

              <tr class="hover:bg-primary-light/30 transition-colors group cursor-pointer">
                <td class="p-4 font-mono text-primary font-medium">{{ $item['id'] }}</td>
                <td class="p-4 font-semibold text-text-main">{{ $item['name'] }}</td>
                <td class="p-4 text-text-muted">{{ $item['panjang'] }}</td>
                <td class="p-4 font-medium">{{ $item['fungsi'] }}</td>
                <td class="p-4">{{ $item['kecamatan'] }}</td>
                <td class="p-4">
                  <span class="px-2.5 py-1 rounded-md bg-green-50 text-green-600 border border-green-100 text-xs font-semibold">{{ $item['wilayah'] }}</span>
                </td>
                <td class="p-4 font-mono">{{ $item['no_ruas'] }}</td>
                <td class="p-4 text-center">{{ $item['jumlah_titik'] }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <div class="flex flex-col sm:flex-row justify-between items-center p-4 border-t border-border-light gap-4 bg-gray-50/50">
          <p class="text-sm text-text-muted">Showing <span class="text-text-main font-semibold">{{ $datas->firstItem() }}</span> to <span class="text-text-main font-semibold">{{ $datas->lastItem() }}</span> of <span class="text-text-main font-semibold">{{ $datas->total() }}</span> segments</p>
          <div class="flex items-center gap-2">
            {{ $datas->links('pagination::tailwind') }}
          </div>
        </div>
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
    </div>
  </main>

</body>

</html>