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

/** Intialize google map. */
async function initializeMap() {
    return new Promise((resolve, reject) => {
        if (window?.google !== undefined) {
            return resolve(window.google);
        }

        const script = document.createElement('script');
        script.src = 'https://maps.googleapis.com/maps/api/js?key=' + usePage().props.google_maps_api_key;
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
        // mapTypeId: google.maps.MapTypeId.ROADMAP,
        mapId: '63407f7951bfa43b',
    };
    const { Map } = await google.maps.importLibrary('maps');

    const map = new Map(document.getElementById('map'), mapOptions);

    const { AdvancedMarkerElement } = await google.maps.importLibrary('marker');

    let tmpCounties = [];
    let projects = props.data;
    props.data.map((project) => {
        project.counties.forEach((county) => {
            county.projects = projects.filter((p) => p.counties.filter((c) => c.id === county.id).length > 0).length;
            if (tmpCounties.filter((c) => c.id === county.id).length === 0) tmpCounties.push(county);
            else {
                let index = tmpCounties.findIndex((c) => c.id === county.id);
                tmpCounties[index].projects += county.projects;
            }
        });
    });
    tmpCounties.forEach((county) => {
        let markers = [];
        console.log(county);
        for (let project = 0; project < county.projects; project++) {
            const position = { lat: parseFloat(county.lat), lng: parseFloat(county.long) };
            const marker = new AdvancedMarkerElement({
                position: position,
                title: county.name,
                map: map.value,
            });
            marker.addListener('click', () => filterProjects(county, marker));
            markers.push(marker);
        }
        new MarkerClusterer({ map, markers, onClusterClick: () => filterProjects(county) });
    });
};

onMounted(() => {
    generateMapMarkers();
});
</script>
