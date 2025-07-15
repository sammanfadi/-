/**
 * Mohtawa Theme Map JavaScript
 */

(function($) {
    $(document).ready(function() {
        var map = L.map('mohtawa-map').setView([24.7136, 46.6753], 12); // Default to Riyadh, Saudi Arabia

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        var markers = [];

        // Function to add a single store marker
        function addStoreMarker(store) {
            var marker = L.marker([store.lat, store.lng]).addTo(map);
            marker.bindPopup('<b>' + store.name + '</b><br>' + store.address + '<br><a href="' + store.link + '">View Details</a>');
            markers.push(marker);
        }

        // Function to load stores via AJAX
        function loadStores(filters) {
            $.ajax({
                url: mohtawa_map_vars.ajax_url,
                type: 'POST',
                data: {
                    action: 'mohtawa_load_stores',
                    filters: filters
                },
                success: function(response) {
                    // Clear existing markers
                    markers.forEach(function(marker) {
                        map.removeLayer(marker);
                    });
                    markers = [];

                    if (response.success && response.data.length > 0) {
                        response.data.forEach(function(store) {
                            addStoreMarker(store);
                        });
                    } else {
                        console.log('No stores found or error:', response.data);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                }
            });
        }

        // Initial load of stores
        loadStores({});

        // Example: Filter stores by category (this would be triggered by UI elements)
        $('#filter-category').on('change', function() {
            var category = $(this).val();
            loadStores({ category: category });
        });

        // Example: Search stores by keyword
        $('#search-input').on('keyup', function() {
            var keyword = $(this).val();
            loadStores({ keyword: keyword });
        });

        // Geolocation: Find user's current location
        $('#find-my-location').on('click', function() {
            map.locate({
                setView: true, 
                maxZoom: 16
            });
        });

        map.on('locationfound', function(e) {
            L.marker(e.latlng).addTo(map)
                .bindPopup('You are here!').openPopup();
        });

        map.on('locationerror', function(e) {
            alert(e.message);
        });

    });
})(jQuery);

