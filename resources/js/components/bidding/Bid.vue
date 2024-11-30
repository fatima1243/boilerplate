<template>
    <form @submit.prevent="placeBid">
        <div class="col-spacing">
            <label for="bidAmount" class="form-label">Bid Amount</label>
            <input type="number" class="form-control" id="bidAmount" step="any" min="0"
                required />
        </div>
        <div class="col-spacing">
            <label for="bidDetails" class="form-label">Bid Details</label>
            <textarea class="form-control" id="bidDetails" rows="5" required></textarea>
        </div>
        <div class="field-row flex text col-spacing">
            <input  type="checkbox" id="accept-terms" class="fancy-check" required />
            <label for="accept-terms" class="fancy-checkbox">
                I agree to all
                <!-- <router-link :to="{ name: 'TermsAndConditions' }" target="_blank">Terms &amp; Conditions</router-link> -->
                that apply on it
            </label>
        </div>
        <button type="submit" class="btn btn-primary w-100" :disabled="isLoading">
            {{ isLoading ? 'Loading' : 'Submit' }}
        </button>
    </form>
</template>

<script>
// import { mapActions } from "vuex"; // Assuming Vuex is used for event handling
// import { useToast } from "vue-$toast-notification";
import BidService from "../services/bidService.js";
import Auth from "../../auth.js";

export default {
    props: {
        bid: {
        type: Object,
        required: true,
        default: () => ({ price: 0 }),
    },
        currentBid: {
            type: Object,
            default: () => ({}),
        },
    },
    data() {
        return {
            isLoading: false,
            bidding: {
                bid_id: this.currentBid?.id || null,
                price: this.currentBid?.price || null,
                description: this.currentBid?.description || null,
                task_id: this.$route.params?.id, // Access route params via $route
                user_id: Auth.getUser()?.id, // Get the authenticated user's ID
                is_term_accepted: true,
            },
            bid: {
            price: 0, // Default initialization
        },
        };
    },
    methods: {
        async placeBid() {
            try {
                this.isLoading = true;
                const { data } = await BidService.bidding(this.bidding);
                if (data.status) {
                    this.isLoading = true;
                    this.$emit("placeBid"); // Emit the event to the parent component
                }
                this.$toast.success(data?.message);
            } catch (error) {
                this.isLoading = false;
                this.$toast.error(error?.response?.data?.message);
            } finally {
                this.isLoading = false;
            }
        },
    },
};
</script>


<style scoped>
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

.col-spacing {
    margin-bottom: 30px;
}

.fancy-checkbox {
    margin-left: 10px;
}

.fancy-check {
    width: 24px;
    height: 20px;
}
</style>
