<template>
  <div>
  <hr class="divider">
  <div class="container">
    <div class="row">
      <div class="job-image col-md-3">
        <img :src="job?.image ? `${$storage}/${job.image.attachment}` : `/images/home/image/job1.png`"
          class="card-img-left image-responsive" :alt="job.title" />
      </div>
      <div class="col-md-9">
        <div class="d-flex justify-content-between">
          <div class="row">
            <div class="col-md-12">
              <div>
                <div class="post-text d-flex align-items-center">
                  <span>
                    Posted {{ formateDate(job.created_at) }}
                  </span>
                  <div>
                    <a href="javascript:void(0)">
                      <img :src="`/images/home/image/share.png`" />
                    </a>
                  </div>
                </div>
                <div class="job-title">
                  <a :href="`/get-task-by-id/${job.id}`" target="_blank">
                    <span>{{ job.title }}</span>
                  </a>
                </div>
              </div>
            </div>
          </div>

          <!-- Check if the authenticated user has a bid -->
          <div v-if="userBid" class="">
            <button class="bid-button">
              My Bid : £{{ userBid.price }}
            </button>
          </div>
        </div>
        <div class="d-flex justify-content-between flex-wrap">
          <div class="d-flex align-items-baseline flex-wrap">
            <div class="verify">
              <div class="icon">
                <img :src="`/images/home/image/verify.svg`" />
              </div>
              <span>Payment verified</span>
            </div>
            <div class="distance">
              <p class="title">Distance:</p>
              <p class="value"> {{ job.distance }} Mils</p>
            </div>
            <div class="location align-items-baseline">
              <div class="icon">
                <img :src="`/images/home/image/location.svg`" />
              </div>
              <p>{{ job.pickup_location }} - {{ job.dropoff_location }}</p>
            </div>
          </div>

          <div class="lowest-bid-tag" v-if="job?.min_bid?.price">
            <p>Lowest Bid: £{{ job?.min_bid?.price }}</p>
          </div>
        </div>
        <div class="review">
          <div class="star">
            <img :src="`/images/home/image/solar_star-bold.svg`" />
            <img :src="`/images/home/image/solar_star-bold.svg`" />
            <img :src="`/images/home/image/solar_star-bold.svg`" />
            <img :src="`/images/home/image/unfill-star.svg`" />
          </div>
          <div class="rate">
            <p>4.00</p>
          </div>
        </div>
        <div>
          <p class="discription">{{ job.additional_details }}</p>
        </div>
      </div>
    </div>
  </div>
  </div>
</template>

<script>
import moment from 'moment';

export default {
  name: "JobCard",
  props: ["job", "authUserId"], // Add authUserId as a prop
  data() {
    return {
      showModal: false, // controls the modal visibility
      copyMessage: '', // for showing success message
    };
  },
  computed: {
    // Find the bid of the authenticated user
    userBid() {
      return this.job.biddings.find(bid => bid.driver_id === this.authUserId);
    },
    jobDetailLink() {
      return `${window.location.origin}/job/${this.job.id}`;
    }
  },
  methods: {
    formateDate(date) {
      return moment(date).fromNow();
    },
    openModal() {
      this.showModal = true;
    },
    closeModal() {
      this.showModal = false;
      this.copyMessage = ''; // reset message
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
.bid-button {
  background-color: #007bff;
  /* Blue background */
  color: white;
  /* White text color */
  border: none;
  /* Remove any borders */
  border-radius: 12px;
  /* Rounded corners */
  padding: 10px 20px;
  /* Padding for spacing */
  font-size: 16px;
  /* Adjust text size */
  font-weight: bold;
  /* Make the text bold */
  cursor: pointer;
  /* Change cursor to pointer on hover */
  display: inline-block;
  /* Ensure it behaves like a button */
}

.bid-button:hover {
  background-color: #0056b3;
  /* Darker blue on hover */
}

a {
  text-decoration: none;
  /* Removes the underline */
  color: black;
  /* Sets the color to black */
}

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
}

.post-text {
  color: #707485;
  font-family: Inter;
  font-size: 16px;
  font-style: normal;
  font-weight: 400;
  line-height: normal;
  margin-bottom: 10px;
  gap: 70px;
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
  gap: 10px
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
  margin-left: 30px;
}

.distance .value {
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
  flex-direction: column;
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

.review {
  display: flex;
  gap: 10px;
}

.star {
  display: flex;
  gap: 5px;
}

.star img {
  width: 20px;
  height: 20px;
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

/* Modal Styling */
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

.modal-body {
  display: flex;
  flex-direction: column;
  gap: 10px;
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
