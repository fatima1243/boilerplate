<template>
    <div>
        <div ref="map" class="map-container"></div>
    </div>
</template>

<script>
import { ref, onMounted, watch } from 'vue';

export default {
    name: 'LocationMap',
    props: {
        pickupLat: {
            type: Number,
            required: true,
        },
        pickupLng: {
            type: Number,
            required: true,
        },
        dropoffLat: {
            type: Number,
            required: true,
        },
        dropoffLng: {
            type: Number,
            required: true,
        }
    },
    setup(props) {
        const map = ref(null);
        const pickupMarker = ref(null);
        const dropoffMarker = ref(null);
        const polyline = ref(null);

        console.log(props);
        const initMap = () => {
            const center = {
                lat: (props.pickupLat + props.dropoffLat) / 2,
                lng: (props.pickupLng + props.dropoffLng) / 2
            };
            console.log("centerr", center)
            map.value = new google.maps.Map(document.querySelector(".map-container"), {
                center: center,
                zoom: 8,
            });

            addMarkersAndPolyline();
        };

        const addMarkersAndPolyline = () => {
            const pickupPosition = { lat: props.pickupLat, lng: props.pickupLng };
            const dropoffPosition = { lat: props.dropoffLat, lng: props.dropoffLng };

            if (pickupMarker.value) pickupMarker.value.setMap(null);
            if (dropoffMarker.value) dropoffMarker.value.setMap(null);
            if (polyline.value) polyline.value.setMap(null);

            pickupMarker.value = new google.maps.Marker({
                position: pickupPosition,
                map: map.value,
                title: "Pickup Location"
            });

            dropoffMarker.value = new google.maps.Marker({
                position: dropoffPosition,
                map: map.value,
                title: "Dropoff Location"
            });

            polyline.value = new google.maps.Polyline({
                path: [pickupPosition, dropoffPosition],
                geodesic: true,
                strokeColor: "#FF0000",
                strokeOpacity: 1.0,
                strokeWeight: 2,
            });

            polyline.value.setMap(map.value);

            map.value.fitBounds(new google.maps.LatLngBounds(pickupPosition, dropoffPosition));
        };

        onMounted(() => {
            const script = document.createElement('script');
            script.src = `https://maps.googleapis.com/maps/api/js?key=AIzaSyClJOW-Yk4Y0d2LibUodw5a8brnhJX0Z8U&libraries=places`;
            script.async = true;
            script.defer = true;
            script.onload = () => initMap();
            document.head.appendChild(script);
        });

        watch(
            () => [props.pickupLat, props.pickupLng, props.dropoffLat, props.dropoffLng],
            () => {
                if (map.value) {
                    addMarkersAndPolyline();
                }
            }
        );

        return {};
    },
};
</script>

<style scoped>
.map-container {
    width: 100%;
    height: 500px;
    margin-top: 10px;
}
</style>
