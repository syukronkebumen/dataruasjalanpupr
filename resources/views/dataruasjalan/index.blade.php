@extends('landingpage')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Data ruas Jalan</h1>
        </div>

        <div class="section-body">
            <h2 class="section-title">Data ruas Jalan</h2>
            <div class="row">
                <div class="col-md-12">
                    <div id="map" style="height: 600px; border-radius: 5px;"></div>
                </div>
            </div>
        </div>
    </section>
</div>

@section('scripts')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js"></script>

<script>
    // Initialize map
    const map = L.map('map').setView([-6.2088, 106.8456], 11);

    // Add tile layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors',
        maxZoom: 19
    }).addTo(map);

    // Add markers and features here
    L.marker([-6.2088, 106.8456]).addTo(map)
        .bindPopup('Jakarta, Indonesia');
</script>
@endsection

@endsection