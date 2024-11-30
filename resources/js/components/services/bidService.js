import axios from 'axios';

export default {
    getAllBids: (taskId) => axios.get(`/bids/all/${taskId}`),
    bidding: (data) => axios.post(`/bids/bidding`, data),
    userAcceptBid: (data) => axios.post(`/bids/accept-bid-request`, data),
    cancelBidRequest: (data) => axios.post(`/bids/bid-request-cancel`, data),
    deleteBid :(id) => axios.delete(`/bids/delete/${id}`),
} 