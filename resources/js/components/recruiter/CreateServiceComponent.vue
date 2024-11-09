<template>
    <div class="projects-area">
        <form @submit.prevent="validateAndSubmit" enctype="multipart/form-data">
        <div class="form-container-job">
            <div class="form-row">
                <div class="form-column">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input v-model="formData.title" name="title" type="text" id="title" placeholder="Title"
                            class="form-control" v-validate="'required'" />
                        <!-- <span v-show="errors.has('title')" class="error">{{ errors.first('title') }}</span> -->
                    </div>

                    <div class="form-group">
                        <label for="serviceType">What kind of service do you need?</label>
                        <input v-model="formData.service_type" name="service_type" type="text" id="serviceType"
                            placeholder="Type of service" class="form-control" v-validate="'required'" />
                        <!-- <span v-show="errors.has('service_type')" class="error">{{ errors.first('service_type') }}</span> -->
                    </div>

                    <div class="form-group">
                        <label for="serviceDate">When do you need this service?</label>
                        <input v-model="formData.service_date" name="service_date" type="date" id="serviceDate"
                            class="form-control" v-validate="'required'" />
                        <!-- <span v-show="errors.has('service_date')" class="error">{{ errors.first('service_date') }}</span> -->
                    </div>

                    <div class="form-group">
                        <label for="serviceDuration">How long do you need this service for?</label>
                        <input v-model="formData.service_duration" name="service_duration" type="text"
                            id="serviceDuration" placeholder="Duration of service" class="form-control" v-validate="'required'" />
                        <!-- <span v-show="errors.has('service_duration')" class="error">{{ errors.first('service_duration') }}</span> -->
                    </div>

                    <div class="form-group">
                        <label for="pictures">Pictures</label>
                        <input ref="pictures" name="pictures" type="file" id="pictures" accept="image/*" multiple
                            @change="handleFileChange('pictures', $event)" class="form-control-file" />
                    </div>
                </div>

                <div class="form-column">
                    <div class="form-group">
                        <label for="additionalDetails">Additional Details</label>
                        <textarea v-model="formData.additional_details" name="additional_details"
                            id="additionalDetails" placeholder="Additional details" class="form-control" v-validate="'required'"></textarea>
                        <!-- <span v-show="errors.has('additional_details')" class="error">{{ errors.first('additional_details') }}</span> -->
                    </div>

                    <div class="form-group">
                        <label for="distance">Distance</label>
                        <input v-model="formData.distance" name="distance" type="number" min="0" id="distance"
                            placeholder="Distance" class="form-control" />
                    </div>

                    <div class="form-group">
                        <label for="videos">Videos</label>
                        <input ref="videos" name="videos" type="file" id="videos" accept="video/*" multiple
                            @change="handleFileChange('videos', $event)" class="form-control-file" />
                    </div>
                </div>
            </div>

            <div>
                <GoogleMapInputs :pickupLocation="formData.pickup_location"
                    :dropupLocation="formData.dropoff_location" @update:pickupLocation="updatePickupLocation"
                    @update:dropupLocation="updateDropupLocation" @distanceCalculated="updateDistanceCal"
                    @update:pickupLatLng="updatePickupLatLong" @update:dropupLatLng="updateDropOffLatLong"
                    :pickupLatLng="formData.pickup_lat_long" :dropupLatLng="formData.dropup_lat_long" />
            </div>

            <div class="button-holder flex flex-wrap">
                <button type="button" class="btn btn-secondary" @click="cancel">Cancel</button>
                <button type="submit" class="btn btn-primary" :disabled="isLoading">{{ isLoading ? "Loading..." : "Submit" }}</button>
            </div>
        </div>
    </form>
    </div>
</template>


<script>
import { ref, watch, getCurrentInstance, onMounted, onBeforeUnmount, toRefs, watchEffect } from "vue";
import Auth from "../../auth.js";
import taskApiService from "../services/users/taskApiService";
import { Field, Form, ErrorMessage, defineRule, configure } from "vee-validate";
import GoogleMapInputs from '../../google-mapinput/GoogleMapInputs.vue'; // Replace with your map component path

