<template>
<div>
    <section class="projects-area">
        <article v-if="!isLoading">
          <DetailJob :job="job"/>
            <section class="bids-section">
                <header>
                    <h3>Bids</h3>
                    <div v-if="!isBid">
                        <button class="apply-bid" @click="openModal">Apply Now</button>
                    </div>
                </header>
                <div class="bids-list" v-show="bids">
                    <Bid v-for="bid in bids" :key="bid?.id" :bid="bid" />
                </div>
            </section>
        </article>
    </section>
    <Modal modalSize="600" :show="isModalVisible" @close="handleClose">
        <template v-slot:header>
            <h2>Place Bid</h2>
        </template>
        <template v-slot:body>
            <AddBid :currentBid="currentBid" />
        </template>
    </Modal>
    <Modal modalSize="600" :show="isModalDelete" @close="isModalDelete = false">
        <template v-slot:header>
            <h2>Delete Bid</h2>
        </template>
        <template v-slot:body>
            <section>
                <p class="delete-content">Are you sure you want to delete your bid? This action cannot be undone.</p>
                <div class="delete-bid">
                    <button type="button" class="cancel" @click="isModalDelete = false">
                        Cancel
                    </button>
                    <button type="button" class="delete" @click="confirmDelete" :disabled="loader">
                        {{ loader ? "loading..." : 'Delete' }}
                    </button>
                </div>
            </section>

        </template>
    </Modal>
</div>
</template>


<script>
import TaskService from "../../services/users/taskApiService";
import BidService from "../../services/bidService";
import Modal from "../../../components/modal/Modal.vue";
import DetailJob from "../../../components/jobs/Detail.vue";
import AddBid from "../../../components/bidding/Bid.vue";
import Auth from "../../../auth.js";
import Bid from "../../../components/bidding/BidsList.vue";

export default {
  components: {
    Modal,
    AddBid,
    DetailJob,
    Bid
  },
  data() {
    return {
      job: null,
      bids: null,
      isLoading: true,
      isModalVisible: false,
      currentBid: null,
      isBid: false,
      isModalDelete: false,
      currentBidId: null,
      loader: false,
      jobId: null,
    };
  },
  methods: {
    async fetchJob() {
      try {
        const { data } = await TaskService.getJobDetailById(this.jobId);
        this.job = data.data;
        if (data.status) {
          this.fetchBids(this.jobId);
          this.isBid = data?.data?.is_bid ? true : false;
          this.isLoading = false;
        }
      } catch (error) {
        this.isLoading = false;
        this.$toast.error(error?.response?.data?.message);
      } finally {
        this.isLoading = false;
      }
    },
    async fetchBids() {
      try {
        const { data } = await BidService.getAllBids(this.jobId);
        this.bids = data.data;
        if (data.status) {
          this.isLoading = false;
        }
      } catch (error) {
        this.$toast.error(error?.response?.data?.message);
      } finally {
        this.isLoading = false;
      }
    },
    openModal() {
      const user = Auth.getUser(); // Fetch the user object
      console.log(user);
      // if (user) {
        // User is authenticated, open the modal
        this.isModalVisible = true;
      // } else {
      //   // User is not authenticated, redirect to the login page and reload the page
      //   this.$router.push({ name: "Login" }).then(() => {
      //     window.location.reload(); // Reload the page after routing to login
      //   });
      // }
    },
    handleClose() {
      this.isModalVisible = false;
    },
    async confirmDelete() {
      try {
        this.loader = true;
        const { data } = await BidService.deleteBid(this.currentBidId);
        if (data.status) {
          this.isModalDelete = false;
          this.loader = false;
        }
        this.fetchBids(this.currentBidId);
        this.isBid = false;
        this.$toast.success(data?.message);
      } catch (error) {
        this.loader = false;
        this.$toast.error(error?.response?.data?.message);
      } finally {
        this.loader = false;
      }
    },
  },
  mounted() {
    const url = window.location.href; // Full URL
    this.jobId = url.split('/').pop(); // Get the last part of the URL
    console.log("Extracted Task ID:", this.jobId); // Log the ID for debugging
      this.job = this.fetchJob();

      console.log(this.fetchJob());
      // this.emitter.on("placeBid", () => {
      //   this.fetchJob();
      // });
      
      // Set the authenticated user ID
      this.bids = this.fetchBids(); 
      console.log(this.bids);
    },
  created() {
    if (this.jobId) {
      this.fetchJob();
    }
    this.$root.$on("placeBid", () => {
      this.isModalVisible = false;
      this.fetchJob();
    });
    this.$root.$on("currentBid", (bid) => {
      this.currentBid = bid;
      this.isModalVisible = true;
    });
    this.$root.$on("deleteBid", (bidId) => {
      this.isModalDelete = true;
      this.currentBidId = bidId;
    });
  },
  destroyed() {
    this.$root.$off("placeBid");
    this.$root.$off("currentBid");
    this.$root.$off("deleteBid");
  },
};
</script>



<style>
.apply-bid {
    width: 152px;
    height: 58px;
    flex-shrink: 0;
    background: #0D6EFD;
    color: #FFF;
    font-family: Gilroy-Medium;
    font-size: 18px;
    font-style: normal;
    font-weight: 400;
    line-height: normal;
}

.bidding-form {
    padding: 30px 40px;
}

.delete-bid {
    display: flex;
    justify-content: center;
    margin-top: 20px;
    margin-bottom: 20px;
    gap: 30px
}

.delete-bid .delete {
    width: 152px;
    height: 58px;
    background-color: #fd290d;
    color: #FFF;
}

.delete-bid .cancel {
    width: 152px;
    height: 58px;
    background-color: #0D6EFD;
    color: #FFF;
}

.delete-content {
    color: #222;
    text-align: center;
    font-family: Inter;
    font-size: 24px;
    font-style: normal;
    font-weight: 600;
    line-height: normal;
}
</style>
