<template>
    <div>
        <hr class="divider">
        <div class="container">
            <div class="row main-content">
                <div class="job-image col-md-3">
                    <img :src="job?.image ? `${$storage}/${job.image.attachment}` : `${$public}/job1.png`"
                        class="card-img-left image-responsive" :alt="job.title" />
                </div>
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-between align-items-center mt-1">
                                <div class="post-text">
                                    Posted {{ formateDate(job.created_at) }}
                                    <img :src="`${$public}/share.png`" class="px-5" @click="openModal"
                                        style="cursor:pointer" />
                                </div>
                                <!-- <div class="bid-count btn">
                                    <RouterLink :to="{ name: 'UserDetailJob', params: { id: job.id } }" target="_blank">
                                        <p class="bid-count">No of Bids ({{ job.biddings_count }})</p>
                                    </RouterLink>
                                </div> -->
                            </div>
                        </div>
                    </div>

                    <!-- <div class="job-title">
                        <RouterLink :to="{ name: 'UserDetailJob', params: { id: job.id } }" target="_blank">
                            <span>{{ job.title }}</span>
                        </RouterLink>
                    </div> -->

                    <!-- <div class="d-flex justify-content-between flex-wrap">
                        <div class="d-flex align-items-baseline flex-wrap">
                            <div class="distance">
                                <p class="title">Distance:</p>
                                <p class="value"> {{ job.distance }} Mils</p>
                            </div>
                            <div class="location">
                                <div class="icon">
                                    <img :src="`${$public}/location.svg`" />
                                </div>
                                <p>{{ job.pickup_location }} - {{ job.dropoff_location }}</p>

                            </div>
                        </div>

                        <div class="lowest-bid-tag">
                            <p>Lowest Bid: £{{ job?.min_bid?.price }}</p>
                        </div>
                    </div> -->

                    <!-- <div>
                        <p class="discription">{{ job.additional_details }}</p>
                    </div> -->
                    <!-- <div class="bid-actions">
                        <button @click="editJOb(job.id)" class="edit-btn"><img :src="`${$public}/basil_edit-solid.svg`" />
                        </button>
                        <button @click="deleteJob(job.id)" class="delete-btn"><img
                                :src="`${$public}/ic_baseline-delete.svg`"
                                v-if="job.status === $constants.TASK_STATUS['pending']" /></button>
                    </div> -->

                </div>
            </div>
        </div>
        <!-- <div v-if="showModal" class="modal">
            <div class="modal-content">
                <span class="close" @click="closeModal">&times;</span>
                <h2>Copy Link</h2>
                <p class="modal-message">Copy the job detail page link below:</p>
                <input type="text" :value="jobDetailLink" readonly class="link-input" />
                <div class="modal-actions">
                    <button @click="closeModal" class="btn-cancel">Cancel</button>
                    <button @click="copyToClipboard" class="btn-confirm">Copy</button>
                </div>
                <p v-if="copyMessage" class="copy-message">{{ copyMessage }}</p>
            </div>
        </div> -->
    </div>
</template>

<script>
import moment from 'moment';

export default {
    name: "JobCard",
    props: {
        job: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            showModal: false, // controls the modal visibility
            copyMessage: '' // to show copy success message
        };
    },
    computed: {
        jobDetailLink() {
            return `${window.location.origin}/job-list/${this.job.id}`;
        }
    },
    methods: {
        formateDate(date) {
            return moment(date).fromNow();
        },
        editJOb(id) {
            this.$router.push({ name: 'CreateJob', params: { id } });
        },
        deleteJob(jobId) {
            this.emitter.emit('deleteJob', jobId);
        },
        openModal() {
            this.showModal = true;
            this.copyMessage = ''; // reset the copy message
        },
        closeModal() {
            this.showModal = false;
            this.copyMessage = ''; // clear message when closing modal
        },
        copyToClipboard() {
            navigator.clipboard.writeText(this.jobDetailLink)
                .then(() => {
                    this.copyMessage = "Link copied successfully!";
                })
                .catch(err => {
                    this.copyMessage = "Failed to copy the link.";
                    console.error("Failed to copy: ", err);
                });
        }
    }
};
</script>

