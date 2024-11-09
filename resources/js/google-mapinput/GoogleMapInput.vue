<template>
  <div>
    <input ref="input" type="text" :id="id" :name="name" :placeholder="placeholder" v-model="address"
      class="form-control" @input="onInput" />
    <div ref="map" class="map-container"></div>
  </div>
</template>

<script>
import { ref, watch, onMounted } from "vue";

export default {
  props: {
    id: {
      type: String,
      required: true,
    },
    name: {
      type: String,
      required: true,
    },
    placeholder: {
      type: String,
      default: "",
    },
    modelValue: {
      type: String,
      required: true,
    },
  },
  setup(props, { emit }) {
    const address = ref(props.modelValue);
    const map = ref(null);
    const marker = ref(null);
    const input = ref(null);

    watch(
      () => props.modelValue,
      (newVal) => {
        address.value = newVal;
      }
    );

    const initMap = () => {
      map.value = new google.maps.Map(
        document.querySelector(".map-container"),
        {
          center: { lat: -34.397, lng: 150.644 },
          zoom: 8,
        }
      );

      const autocomplete = new google.maps.places.Autocomplete(input.value);
      autocomplete.bindTo("bounds", map.value);

      autocomplete.addListener("place_changed", () => {
        const place = autocomplete.getPlace();
        if (!place.geometry) {
          return;
        }

        if (place.geometry.viewport) {
          map.value.fitBounds(place.geometry.viewport);
        } else {
          map.value.setCenter(place.geometry.location);
          map.value.setZoom(17);
        }

        if (marker.value) {
          marker.value.setMap(null);
        }

        marker.value = new google.maps.Marker({
          map: map.value,
          position: place.geometry.location,
        });

        emit("update:modelValue", place.formatted_address);
      });
    };

    const onInput = (event) => {
      emit("update:modelValue", event.target.value);
    };

    onMounted(() => {
      initMap();
    });

    return {
      address,
      input,
      onInput,
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

.form-control,
.form-control-file {
  width: 100%;
  border-radius: 10px;
  border: 1px solid #707485;
  padding: 0.5rem;
}
</style>
