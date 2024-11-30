<template>
  <div class="pro-details">
    <div class="container flex">
      <div class="about-text">
        <header class="header">
          <div class="rating-holder flex v-center">
            <div class="flex v-center">
              <strong>{{ job?.category?.title }}</strong>
            </div>
          </div>
          <!-- <h1>{{ job?.title }}</h1> -->
          <ul class="list-none flex v-center pro-features">
            <li class="flex v-center">
              <img :src="this.$public + `ico8.png`" alt="#" />
              <span>Customer budget ${{ job.initial_qutation }}</span>
            </li>
            <li class="flex v-center">
              <img :src="this.$public + `date-ico.png`" alt="#" /><span>{{
                this.$functions.formatDate(job?.expected_date)
              }}</span>
            </li>
            <li class="flex v-center">
              <img :src="this.$public + `black-clock.png`" alt="#" />
              <span>{{ formatTime(job?.expected_time) }}</span>
            </li>
          </ul>
          <!-- <ul class="list-none flex v-center pro-tags">
            <li v-for="tag in job?.tags" :key="tag.id">{{ tag?.title }}</li>
          </ul> -->
        </header>
        <div class="pro-bio">
          <h3>Description</h3>
          <p>{{ job.description }}.</p>
        </div>
      </div>
      <!-- customer -->
      <div class="detail-card m__full">
        <strong class="title">Customer details</strong>
        <img
          :src="
            job?.user?.full_profile_path
              ? job?.user?.full_profile_path
              : this.$public + `user-dummy.png`
          "
          :alt="job?.user?.first_name"
        />

        <h2>{{ job?.user?.first_name }} {{ job?.user?.last_name }}</h2>
        <ul class="list-none pro-address">
          <li>
            <img :src="this.$public + `location-ico.png`" alt="#" />
            <span>{{ job?.user?.address }}</span>
          </li>
          <!-- <li>
            <img :src="this.$public + `mail-ico.png`" alt="#" /><span
              ><a :href="`mailto:${job?.user?.email}`">{{
                job?.user?.email
              }}</a></span
            >
          </li>
          <li>
            <img :src="this.$public + `mobile-ico.png`" alt="#" /><span
              ><a :href="`tel:${job?.user?.phone}`">{{
                job?.user?.phone
              }}</a></span
            >
          </li> -->
        </ul>
        <div class="btns">
          <div class="mark-complete">
            <button
              type="button"
              class="btn-complete"
              v-show="job?.status == this.$constants.TASK_STATUS.accept"
              @click="
                updateJobStatus(job, this.$constants.TASK_STATUS.completed)
              "
            >
              Job Done
            </button>
          </div>
          <a href="#" class="report-btn" @click="openModal('report')">
            Report User
          </a>
        </div>
      </div>
      <transition name="modal-fade">
        <Modal :width="`620`" @close="isOPenModal = false" v-if="isOPenModal">
          <template v-slot:body>
            <span
              v-if="isShowRejectModelContent == true"
              class="custom-forms sucess-text"
            >
              <div class="sucess-text">
                <img :src="this.$public + `warning.png`" alt="#" />
                <h2>You’re about to reject your job.</h2>
                <p>If you reject task, this action can’t be undone.</p>
              </div>
              <div class="pop-btns flex v-center">
                <button type="button" class="login-button default">
                  Not Now
                </button>
                <button
                  type="button"
                  class="login-button delete"
                  @click="
                    updateJobStatus(job, this.$constants.TASK_STATUS.reject)
                  "
                >
                  Reject Offer
                </button>
              </div>
            </span>
            <span v-if="isShowReportUserModal" class="custom-forms sucess-text">
              <div class="sucess-text">
                <h2>Tell us why are you reporting this user?</h2>
                <p>
                  Select your reason for reporting and submit to us, we’ll look
                  into this and take necessary actions.
                </p>
              </div>
              <form class="contact-form" @submit.prevent="submitForm">
                <div class="field-row">
                  <div class="field-col">
                    <select
                      v-model="selectedReason"
                      aria-placeholder="Select reason"
                    >
                      <option value="" disabled>Select reason</option>
                      <option value="unprofessional">
                        Unprofessional behavior
                      </option>
                      <option value="deadlines">
                        Failure to meet deadlines
                      </option>
                      <option value="misrepresentation">
                        Misrepresentation or false information
                      </option>
                      <option value="non-compliance">
                        Non-compliance with agreements
                      </option>
                      <option value="communication">
                        Lack of communication
                      </option>
                      <option value="other">Others (please mention)</option>
                    </select>
                    <span class="error-message" v-if="errors.selectedReason">{{
                      errors.selectedReason
                    }}</span>
                  </div>
                </div>
                <div class="field-row">
                  <div class="field-col">
                    <textarea
                      v-model="description"
                      placeholder="Describe your query"
                    ></textarea>
                    <span class="error-message" v-if="errors.description">{{
                      errors.description
                    }}</span>
                  </div>
                </div>
                <!-- <div class="btn">
                  <button type="button" @click="isOPenModal = false">
                    Not Now
                  </button>
                  <button type="submit" class="reject">Report User</button>
                </div> -->
                <div class="pop-btns flex v-center">
                  <button
                    type="button"
                    class="login-button default"
                    @click="isOPenModal = false"
                  >
                    Not Now
                  </button>
                  <button type="submit" class="login-button delete">
                    Report User
                  </button>
                </div>
              </form>
            </span>
          </template>
        </Modal>
      </transition>
    </div>
    <div class="container" v-if="job?.task_galleries?.length">
      <div class="recents">
        <h2>Task photos</h2>
        <div class="cards flex">
          <div class="card relative">
            <img
              :src="job?.task_galleries?.[0]?.full_attachment_path"
              alt="#"
            />
            <button
              type="button"
              @click="onShow"
              v-show="job?.task_galleries.length > 2"
            >
              <img :src="this.$public + `image-ico.png`" />
              Show all photos
            </button>
            <vue-easy-lightbox
              :visible="visibleRef"
              :imgs="imgsRef"
              :index="indexRef"
              @hide="onHide"
              :scrollDisabled="false"
              :moveDisabled="true"
            >
            </vue-easy-lightbox>
          </div>
          <div class="card">
            <img
              :src="job?.task_galleries?.[1]?.full_attachment_path || null"
              alt="#"
              v-show="job?.task_galleries?.[1]?.full_attachment_path"
            />
            <img
              :src="job?.task_galleries?.[2]?.full_attachment_path"
              alt="#"
              v-show="job?.task_galleries?.[2]?.full_attachment_path"
            />
          </div>
        </div>
      </div>
      <!-- <div class="schedule-text">
        <div class="container">
          <div class="text">
            <div class="txt flex v-center">
              <h2>
                Schedule your home service now for a hassle-free experience
              </h2>
              <a class="btn-primary ml-auto" @click="showLogin"
                >Let’s Get Started</a
              >
            </div>
          </div>
        </div>
      </div> -->
    </div>
  </div>