<style scoped>
.job-listing img {
    object-fit: cover;
    height: 100%;
}

.job-list {
    display: flex;
    border-radius: 10px;
}

.job-item {
    display: flex;
    gap: 50px;

}

.job-content {
    padding: 20px;
    width: 100%;
}

.post-text {
    color: #707485;
    font-family: Inter;
    font-size: 16px;
    font-style: normal;
    font-weight: 400;
    line-height: normal;
    margin-bottom: 10px;
}

.job-title {
    color: #313131;
    font-family: Inter;
    font-size: 20px;
    font-style: normal;
    font-weight: 500;
    line-height: normal;
    letter-spacing: -1px;
    margin-bottom: 10px;
}

.verify {
    display: flex;
    gap: 10px;
}

.location {
    display: flex;
    gap: 10px;
    align-items: baseline;
}

.location p {
    color: #707485;
    font-family: Inter;
    font-size: 16px;
    font-style: normal;
    font-weight: 400;
    line-height: normal;
}

.distance {
    display: flex;
}

.distance .title {
    color: #707485;
    font-family: Inter;
    font-size: 16px;
    font-style: normal;
    font-weight: 400;
    line-height: normal;
}

.distance .value {
    width: max-content;
    color: #707485;
    font-family: Inter;
    font-size: 16px;
    font-style: normal;
    font-weight: 400;
    line-height: normal;
    margin-left: 10px;
    margin-right: 30px
}

.lowest-bid-tag {
    display: flex;
    gap: 20;
    justify-content: end;
}

.lowest-bid-tag p {
    color: #319F43;
    font-family: Inter;
    font-size: 20px;
    font-style: normal;
    font-weight: 500;
    line-height: normal;
}

.job-item .list {
    display: flex;
}

.discription {
    color: #707485;
    font-family: Inter;
    font-size: 16px;
    font-style: normal;
    font-weight: 400;
    line-height: normal;
}

.rate p {
    color: #707485;
    font-family: Inter;
    font-size: 16px;
    font-style: normal;
    font-weight: 400;
}

.divider {
    height: 1px;
    background: #707485;
    margin-top: 40px;
    margin-bottom: 40px;
}

.bid-actions {
    display: flex;
    justify-content: flex-end;
    gap: 15px;
}

.edit-btn,
.delete-btn {
    border: none;
    background: none;
    cursor: pointer;
    font-size: 1.5em;
}

.edit-btn img {
    width: 24px;
    height: 24px;
    background-color: #FBB040;
}

.delete-btn img {
    width: 24px;
    height: 24px;
    background-color: #E33629;
}

.bid-count {
    width: 125px;
    height: 40px;
    flex-shrink: 0;
    background: #0D6EFD;
    display: flex;
    justify-content: center;
    align-items: center;
}

.bid-count p {
    color: #FFF;
    font-family: Gilroy-Medium;
    font-size: 18px;
    font-style: normal;
    font-weight: 400;
    line-height: 40px;
    text-align: center;
    margin: 0;
}

.job-content .post-header {
    display: flex;
    justify-content: space-between;
}

.job-image {
    width: 270px;
    height: 198px;
    flex-shrink: 0;
}

.job-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 20px;
}

.modal {
    display: block;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
}

.modal-content {
    background-color: #fff;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 400px;
    border-radius: 10px;
    text-align: center;
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

.modal-message {
    font-size: 18px;
    margin-bottom: 20px;
}

.link-input {
    padding: 10px;
    font-size: 16px;
    width: 100%;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.modal-actions {
    display: flex;
    justify-content: center;
    gap: 20px;
    margin-top: 20px;
}

.btn-cancel {
    padding: 10px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.btn-confirm {
    padding: 10px;
    background-color: #dc3545;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.copy-message {
    color: green;
    margin-top: 10px;
    font-size: 16px;
}
</style>
