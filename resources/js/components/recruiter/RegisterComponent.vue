<template>
  <div class="d-flex panel">
    <register-side-bar-component></register-side-bar-component>
    <div class="right-panel">
      <div class="form-container">
        <h2>Sign Up</h2>
        <p class="text-bold" style="font-weight: bold;">Join the Mooveto Community</p>
        <p>Ready to simplify your delivery needs? Join thousands of satisfied users who trust Mooveto for their everyday
          goods transport solutions. Signing up is quick and easy—start enjoying the benefits today!</p>
        <p><span style="font-weight: bold;">Sign Up</span> Now and take the first step towards a more connected,
          efficient, and reliable way to move your items.</p>

        <ValidationObserver ref="formObserver" v-slot="{ handleSubmit }">
          <form @submit.prevent="handleSubmit(signUp)">
            <!-- First Name and Last Name Fields -->
            <div class="field-row flex">
              <div class="field-col">
                <ValidationProvider name="First Name" rules="required" v-slot="{ errors }" mode="lazy">
                  <input class="fname-input" placeholder="First name" v-model="first_name" maxlength="30" />
                  <p class="p-error text-danger" v-if="errors[0] || notifmsg.firstName">{{ errors[0] ||
                    notifmsg.firstName[0] }}</p>


                </ValidationProvider>
              </div>
              <div class="field-col">
                <ValidationProvider name="Last Name" rules="required" v-slot="{ errors }" mode="lazy">
                  <input type="text" placeholder="Last name" v-model="last_name" maxlength="30" />
                  <p class="p-error text-danger" v-if="errors[0] || notifmsg.lastName">{{ errors[0] ||
                    notifmsg.lastName[0] }}</p>
                </ValidationProvider>
              </div>
            </div>

            <!-- Email and Phone Fields -->
            <div class="field-row flex">
              <div class="field-col">
                <ValidationProvider name="Email" rules="required|email" v-slot="{ errors }" mode="lazy">
                  <input v-model="email" type="email" placeholder="Email address" autocapitalize="off" />
                  <p class="p-error text-danger" v-if="errors[0] || notifmsg.email">{{ errors[0] || notifmsg.email[0] }}
                  </p>
                </ValidationProvider>
              </div>
              <div class="field-col">
                <ValidationProvider name="Phone" rules="required|min:10" v-slot="{ errors }" mode="lazy">
                  <input v-model="phone" type="tel" placeholder="Phone number" @input="validatePhoneInput" />
                  <p class="p-error text-danger" v-if="errors[0]">{{ errors[0] }}</p>
                </ValidationProvider>
              </div>
            </div>

            <!-- Post Code Field -->
            <div class="field-row">
              <ValidationProvider name="Post Code" rules="required" v-slot="{ errors }" mode="lazy">
                <input placeholder="Post Code" class="post-input" v-model="post_code" />
                <p class="p-error text-danger" v-if="errors[0] || notifmsg.post_code">{{ errors[0] ||
                  notifmsg.post_code[0] }}</p>
              </ValidationProvider>
            </div>

            <!-- Password Field with Show/Hide Toggle -->
            <div class="field-row position-relative">
              <ValidationProvider name="Password" rules="required|min:6" v-slot="{ errors }" mode="lazy"
                vid="confirmation">
                <input :type="is_password_visible ? 'text' : 'password'" placeholder="Password" v-model="password" />
                <i :class="is_password_visible ? 'fas fa-eye' : 'fas fa-eye-slash'" @click="toggleShowPassword"
                  class="toggle-eye-icon"></i>
                <p class="p-error text-danger" v-if="errors[0]">{{ errors[0] }}</p>
              </ValidationProvider>
            </div>

            <!-- Confirm Password Field with Show/Hide Toggle -->
            <div class="field-row position-relative">
              <ValidationProvider name="Confirm Password" rules="required|confirmed:confirmation" v-slot="{ errors }"
                mode="lazy">
                <input :type="is_password_visible ? 'text' : 'password'" placeholder="Confirm Password"
                  v-model="confirmation_password" />
                <i :class="is_password_visible ? 'fas fa-eye' : 'fas fa-eye-slash'" @click="toggleShowPassword"
                  class="toggle-eye-icon"></i>
                <p class="p-error text-danger" v-if="errors[0]">{{ errors[0] }}</p>
              </ValidationProvider>
            </div>

            <!-- Terms and Conditions -->
            <div class="field-row text">
              <input v-model="is_term_accepted" type="checkbox" id="accept-terms" required
                style="width: 20px; height: 20px;" class="" />
              <label for="accept-terms" class="fancy-checkbox ml-2">
                Accept to Privacy Policy and Terms & Conditions
              </label>
            </div>

            <!-- Submit Button -->
            <div class="field-row">
              <button :disabled="loading" type="submit" class="w-100 btn btn-primary btn-lg">
                Sign Up
              </button>
            </div>
          </form>
        </ValidationObserver>

        <!-- Social Media Sign Up Options -->
        <div class="mt-2 mb-2 d-flex justify-content-end">
          <a v-bind:href="'/'" class="btn-create"
              style="color:black !important; text-decoration: none; font-size:14px;">
              Forgot Password?
          </a>
      </div>
      <div class="separator">
          <span class="separator-text">Or sign in with</span>
      </div>
      <div class="social-container">
          <div class="social-button">
              <img src="/images/HomePage/fb.png" alt="Facebook">
          </div>
          <div class="social-button">
              <img src="/images/HomePage/google.png" alt="Google">
          </div>
          <div class="social-button">
              <img src="/images/HomePage/insta.png" alt="Instagram">
          </div>
      </div> 

        <!-- Sign up text -->
        <div class="signup-text">
          Already have an account? <a v-bind:href="'/recruiter/login'">Sign In</a>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import { ValidationProvider, ValidationObserver } from "vee-validate";

