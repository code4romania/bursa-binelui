<template>
    <div id="map" class="rounded-lg h-[550px]" />
</template>

<script setup>
    /** Import from vue. */
    import { ref, onMounted } from 'vue';
    import { usePage } from '@inertiajs/vue3';
    import * as GM from '@googlemaps/markerclusterer';
    const { MarkerClusterer } = GM;

    /** Component props. */
    const props = defineProps({ data: Array });

    /** Component emits */
    const emit = defineEmits(['county-selected']);

    const map = ref(null);
    const selectedCounties = ref([]);

    const page = usePage();

    /** Intialize google map. */
    async function initializeMap() {
        return new Promise((resolve, reject) => {
            if (window?.google !== undefined) {
                return resolve(window.google);
            }

            const script = document.createElement('script');
            script.src = 'https://maps.googleapis.com/maps/api/js?key=' + page.props.google_maps_api_key;
            script.async = true;
            script.defer = true;

            script.onload = () => {
                resolve(window.google);
            };

            script.onerror = () => {
                reject(new Error('Failed to load Google Maps API'));
            };

            document.head.appendChild(script);
        });
    }

    /** Generate map markers for each county */
    const generateMapMarkers = async () => {
        const google = await initializeMap();
        const { Map } = await google.maps.importLibrary('maps');
        const { AdvancedMarkerElement, PinElement } = await google.maps.importLibrary('marker');

        /** Map options, */
        const mapOptions = {
            center: { lat: 45.9432, lng: 24.9668 },
            zoom: 7,
            mapId: '63407f7951bfa43b',
        };

        const map = new Map(document.getElementById('map'), mapOptions);

        props.data.forEach((county) => {
            const pin = new PinElement({
                glyph: `${county.projects_count}`,
                background: '#00438A',
                glyphColor: '#FFF',
                borderColor: '#A8D2FF',
                scale: 1.4,
            });

            const marker = new AdvancedMarkerElement({
                position: { lat: county.lat, lng: county.long },
                map: map,
                title: county.name,
                content: pin.element,
            });

            marker.addListener('click', () => emit('county-selected', county.id));
        });
    };

    onMounted(() => {
        generateMapMarkers();
    });
</script>
