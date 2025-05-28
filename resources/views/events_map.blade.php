<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Events On Map</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        .gm-style .card {
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

</head>

<body>
    <!-- Map Section -->
    <section class="map vh-100 vw-100" style="position:relative; min-height:100vh; width:100%;">
        <div class="container-fluid h-100 w-100 p-0 m-0">
            <div id="map" style="height:100vh; width:100vw;"></div>
        </div>
    </section>

    <!-- Pass PHP Events Data to JavaScript -->
    <script>
        const events = @json($events);
        console.log(events);
    </script>


    <!-- Google Maps API with callback -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA5cCqwCCPnIh9d_LEU49FTM8n4VjEUBlI&callback=initMap"
        async defer></script>

    <script>
        function getEventLatLng(event) {
            if (event.latitude && event.longitude) {
                return { lat: parseFloat(event.latitude), lng: parseFloat(event.longitude) };
            }
            return { lat: 24.7136, lng: 46.6753 }; // Default fallback
        }

        function createEventCard(event) {
            const title = event.title?.en || event.title?.ar || 'Untitled';
            const sectorName = event.sector?.name?.en || event.sector?.name?.ar || 'N/A';
            const event_type = event.event_type || 'Not specified';
            const event_date = event.event_date || 'Not specified';
            const event_status = event.event_status || 'Not specified';

            return `
                <div class="card shadow-sm border-0" style="width: 20rem;">
                    <div class="card-body">
                        <h5 class="card-title text-primary mb-2">
                            <i class="bi bi-geo-alt-fill me-1 text-danger"></i> ${title}
                        </h5>
                        <p class="card-subtitle mb-2 text-muted">
                            <i class="bi bi-globe2 me-1"></i> ${event_type}
                        </p>
                        <ul class="list-unstyled small text-dark">
                            <li><i class="bi bi-diagram-3-fill me-1 text-info"></i><strong>Sector:</strong> ${sectorName}</li>
                            <li><i class="bi bi-building me-1 text-secondary"></i><strong>Event Date:</strong> ${event_date}</li>
                            <li><i class="bi bi-building me-1 text-secondary"></i><strong>Event Status:</strong> ${event_status}</li>
                        </ul>
                    </div>
                </div>
            `;
        }


        function initMap() {
            let center = { lat: 30.3753, lng: 69.3451 }; // Default center (Pakistan)
            if (events.length > 0) {
                center = getEventLatLng(events[0]);
            }

            const map = new google.maps.Map(document.getElementById('map'), {
                zoom: 5,
                center: center
            });

            events.forEach(event => {
                const position = getEventLatLng(event);
                const marker = new google.maps.Marker({
                    position: position,
                    map: map,
                    title: event.title || ''
                });

                const infowindow = new google.maps.InfoWindow({
                    content: createEventCard(event)
                });

                marker.addListener('click', () => {
                    infowindow.open(map, marker);
                });
            });
        }

        window.initMap = initMap;
    </script>
</body>

</html>