<template>
    <div id="map" class="rounded-lg h-[550px]"></div>
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
const filterProjects = (county) => {
    emit('county-selected', county.id);
};

/** Generate map markers for each county */
const generateMapMarkers = async () => {
    /** Render map. */
    const google = await initializeMap();

    /** Map options, */
    const mapOptions = {
        center: { lat: 45.9432, lng: 24.9668 },
        zoom: 7,
        mapId: '63407f7951bfa43b',
    };
    const { Map } = await google.maps.importLibrary('maps');

    const map = new Map(document.getElementById('map'), mapOptions);

    const { AdvancedMarkerElement, PinElement } = await google.maps.importLibrary('marker');
    // const { AdvancedMarkerElement } = await google.maps.importLibrary('marker');
    props.data.forEach((county) => {
        {
            console.log(county);
            let scale = 1;
            switch (true) {
                case county.projects_count > 1:
                    scale = 1.2;
                    break;
                case county.projects_count > 20:
                    scale = 1.4;
                    break;
                case county.projects_count > 30:
                    scale = 1.6;
                    break;
                case county.projects_count > 40:
                    scale = 1.8;
                    break;
                case county.projects_count > 50:
                    scale = 2;
            }
            console.log(scale);
            const pinNoGlyph = new PinElement({
                glyph: `${county.projects_count}`,
                background: '#00438A',
                glyphColor: '#fff',
                borderColor: '#A8D2FF',
                scale: scale,
            });
            const position = { lat: parseFloat(county.lat), lng: parseFloat(county.long) };
            const marker = new AdvancedMarkerElement({
                position: position,
                map: map,
                title: county.name,
                content: pinNoGlyph.element,
            });
            marker.addListener('click', () => filterProjects(county, marker));
        }
    });
};

onMounted(() => {
    generateMapMarkers();
});
</script>
