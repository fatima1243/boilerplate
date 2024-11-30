<template>
    <div>
        <div class="projects-area">
            <div class="title">
                <h2>Jobs List</h2>
            </div>
            <div v-if="jobs.length > 0">
                <div>
                    <Search />
                </div>
                <JobCard v-for="job in jobs" :key="job.id" :job="job" />
            </div>
            <div v-else>
                <p class="no-record-found">No jobs found</p>
            </div>
        </div>

        <Modal modalSize="600" :show="isModalDelete" @close="isModalDelete = false">
            <template v-slot:header>
                <h2>Delete JOb</h2>
            </template>
            <template v-slot:body>
                <section>
                    <P class="delete-content">Are you sure you want to delete Job? This action cannot be undone.</P>
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
import Vue from 'vue';
export const EventBus = new Vue();
import JobCard from "../../components/recruiter/JobCard.vue";
import Search from "../../components/search/Search.vue"
import TaskService from "../services/users/taskApiService";
import Modal from "../../components/modal/Modal.vue";
  import auth from "../../auth.js"

export default {
    name: "JobList",
    components: {
        JobCard,
        Search,
        Modal
    },
    data() {
        return {
            jobs: [],
            task_id: null,
            isModalDelete: false,
            search: '',
            orderBy: '',
            loader: false,
            page: 1,
            userId: auth.user.user.id
        };
    },

    created() {
        // This will log when the component is created
      
    },
    mounted() {
        console.log("userId");

        console.log(this.userId);
          this.jobs = this.fetchJobs();
          console.log(this.fetchJobs());
        // this.emitter.on('search', (search) => {
        //     this.search = search;
        //     this.fetchJobs();
        // })
        // this.emitter.on("filter", (orderBy) => {
        //     this.orderBy = orderBy;
        //     this.fetchJobs();
        // })
    },
    methods: {
        async fetchJobs() {
            console.log(this.userId)
            const response = await TaskService.list(this.userId,this.page, this.search, this.orderBy);
            console.log(response)
        if (response.status) {
                this.jobs = response?.data?.data?.data;
                console.log(this.jobs);
            }
        },

        async confirmDelete() {
            try {
                this.loader = true;
                const response = await TaskService.deleteTask(this.task_id);
                if (response.data.status == true) {
                    this.isModalDelete = false;
                    this.loader = false;
                    this.$toast.success(response.data.message);

                    this.fetchJobs();
                } else {
                    this.loader = false;
                    this.$toast.error(response.data.message);
                }
            } catch (error) {
                this.loader = false;
                this.$toast.error(error.message);
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

.no-record-found {
    text-align: center;
    font-family: Inter;
    font-size: 32px;
    font-style: normal;
    font-weight: 700;
    line-height: normal;
    letter-spacing: -0.4px;
    margin-top: 10px;
    vertical-align: middle;
}
</style>
