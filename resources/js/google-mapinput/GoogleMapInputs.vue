<template>
    <div>
        <div class="map-input">
            <input ref="pickupInput" type="text" placeholder="Pickup Location" v-model="pickupAddress"
                class="form-control" />
            <input ref="dropupInput" type="text" placeholder="Dropup Location" v-model="dropupAddress"
                class="form-control" />
        </div>
        <div ref="map" class="map-container"></div>
        <p v-if="distance">Distance: {{ distance }} miles</p>
    </div>
</template>

<script>
import { ref, onMounted, watch, nextTick } from 'vue';
import debounce from 'lodash/debounce'; // Use lodash for debouncing

export default {
    name: 'DistanceCalculator',
    props: {
        pickupLocation: {
            type: String,
            default: '',
        },
        dropupLocation: {
            type: String,
            default: '',
        },
        pickupLatLng: {
            type: Object,
            default: null,
        },
        dropupLatLng: {
            type: Object,
            default: null,
        }
    },
    setup(props, { emit }) {
        const pickupAddress = ref(props.pickupLocation);
        const dropupAddress = ref(props.dropupLocation);
        const pickupLatLng = ref(props.pickupLatLng);
        const dropupLatLng = ref(props.dropupLatLng);
        const map = ref(null);
        const pickupMarker = ref(null);
        const dropupMarker = ref(null);
        const distance = ref(null);
        const polyline = ref(null);
        const geocoder = ref(null);

        const initMap = () => {
            map.value = new google.maps.Map(document.querySelector(".map-container"), {
                center: { lat: -34.397, lng: 150.644 },
                zoom: 8,
            });

            geocoder.value = new google.maps.Geocoder();

            const pickupInput = new google.maps.places.Autocomplete(document.querySelector('input[placeholder="Pickup Location"]'));
            const dropupInput = new google.maps.places.Autocomplete(document.querySelector('input[placeholder="Dropup Location"]'));

            pickupInput.bindTo("bounds", map.value);
            dropupInput.bindTo("bounds", map.value);

            pickupInput.addListener("place_changed", () => {
                const place = pickupInput.getPlace();
                if (!place.geometry) return;

                if (pickupMarker.value) pickupMarker.value.setMap(null);

                pickupMarker.value = new google.maps.Marker({
                    map: map.value,
                    position: place.geometry.location,
                });

                pickupAddress.value = place.formatted_address;
                console.log("this isssssssssssssssssssss", place.geometry.location.lat);
                console.log("this isssssssssssssssssssss", place.geometry.location)

                pickupLatLng.value = place.geometry.location;
                emit("update:pickupLocation", place.formatted_address);
                emit("update:pickupLatLng", place.geometry.location);

                if (dropupLatLng.value) calculateDistance();
            });

            dropupInput.addListener("place_changed", () => {
                const place = dropupInput.getPlace();
                if (!place.geometry) return;

                if (dropupMarker.value) dropupMarker.value.setMap(null);

                dropupMarker.value = new google.maps.Marker({
                    map: map.value,
                    position: place.geometry.location,
                });

                dropupAddress.value = place.formatted_address;
                dropupLatLng.value = place.geometry.location;
                emit("update:dropupLocation", place.formatted_address);
                emit("update:dropupLatLng", place.geometry.location);

                if (pickupLatLng.value) calculateDistance();
            });
        };

        const calculateDistance = debounce(() => {
            if (!pickupLatLng.value || !dropupLatLng.value) {
                console.error('Pickup or dropoff location is not set.');
                return;
            }

            const service = new google.maps.DistanceMatrixService();
            service.getDistanceMatrix({
                origins: [pickupLatLng.value],
                destinations: [dropupLatLng.value],
                travelMode: google.maps.TravelMode.DRIVING,
            }, (response, status) => {
                if (status === 'OK') {
                    const distanceInMeters = response?.rows[0]?.elements[0]?.distance?.value;

                    if (distanceInMeters != null) {
                        const distanceInMiles = distanceInMeters * 0.000621371;
                        distance.value = Math.round(distanceInMiles * 100) / 100;
                        emit("distanceCalculated", distance.value);
                        drawPolyline();
                    } else {
                        console.error('No distance information found.');
                    }
                } else {
                    console.error('Error calculating distance', status);
                }
            });
        }, 300); // Debounce the calculation for better performance

        const drawPolyline = () => {
            if (polyline.value) polyline.value.setMap(null);
            polyline.value = new google.maps.Polyline({
                path: [pickupMarker.value.getPosition(), dropupMarker.value.getPosition()],
                geodesic: true,
                strokeColor: "#FF0000",
                strokeOpacity: 1.0,
                strokeWeight: 2,
            });
            polyline.value.setMap(map.value);
        };

        onMounted(() => {
            const script = document.createElement('script');
            script.src = `https://maps.googleapis.com/maps/api/js?key=AIzaSyClJOW-Yk4Y0d2LibUodw5a8brnhJX0Z8U&libraries=places`;
            script.async = true;
            script.defer = true;
            script.onload = () => nextTick(() => initMap());
            document.head.appendChild(script);
        });

        watch(() => props.pickupLocation, (newVal) => {
            pickupAddress.value = newVal;
            if (pickupLatLng.value && dropupLatLng.value) calculateDistance();
        });

        watch(() => props.dropupLocation, (newVal) => {
            dropupAddress.value = newVal;
            if (pickupLatLng.value && dropupLatLng.value) calculateDistance();
        });

        watch(() => props.pickupLatLng, (newVal) => {
            pickupLatLng.value = newVal;
            if (pickupLatLng.value && dropupLatLng.value) calculateDistance();
        });

        watch(() => props.dropupLatLng, (newVal) => {
            dropupLatLng.value = newVal;
            if (pickupLatLng.value && dropupLatLng.value) calculateDistance();
        });

        return {
            pickupAddress,
            dropupAddress,
            pickupLatLng,
            dropupLatLng,
            distance,
        };
    },
};
</script>

<style scoped>
.map-container {
    width: 100%;
    height: 300px;
    margin-top: 10px;
}

.form-control {
    width: 100%;
    border-radius: 10px;
    border: 1px solid #707485;
    padding: 0.5rem;
    margin-bottom: 10px;
}

.map-input {
    display: flex;
    gap: 10px;
}
</style>
