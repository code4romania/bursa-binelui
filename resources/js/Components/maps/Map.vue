<template>
    <div id="map" class="rounded-lg h-[550px]"></div>
</template>

<script setup>
/** Import from vue. */
import { ref, onMounted } from 'vue';
import { usePage } from '@inertiajs/vue3';

/** Component props. */
const props = defineProps({ data: Array });

/** Component emits */
const emit = defineEmits(['county-selected']);

const map = ref(null);
const selectedCounties = ref([]);

/** Intialize google map. */
async function initializeMap() {
    return new Promise((resolve, reject) => {
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

/** Generate custom marker. */
const generateMarkerIcon = (numberOfProjects, isActive = false) => {
    const fillColor = isActive ? '#41A6AC' : '#FFFFFF';

    const svgMarkup = `<svg width="58" height="67" viewBox="0 0 58 67" fill="none" xmlns="http://www.w3.org/2000/svg">
        <mask id="path-1-inside-1_1033_47195" fill="white">
        <path d="M49.5061 47.3762C60.8313 36.5382 60.8313 18.9664 49.5061 8.12846C38.1809 -2.70949 19.8191 -2.70949 8.4939 8.12846C-2.8313 18.9664 -2.8313 36.5382 8.4939 47.3762L29 67L49.5061 47.3762Z"/>
        </mask>
        <path d="M49.5061 47.3762C60.8313 36.5382 60.8313 18.9664 49.5061 8.12846C38.1809 -2.70949 19.8191 -2.70949 8.4939 8.12846C-2.8313 18.9664 -2.8313 36.5382 8.4939 47.3762L29 67L49.5061 47.3762Z" fill="${fillColor}"/>
        <path d="M49.5061 47.3762L48.8147 46.6537L49.5061 47.3762ZM8.4939 47.3762L7.80251 48.0986L8.4939 47.3762ZM29 67L28.3086 67.7225L29 68.3841L29.6914 67.7225L29 67ZM48.8147 8.85094C59.7284 19.2951 59.7284 36.2095 48.8147 46.6537L50.1975 48.0986C61.9342 36.8669 61.9342 18.6377 50.1975 7.40599L48.8147 8.85094ZM9.1853 8.85094C20.1238 -1.61698 37.8762 -1.61698 48.8147 8.85094L50.1975 7.40599C38.4856 -3.802 19.5144 -3.80199 7.80251 7.40599L9.1853 8.85094ZM9.1853 46.6537C-1.72843 36.2095 -1.72843 19.2951 9.1853 8.85094L7.80251 7.40599C-3.93417 18.6377 -3.93417 36.8669 7.80251 48.0986L9.1853 46.6537ZM29.6914 66.2775L9.1853 46.6537L7.80251 48.0986L28.3086 67.7225L29.6914 66.2775ZM48.8147 46.6537L28.3086 66.2775L29.6914 67.7225L50.1975 48.0986L48.8147 46.6537Z" fill="black" mask="url(#path-1-inside-1_1033_47195)"/>
        </svg>`;

    return `data:image/svg+xml;charset=UTF-8,${encodeURIComponent(svgMarkup)}`;
}

/** Filter projects based on marker selection. */
const filterProjects = (county, marker) => {

    if (false === marker.get('clicked')) {
        /** Zoom In and set coordoantes. */
        map.value.setZoom(10);
        map.value.panTo(county.coordinates);

        marker.setIcon({
            url: generateMarkerIcon(county.projects, true),
            scaledSize: new google.maps.Size(40, 40),
        });

        marker.setLabel({
            text: county.projects.toString(),
            color: '#FFFFFF',
            fontSize: '14px',
            fontWeight: 'bold',
        });

        marker.set('clicked', true);
        selectedCounties.value.push(county.id);
    } else if (true === marker.get('clicked')) {

        /** Zoom In and set coordoantes. */
        map.value.setZoom(7);
        map.value.panTo({ lat: 45.9432, lng: 24.9668 });

        marker.setIcon({
            url: generateMarkerIcon(county.projects, false),
            scaledSize: new google.maps.Size(40, 40),
        });

        marker.setLabel({
            text: county.projects.toString(),
            color: '#333',
            fontSize: '14px',
            fontWeight: 'bold',
        });

        selectedCounties.value = selectedCounties.value.filter(item => item !== county.id);
        marker.set('clicked', false);
    }
    emit('county-selected', selectedCounties.value);
}

/** Generate map markers for each county */
const generateMapMarkers = async () => {
    /** Render map. */
    const google = await initializeMap();

    /** Map options, */
    const mapOptions = {
        center: { lat: 45.9432, lng: 24.9668 },
        zoom: 7
    };

    /** Google map object, */
    map.value = new google.maps.Map(document.getElementById('map'), mapOptions);
    for (const county of props.data) {
        try {

            const markerIcon = {
                url: generateMarkerIcon(county.projects.length),
                scaledSize: new google.maps.Size(40, 40)
            };

            /** Marker options, */
            const marker = new google.maps.Marker({
                position: { lat: county.coordinates[0], lng: county.coordinates[1] },
                map: map.value,
                title: county.name,
                icon: markerIcon,
                label: {
                    text: county.projects.length,
                    color: '#333',
                    fontSize: '14px',
                    fontWeight: 'bold'
                },
                clicked: false
            });

            /** On marker click filter projects. */
            marker.addListener('click', () => filterProjects(county, marker));
        } catch (error) {
            console.error(error);
        }
    }
}

onMounted(() => generateMapMarkers());
</script>