export default {
  components: {
    ValidationObserver,
    ValidationProvider
  },
  data() {
    return {
      is_password_visible: false,
      loading: false,
      first_name: "",
      last_name: "",
      email: "",
      phone: "",
      post_code: "",
      password: "",
      confirmation_password: "",
      is_term_accepted: false,
      notifmsg: {},
      isDisabled: false,
    };
  },
  methods: {
    async signUp() {
      this.loading = true;
      this.isDisabled = true;

      const formData = new FormData();
      formData.append("firstName", this.first_name);
      formData.append("lastName", this.last_name);
      formData.append("email", this.email);
      formData.append("password", this.password);
      formData.append("confirm_password", this.confirmation_password);
      formData.append("contact_no", this.phone);
      formData.append("post_code", this.post_code);

      try {
        const response = await axios.post("/recruiter/register-post", formData, {
          headers: {
            "Content-Type": "multipart/form-data",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
          },
        });
        this.loading = false;
        this.$toast.success(response.data.message); // Display success message
      } catch (error) {
        this.loading = false;
        this.isDisabled = false;

        // Capture field-specific errors
        if (error.response && error.response.status === 422) {
          this.notifmsg = error.response.data.errors; // store field errors in notifmsg object
        } else {
          this.notifmsg.general = "An error occurred."; // fallback for general errors
        }
      }
    },
    toggleShowPassword() {
      this.is_password_visible = !this.is_password_visible;
    },
    validatePhoneInput() {
      const inputValue = this.phone;
      const cleanedValue = inputValue.replace(/[^+\d\s]/g, "");
      this.phone = cleanedValue;
    },
  }
};
</script>

<style scoped>
.p-error {
  color: red;
  font-size: 0.9em;
}

.position-relative {
  position: relative;
}

.toggle-eye-icon {
  position: absolute;
  right: 10px;
  top: 50%;
  transform: translateY(-50%);
  cursor: pointer;
  color: #666;
}
</style>