</template>

<script>
import JobService from "@/services/pros/JobService.js";
import Modal from "@/components/Modal.vue";
import ReportUserService from "@/services/ReportUserService.js";
import ImagePreview from "../../../components/ImagePreview.vue";
import VueEasyLightbox from "vue-easy-lightbox";
export default {
  name: "JobDetail",
  components: {
    Modal,
    ImagePreview,
    VueEasyLightbox,
  },

  data() {
    return {
      job: [],
      loading: false,
      isShowImages: false,
      isOPenModal: false,
      isShowRejectModelContent: false,
      isShowReportUserModal: false,
      selectedReason: "",
      description: "",
      to_user_id: "",
      errors: {
        selectedReason: "",
        description: "",
      },
      visibleRef: false,
      indexRef: 0, // default 0
      imgsRef: [],
    };
  },

  mounted() {
    this.getJobDetail();
  },

  methods: {
    showLogin() {
      let user = JSON.parse(window.localStorage.getItem("user"));
      if (user) {
        if (user.role == this.$constants.USER_ROLE.user) {
          this.$router.push({ name: "UserDashboard" });
        } else {
          this.$router.push({ name: "ProDashboard" });
        }
      } else {
        this.emitter.emit("showLoginModal");
      }
    },
    async getJobDetail() {
      this.loading = true;
      const response = await JobService.getJobDetail(
        this.$route.params.id
      ).catch((error) => {
        this.loading = false;
        this.$toast.error(error.response.data.message);
      });
      if (response.data.status == true) {
        this.job = response.data.data;
        this.to_user_id = this.job.user.id;
        this.loading = false;
      }
    },

    async updateJobStatus(data, status) {
      data = {
        task_id: data.id,
        status: status,
      };
      let response = await JobService.updateJobStatus(data).catch((error) => {
        this.$toast.error(error.response.data.message);
      });
      if (response.data.status == true) {
        this.$toast.success(response.data.message);
        this.job = this.getJobDetail();
        this.isOPenModal = false;
        if (status == this.$constants.TASK_STATUS.reject) {
          this.$router.push({ name: "ProDashboard" });
        }
      }
    },

    openModal(data) {
      this.isOPenModal = true;
      if (data == "reject") {
        this.isShowRejectModelContent = true;
        this.isShowReportUserModal = false;
      } else if (data == "report") {
        this.isShowRejectModelContent = false;
        this.isShowReportUserModal = true;
      }
    },

    async submitForm(data) {
      this.errors = {};
      if (!this.selectedReason) {
        this.errors.selectedReason = "Please select a reason.";
      }
      if (!this.description) {
        this.errors.description = "Please provide a description.";
      }

      if (Object.keys(this.errors).length === 0) {
        data = {
          to_user_id: this.to_user_id,
          reason: this.selectedReason,
          description: this.description,
        };
        let response = await ReportUserService.reportUser(data).catch(
          (error) => {
            this.$toast.error(error.response.data.message);
          }
        );
        if (response.data.status == true) {
          this.$toast.success(response.data.message);
          this.isOPenModal = false;
        }
      }
    },
    onShow() {
      this.visibleRef = true;
      this.showMultiple();
    },
    onHide() {
      this.visibleRef = false;
    },
    showMultiple() {
      this.imgsRef = [];
      this.job.task_galleries.forEach(this.iteration);
      this.onShow();
    },
    iteration(image) {
      this.imgsRef.push({ src: image.full_attachment_path, alt: image.alt });
    },
    formatTime(timeString) {
      if (timeString && timeString.length >= 8) {
        const [hourString, minute] = timeString.split(":");
        const hour = +hourString % 24;
        return (hour % 12 || 12) + ":" + minute + (hour < 12 ? "AM" : "PM");
      }
    },
  },
};
</script>