export default {
    components: {
        GoogleMapInputs
    },
    props: {
        job: {
            type: Object,
            required: false,
        },
    },

    setup(props) {
        const { job } = toRefs(props);

        const isLoading = ref(false);
        // const { proxy } = getCurrentInstance();


        const formData = ref({
            title: "",
            service_type: "",
            service_date: "",
            service_duration: "",
            additional_details: "",
            pickup_location: "",
            dropoff_location: "",
            dropup_lat_long: "",
            pickup_lat_long: "",
            distance: "",
            pictures: [],
            videos: [],
        });
        const authUser = ref(Auth.getUser());
        // const id = ref(null);

        const formatDate = (dataTime) => {
            return moment(dataTime).format("D MMMM YYYY");
        };

        const validateAndSubmit = async () => {
            let values = formData.value;
            isLoading.value = true;

            try {
                const formDataToSend = new FormData();
                formDataToSend.append("title", values.title);
                formDataToSend.append("service_type", values.service_type);
                formDataToSend.append("service_date", values.service_date);
                formDataToSend.append("service_duration", values.service_duration);
                formDataToSend.append("additional_details", values.additional_details);
                formDataToSend.append("pickup_location", values.pickup_location);
                formDataToSend.append("dropoff_location", values.dropoff_location);
                formDataToSend.append("distance", values.distance);
                formDataToSend.append("dropup_lat_long", values.dropup_lat_long);
                formDataToSend.append("pickup_lat_long", values.pickup_lat_long);
                values.pictures.forEach((file) => {
                    formDataToSend.append("pictures[]", file);
                });

                values.videos.forEach((file) => {
                    formDataToSend.append("videos[]", file);
                });

                let response;
                // if (id.value) {
                //     formDataToSend.append("id", id.value);
                    response = await taskApiService.updateTask(formDataToSend);
                // } else {
                //     response = await taskApiService.addTask(formDataToSend);
                // }

                const data = response?.data;

                if (data.status) {
                    isLoading.value = false;
                    // this.$toast.success(data?.message); // Display success message
                    window.location.href = '/jobPosts';
                }
            } catch (error) {
                console.error("Error:", error);
                isLoading.value = false;
                // this.$toast.error( error.response?.data?.message); // Display success message
            }
        };

        const calculateDistance = async () => {
            if (formData.value.pickup_location && formData.value.dropoff_location) {
                try {
                    const response = await taskApiService.calculateDistance({
                        pickup: formData.value.pickup_location,
                        dropoff: formData.value.dropoff_location,
                    });
                    formData.value.distance = response.data.distance;
                } catch (error) {
                    console.error("Failed to calculate distance", error);
                }
            }
        };

        const handleFileChange = (field, event) => {
            const files = event.target.files;
            for (let i = 0; i < files.length; i++) {
                formData.value[field].push(files[i]);
            }
        };

        const updatePickupLocation = (newLocation) => {
            formData.value.pickup_location = newLocation;
        };
        const updateDropupLocation = (newLocation) => {
            formData.value.dropoff_location = newLocation;
        };
        const updateDistanceCal = (newDistance) => {
            formData.value.distance = newDistance;
        };

        const updatePickupLatLong = (newLat) => {
            formData.value.pickup_lat_long = newLat;
        };

        const updateDropOffLatLong = (newLat) => {
            formData.value.dropup_lat_long = newLat;
        };


        onMounted(() => {
            if (job.value) {
                console.log("this is the test detail", job.value);
                if (job.value.id) {
                    updateJobListener(job.value);
                }
            }
        });

        watchEffect(() => {
            if (job.value && job.value.id) {
                console.log("Job prop changed:", job.value);
                updateJobListener(job.value);
            }
        });


        const updateJobListener = (newInitialData) => {
            console.log("new init", newInitialData);
            id.value = newInitialData.id,
                formData.value = {
                    title: newInitialData.title || "",
                    service_type: newInitialData.service_type || "",
                    service_date: newInitialData.service_date || "",
                    service_duration: newInitialData.service_duration || "",
                    additional_details: newInitialData.additional_details || "",
                    pickup_location: newInitialData.pickup_location || "",
                    dropoff_location: newInitialData.dropoff_location || "",
                    distance: newInitialData.distance || "",
                    pickup_lat_long: {
                        lat: newInitialData.pickup_lat,
                        lng: newInitialData.pickup_long,
                    } || "",
                    dropup_lat_long: {
                        lat: newInitialData.drop_lat,
                        lng: newInitialData.drop_long,
                    } || "",
                    pictures: [],
                    videos: [],
                };
        };

        onBeforeUnmount(() => {
        });

        return {
            // job,
            isLoading,
            formData,
            authUser,
            formatDate,
            validateAndSubmit,
            updateDistanceCal,
            handleFileChange,
            updatePickupLocation,
            updateDropupLocation,
            calculateDistance,
            updatePickupLatLong,
            updateDropOffLatLong
        };
    },
};
</script>

<style scoped>
.form-container-job {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.form-row {
    display: flex;
    justify-content: space-between;
    gap: 2rem;
    /* Reduce this value to decrease space between columns */
}

.form-column {
    flex: 1;
    /* Ensure columns take up equal space */
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.form-control,
.form-control-file {
    width: 100%;
    border-radius: 10px;
    border: 1px solid #707485;
    padding: 0.5rem;
}

.form-control-file {
    padding: 0.2rem;
}

.error {
    color: red;
    font-size: 0.875rem;
}

.map-container {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.map {
    width: 100%;
    height: 200px;
    background-color: #e9ecef;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
}

.button-holder {
    display: flex;
    justify-content: flex-end;
    gap: 1rem;

}

.btn {
    color: #FFF;
    font-family: "DM Sans";
    font-size: 18px;
    font-style: normal;
    font-weight: 400;
    line-height: normal;
}

.btn-secondary {
    border-radius: 5px;
    border: 1px solid #FFF;
    width: 225px;
    height: 58px;
    border-radius: 10px;
    border: 1px solid #707485;
    background: #FFF;
    color: #0D6EFD;
}

.btn-primary {
    width: 225px;
    height: 58px;
    flex-shrink: 0;
    border-radius: 10px;
    background: #0D6EFD;
    box-shadow: 0px 100px 80px 0px rgba(72, 72, 138, 0.10), 0px 64.815px 46.852px 0px rgba(72, 72, 138, 0.08), 0px 38.519px 25.481px 0px rgba(72, 72, 138, 0.06), 0px 20px 13px 0px rgba(72, 72, 138, 0.05), 0px 8.148px 6.519px 0px rgba(72, 72, 138, 0.04), 0px 1.852px 3.148px 0px rgba(72, 72, 138, 0.02);
}

.additionalDetails {
    height: 210px;
}
.projects-area .title {
    color: #000;
    text-align: end;
    font-family: Inter;
    font-size: 24px;
    font-style: normal;
    font-weight: 600;
    line-height: normal;
    letter-spacing: -1.2px;
}
</style>
