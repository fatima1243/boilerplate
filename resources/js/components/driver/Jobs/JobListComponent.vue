<template>
    <div class="projects-area">
      <div class="title">
        <h1>Jobs</h1>
      </div>
      <div>
        <Search />
      </div>
      <!-- Pass authUserId to JobCard -->
      <JobCard v-for="job in jobs" :key="job?.id" :job="job" :authUserId="authUserId" />
    </div>
  </template>
  
  <script>
 import JobCard from "./JobCard.vue";
  import Search from "../../../components/search/Search.vue"
  import TaskService from "../../services/users/taskApiService";
  import Auth from "../../../auth"; // Import the Auth module to get the authenticated user
  
  export default {
    name: "JobPage",
    components: {
      JobCard,
      Search
    },
    data() {
      return {
        jobs: [],
        authUserId: null, // Hold the authenticated user ID
      };
    },
    mounted() {
      console.log("here");
      this.jobs = this.fetchJobs();
      console.log(this.fetchJobs());
    //   this.emitter.on("placeBid", () => {
    //     this.fetchJobs();
    //   });
      
      // Set the authenticated user ID
      this.user = Auth.getUser(); 
      console.log(this.user);

      this.authUserId = this.user.id
      // console.log(this.authUserId);
    },
    methods: {
       async fetchJobs() {
        const response = await TaskService.getAllJobskList();
        this.jobs = response?.data?.data?.data;
        console.log(this.jobs);
      },
      addBid(jobId, bid) {
        const job = this.jobs.find((job) => job.id === jobId);
        if (job) {
          job.bids.push(bid);
        }
      },
    },
  };
  </script>
  
  <style scoped>
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
  