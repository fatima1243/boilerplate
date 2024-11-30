<template>
    <section>
        <header class="details-header">
            <h1>Details</h1>
        </header>
        <div class="row pb-5">
            <div class="col-md-4">
                <span class="label">Title:</span>
                <span class="value ps-3">{{ job.title }}</span>
            </div>
            <div class="col-md-4">
                <span class="label">Pickup Location:</span>
                <span class="value ps-3">{{ job.pickup_location }}</span>
            </div>
            <div class="col-md-4">
                <span class="label">Date:</span>
                <span class="value ps-3">{{ job.service_date }}</span>
            </div>

            <div class="col-md-4">
                <span class="label">Job Type:</span>
                <span class="value ps-3">{{ job.service_duration }}</span>
            </div>

            <div class="col-md-4">
                <span class="label">Dropoff Location:</span>
                <span class="value ps-3">{{ job.dropoff_location }}</span>
            </div>
            <div class="col-md-4">
                <span class="label">Kind of Service:</span>
                <span class="value ps-3">{{ job.service_type }}</span>
            </div>
        </div>

        <!-- Media Section -->
        <div class="container">
            <div class="row">
                <div class="col-12 p-0">
                    <div class="media-container">
                        <div class="media-box">
                            <h3>Images:</h3>
                            <img
                                :src="job?.image ? `${$storage}/${job.image.attachment}` : `/images/home/image/job1.png`"
                                alt="Main image"
                                @click="handleImageClick(0)"
                            />
                            <!-- Show "See More Images" button if more than 1 image exists -->
                            <div v-if="job?.task_galleries?.length > 1" class="see-more">
                                <button @click="openModal(0)">See More Images</button>
                            </div>
                        </div>
                        <div class="media-box">
                            <h3>Video:</h3>
                            <video controls>
                                <source :src="job?.video ? `${$storage}/${job.video.attachment}` : 'path.video'" type="video/mp4" />
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for All Images -->
        <article class="details-content">
            <div v-if="showModal" class="modal">
                <div class="modal-content">
                    <span class="close" @click="closeModal">&times;</span>
                    <h3>All Images</h3>

                    <!-- Show one image at a time -->
                    <div class="modal-image">
                        <img :src="`${$storage}/${job.task_galleries[currentIndex].attachment}`" :alt="'Image ' + (currentIndex + 1)" />
                    </div>

                    <!-- Navigation buttons -->
                    <div class="navigation-buttons">
                        <button @click="prevImage" :disabled="currentIndex === 0">Previous</button>
                        <button @click="nextImage" :disabled="currentIndex === job.task_galleries.length - 1">Next</button>
                    </div>
                </div>
            </div>

            <!-- Map Section -->
            <section class="map-direction">
                <h3>Map Direction:</h3>
                <MapMark :pickupLat="job?.pickup_lat" :pickupLng="job?.pickup_long" :dropoffLat="job.drop_lat"
                    :dropoffLng="job.drop_long" />
            </section>
        </article>
    </section>
</template>


<script setup>
import { ref } from 'vue';
import MapMark from '../map/MapMark.vue';

const props = defineProps(['job']);
const showModal = ref(false);
const currentIndex = ref(0);

// Open modal and set the initial index
const openModal = (index) => {
    currentIndex.value = index;
    showModal.value = true;
};

// Close modal
const closeModal = () => {
    showModal.value = false;
};

// Show previous image
const prevImage = () => {
    if (currentIndex.value > 0) {
        currentIndex.value--;
    }
};

// Show next image
const nextImage = () => {
    if (currentIndex.value < props.job.task_galleries.length - 1) {
        currentIndex.value++;
    }
};

// Handle image click for single image
const handleImageClick = (index) => {
    // If there's only one image, open the modal directly
    if (props.job.task_galleries.length === 1) {
        openModal(index);
    }
};
</script>


<style scoped>
.media-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
}

.media-box {
    width: 100%;
    max-width: 540px;
    aspect-ratio: 16/9;
    /* Ensures aspect ratio */
    /* overflow: hidden; */
    margin-bottom: 20px;
}

.media-box img,
.media-box video {
    border-radius: 20px;
    width: 100%;
    height: 100%;
    object-fit: cover;
    /* Ensures the content fills the box */
}

/* Styles for the details header */
.details-header {
    display: flex;
    justify-content: center;
    margin-bottom: 20px;
}

.details-header h1 {
    color: #000;
    text-align: center;
    font-family: Inter;
    font-size: 30px;
    font-style: normal;
    font-weight: 600;
    line-height: normal;
    letter-spacing: -2px;
}

/* Job Details styling */
.details-content {
    display: flex;
    flex-direction: column;
}

.details-info {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    margin-bottom: 20px;
}

.details-row {
    display: flex;
    gap: 25px;
}

.label {
    color: #000;
    text-align: center;
    font-family: Inter;
    font-size: 22px;
    font-style: normal;
    font-weight: 500;
    line-height: normal;
    letter-spacing: -1.2px;
}

.value {
    color: #707485;
    font-family: Inter;
    font-size: 22px;
    font-style: normal;
    font-weight: 400;
    line-height: normal;
    letter-spacing: -1.2px;
}

/* Media section */
.media-section {
    display: flex;
    margin-bottom: 20px;
    justify-content: space-between;
    flex-wrap: wrap;
}

.main-image {
    display: flex;
}

.large-image {
    /* width: 481.748px; */
    /* height: 308.174px; */
    width: auto;
    /* flex-shrink: 0; */
    border-radius: 10px;
}

.large-image img {
    width: 100%;
    height: 100%;
    border-radius: 10px;
    object-fit: contain;
}

/* See more images button */
.see-more button {
    margin-top: 10px;
    background-color: #0d6efd;
    color: #fff;
    padding: 10px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.see-more button:hover {
    background-color: #0056b3;
}

/* Video section */
/* .video {
    width: 483.555px;
    height: 309.329px;
    flex-shrink: 0;
} */

.video video {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 20px;
    border: 1px solid #707485;
}

/* Modal styling */
.modal {
    display: flex;
    justify-content: center;
    align-items: center;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.8);
}

.modal-content {
    background-color: #fff;
    padding: 20px;
    border-radius: 10px;
    max-width: 600px;
    width: 100%;
    position: relative;
}

.close {
    position: absolute;
    top: 10px;
    right: 20px;
    font-size: 30px;
    cursor: pointer;
}

.modal-image {
    display: flex;
    justify-content: center;
    margin-bottom: 20px;
}

.modal-image img {
    width: 100%;
    height: auto;
    border-radius: 10px;
}

.navigation-buttons {
    display: flex;
    justify-content: space-between;
}

.navigation-buttons button {
    background-color: #0d6efd;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.navigation-buttons button:disabled {
    background-color: #ccc;
}

.navigation-buttons button:hover:enabled {
    background-color: #0056b3;
}

/* Map styling */
.map-direction {
    margin-bottom: 20px;
}

.map-direction iframe {
    width: 100%;
    height: 350px;
    flex-shrink: 0;
    object-fit: contain;
    border-radius: 20px;
    border: 1px solid #707485;
}
</style>
