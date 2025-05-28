<div
    x-data="{
        lat: @entangle('data.latitude'),
        lng: @entangle('data.longitude'),

        map: null,
        marker: null,

        initMap() {
            const defaultLat = this.lat || 24.7136;
            const defaultLng = this.lng || 46.6753;

            this.map = L.map(this.$refs.map).setView([defaultLat, defaultLng], 6);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(this.map);

            if (this.lat && this.lng) {
                this.marker = L.marker([this.lat, this.lng]).addTo(this.map);
            }

            this.map.on('click', (e) => {
                this.lat = e.latlng.lat.toFixed(7);
                this.lng = e.latlng.lng.toFixed(7);

                if (this.marker) {
                    this.marker.setLatLng(e.latlng);
                } else {
                    this.marker = L.marker(e.latlng).addTo(this.map);
                }
            });
        }
    }"
    x-init="initMap"
>
    <div x-ref="map" class="w-full h-96 rounded-md border shadow-sm"></div>
</div>


@once
    @push('styles')
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
    @endpush

    @push('scripts')
        <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
    @endpush
@endonce
