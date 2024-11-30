<template>
    <div class="bid-item">
      <div class="bidder-info">
        <img :src="`${$public}/user.png`" alt="Profile Picture" class="profile-picture" />
        <div class="bidder-details">
          <h4>{{ bid?.user?.first_name }} {{ bid?.user?.last_name }}</h4>
          <p>{{ bid.description }}</p>
        </div>
      </div>
      <div class="price-section">
        <div class="bid-amount">
          <p>£{{ bid.price }}</p>
        </div>
        <div class="bid-actions" v-if="authUser.id == bid.user.id">
          <button @click="editBid(bid.id)" class="edit-btn"><img :src="`${$public}/basil_edit-solid.svg`" /></button>
          <button @click="deleteBid(bid.id)" class="delete-btn"><img
              :src="`${$public}/ic_baseline-delete.svg`" /></button>
        </div>
      </div>
    </div>
  </template>
  <script>
  import Auth from "../../auth.js";
  import moment from "moment";
  
  export default {
    name: "Bidding",
    props: {
      bid: Object, // Individual bidding object
    },
    data() {
      return {
        editing: false,
        editPrice: this.bid.price,
        editDescription: this.bid.description,
        authUser: Auth.getUser(),
      };
    },
    methods: {
      toggleEdit() {
        this.editing = !this.editing;
      },
      editBid() {
        this.emitter.emit("currentBid", this.bid);
      },
      cancelEdit() {
        this.editPrice = this.bid.price;
        this.editDescription = this.bid.description;
        this.editing = false;
      },
      formateDate(date) {
        return moment(date).format("MMM DD, YYYY");
      },
  
      deleteBid(id) {
        this.emitter.emit('deleteBid', id);
      }
    },
  
  
  };
  </script>
  
  <style scoped>
  .bid-item {
    display: flex;
    justify-content: space-between;
    margin-left: 50px;
    margin-right: 50px;
    margin-top: 10px;
    margin-bottom: 20px;
  }
  
  .bid-item.highlight {
    background-color: #e0f7fa;
  }
  
  .profile-detail h4 {
    color: #000;
    text-align: center;
    font-family: Inter;
    font-size: 20px;
    font-style: normal;
    font-weight: 500;
    line-height: normal;
    letter-spacing: -1px;
  }
  
  .profile-detail p {
    color: #707485;
    text-align: center;
    font-family: Inter;
    font-size: 14px;
    font-style: normal;
    font-weight: 500;
    line-height: normal;
    letter-spacing: -0.7px;
  }
  
  .bidder-info {
    display: flex;
    align-items: center;
  }
  
  .profile-picture {
    width: 70px;
    height: 70px;
    flex-shrink: 0;
  }
  
  .bidder-details {
    margin-left: 20px;
    margin-top: 20px;
    display: flex;
    flex-direction: column;
    justify-content: center;
  
  }
  
  .bid-amount {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    margin-top: 40px;
    margin-bottom: 20px;
  }
  
  .bid-amount p {
    color: #000;
    text-align: center;
    font-family: Inter;
    font-size: 24px;
    font-style: normal;
    font-weight: 500;
    line-height: normal;
    letter-spacing: -1.8px;
  }
  
  .bid-actions {
    display: flex;
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
  
  .price-section {
    display: flex;
    gap: 40px;
    align-items: center;
    justify-content: center;
    vertical-align: middle;
  }
  </style>
  