<script>

export default {
  components: {
  },
  data() {
    return {
      formData: {
        zipCode: "",
        category_id: null,
      },
      authUser: null,
      isCreatedTask: false,
      isAlertModalVisible: false,
    };
  },
  mounted() {
    this.zipCode = localStorage.getItem("zip_code");
    this.authUser = Auth.getUser();
    this.emitter.on("refreshState", (data) => {
      this.authUser = data;
    });

    this.emitter.on("closeModalCreateTask", () => {
      this.isCreatedTask = false;
      this.isAlertModalVisible = true;
    });

    this.emitter.on("showCreateRequestModal", () => {
      this.isCreatedTask = true;
    });

    this.emitter.on("setCategoryAndService", (data) => {
      this.formData.category_id = data.category_id;
      this.formData.zipCode = data.zipCode;
    });

    this.emitter.on("closeCreateModal", () => {
      this.isCreatedTask = false;
    });
  },

  methods: {
    showLogin(type = null) {
      let user = JSON.parse(window.localStorage.getItem("user"));
      if (user) {
        if (user.role == this.$constants.USER_ROLE.user) {
          this.$router.push({ name: "UserDashboard" });
        } else {
          this.$router.push({ name: type == 1 ? "Pros" : "ProDashboard" });
        }
      } else {
        this.$router.push({ name: "ProHome" });
        this.emitter.emit("resetRole", 1);
        this.emitter.emit("showLoginModal");
      }
    },

    showTaskOrLogin() {
      let user = JSON.parse(window.localStorage.getItem("user"));
      if (user) {
        if (user.role == this.$constants.USER_ROLE["user"]) {
          this.isCreatedTask = true;
        }
      } else {
        this.emitter.emit("resetRole", 0);
        this.$router.push({ name: "Index" });
        this.emitter.emit("showLoginModal");
      }
    },
    navigateToTop() {
      window.scrollTo(0, 0); // Scroll to the top of the page
    },

    showDashboard() {
      window.scrollTo(0, 0);
      let user = Auth.getUser();
      if (user.role == this.$constants.USER_ROLE.pro) {
        this.$router.push({
          name: "ProDashboard",
        });
      } else {
        this.$router.push({
          name: "UserDashboard",
        });
      }
    },

    searchPros(id = null) {
      if (id != null && id != "") {
        this.data.category_id = id;
      }
      if (this.zipCode != "") {
        const routeParams = { name: "Pros", query: { zipcode: this.zipCode } };
        this.$router.push(routeParams);
      } else {
        return;
      }
    },
    testConsole() {},
  },
};
</script>

<template>
<footer class="footer">
   <section class="main-footer px-sm-0 col-xl">
      <div class="main-footer-logo col-sm container-sm ms-xl-0 px-0">
         <div class="row main-footer-content">
          <div class="col col-lg-4 footer-logo-content">
          <div class="footer-logo">
              <a href="#">
                <img :src="`/images/logo/logo.png`" alt="EasyTask" />
              </a>
              <p class="footer-text">
                I really value copy that go with sub copy more than anything
              </p>
              <div class="social-link">
                <a href="">
                  <img
                    :src="`/images/home/fb.png`"
                    alt="#"
                  />
                </a>
                <a href="">
                  <img :src="`/images/home/twiter.png`" alt="#" />
                </a>
                <a href="">
                  <img :src="`/images/home/linkedn.png`" alt="#" />
                </a>              
              </div>
            </div>
         </div>
         <div class="col col-lg-2 product-links">
            <h6>Resources</h6>
            <ul>
              <li><a href="">Blog</a></li>
              <li><a href="">Member Stories</a></li>
              <li><a href="">Video</a></li>
              <li><a href="">Demo</a></li>
            </ul>
         </div>
         <div class="col col-lg-2 company-links">
            <h6>Company</h6>
            <ul>
              <li><a href="">Partnerships</a></li>
              <li><a href="">Terms of use</a></li>
              <li><a href="">Privacy</a></li>
              <li><a href="">Sitemap</a></li>
            </ul>
         </div>
        
         <div class="col col-lg-2 services-links">
          <h6>Get in touch</h6>
          <span>
              <button class="border-0 d-flex align-items-center"> Enter your email
                <img :src="`/images/home/email-icon.png`" alt="" />
              </button>
            </span>
         </div>
         </div>
      </div>
   </section>
    <hr style="border: 1px solid #EDEDED; margin-top: 45px;">
    <div class="footer-bottom text-center">
      <p>© Copyright Mooveto 2023. All rights reserved.</p>
    </div>
</footer>
</template>

