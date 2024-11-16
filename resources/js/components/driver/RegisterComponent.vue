<template>
    <div class="d-flex panel">
      <!-- Left Side: Illustration and Text -->
      <register-side-bar-component></register-side-bar-component>
  
      <!-- Right Side: Registration Form -->
      <div class="right-panel">
        <div class="form-container">
          <h2>Register Driver</h2>
          <p class="text-bold" style="font-weight: bold;">Join the Mooveto Community</p>
          <p>Ready to simplify your delivery needs? Join thousands of satisfied users who trust Mooveto for their everyday goods transport solutions. Signing up is quick and easy—start enjoying the benefits today!</p>
          <p><span style="font-weight: bold;">Sign Up</span> Now and take the first step towards a more connected, efficient, and reliable way to move your items.</p>
  
          <ValidationObserver ref="formObserver" v-slot="{ validate }">
            <form @submit.prevent="validate(submitForm())">
              <!-- Step 1 -->
              <div v-if="step === 1">
                <!-- First Name and Last Name -->
                <div class="field-row flex">
                  <div class="field-col">
                    <ValidationProvider name="First Name" rules="required" v-slot="{ errors }">
                      <input class="fname-input" placeholder="First name" v-model="form.first_name" maxlength="30" />
                      <p class="p-error text-danger" v-if="errors[0]">{{ errors[0] }}</p>
                    </ValidationProvider>
                  </div>
                  <div class="field-col">
                    <ValidationProvider name="Last Name" rules="required" v-slot="{ errors }">
                      <input type="text" placeholder="Last name" v-model="form.last_name" maxlength="30" />
                      <p class="p-error text-danger" v-if="errors[0]">{{ errors[0] }}</p>
                    </ValidationProvider>
                  </div>
                </div>

                <!-- Email -->
                <div class="field-row">
                  <ValidationProvider name="Email" rules="required|email" v-slot="{ errors }">
                    <input type="email" placeholder="Email address" v-model="form.email" />
                    <p class="p-error text-danger" v-if="errors[0]">{{ errors[0] }}</p>
                  </ValidationProvider>
                </div>

                <!-- Phone Number -->
                <div class="field-row">
                  <ValidationProvider name="Phone Number" rules="required|min:10" v-slot="{ errors }">
                    <input type="tel" placeholder="Phone Number" v-model="form.contact_no" />
                    <p class="p-error text-danger" v-if="errors[0]">{{ errors[0] }}</p>
                  </ValidationProvider>
                </div>

                <!-- Password -->
                <div class="field-row">
                  <ValidationProvider name="Password" rules="required|min:6" v-slot="{ errors }">
                    <input type="password" placeholder="Password" v-model="form.password" />
                    <p class="p-error text-danger" v-if="errors[0]">{{ errors[0] }}</p>
                  </ValidationProvider>
                </div>

                <!-- State and City Selects -->
                <div class="field-row flex">
                  <div class="field-col">
                    <ValidationProvider name="State" rules="required" v-slot="{ errors }">
                      <select v-model="form.state_id" @change="handleChnageState" class="form-control">
                        <option value="" disabled>Select State</option>
                        <option v-for="state in states" :value="state.id">{{ state.name }}</option>
                      </select>
                      <p class="p-error text-danger" v-if="errors[0]">{{ errors[0] }}</p>
                    </ValidationProvider>
                  </div>
                  <div class="field-col">
                    <ValidationProvider name="City" rules="required" v-slot="{ errors }">
                      <select v-model="form.city_id" class="form-control">
                        <option value="" disabled>Select City</option>
                        <option v-for="city in cities" :value="city.id">{{ city.name }}</option>
                      </select>
                      <p class="p-error text-danger" v-if="errors[0]">{{ errors[0] }}</p>
                    </ValidationProvider>
                  </div>
                </div>

                <!-- Navigation Buttons -->
                <div class="button-holder">
                  <button @click="nextStep(validate)" type="button" class="social-button fb">Next</button>
                </div>
              </div>

              <!-- Step 2: Document Uploads -->
              <div v-if="step === 2">
                <div class="boxes-holder">
                  <ValidationProvider name="cnic_front" rules="required" v-slot="{ errors }">
                    <strong class="box-title">Driving License Front</strong>
                    <input type="file" @change="handleFileChange($event, 'cnic_front')" />
                    <p class="p-error text-danger" v-if="errors[0]">{{ errors[0] }}</p>
                    <div v-if="form.uploadedImages.cnic_front">
                      <img :src="form.uploadedImages.cnic_front" alt="Front Image" class="uploaded-image" />
                      <button @click="removeImage('cnic_front')" type="button" class="remove-button btn btn-light">Remove</button>
                    </div>
                  </ValidationProvider>

                  <ValidationProvider name="cnic_back" rules="required" v-slot="{ errors }">
                    <strong class="box-title">Identity Card Back</strong>
                    <input type="file" @change="handleFileChange($event, 'cnic_back')" />
                    <p class="p-error text-danger" v-if="errors[0]">{{ errors[0] }}</p>
                    <div v-if="form.uploadedImages.cnic_back">
                      <img :src="form.uploadedImages.cnic_back" alt="Back Image" class="uploaded-image" />
                      <button @click="removeImage('cnic_back')" type="button" class="remove-button btn btn-light">Remove</button>
                    </div>
                  </ValidationProvider>
                </div>

                <div class="boxes-holder">
                  <ValidationProvider name="driving_license" rules="required" v-slot="{ errors }">
                    <strong class="box-title">Driving License Front</strong>
                    <input type="file" @change="handleFileChange($event, 'driving_license')" />
                    <p class="p-error text-danger" v-if="errors[0]">{{ errors[0] }}</p>
                    <div v-if="form.uploadedImages.driving_license">
                      <img :src="form.uploadedImages.driving_license" alt="Driving License" class="uploaded-image" />
                      <button @click="removeImage('driving_license')" type="button" class="remove-button btn btn-light">Remove</button>
                    </div>
                  </ValidationProvider>
                </div>
                
                <div class="boxes-holder">
                  <ValidationProvider name="vehicle_insurance" rules="required" v-slot="{ errors }">
                    <strong class="box-title">Vehicle insurance policy</strong>
                    <input type="file" @change="handleFileChange($event, 'vehicle_insurance')" />
                    <p class="p-error text-danger" v-if="errors[0]">{{ errors[0] }}</p>
                    <div v-if="form.uploadedImages.vehicle_insurance">
                      <img :src="form.uploadedImages.vehicle_insurance" alt="Vehicle Insurance" class="uploaded-image" />
                      <button @click="removeImage('vehicle_insurance')" type="button"
                        class="remove-button btn btn-light">Remove</button>
                    </div>
                  </ValidationProvider>
                </div>

                  <!-- Add more fields for other document uploads similarly -->
            

                <!-- Navigation Buttons -->
                <div class="button-holder flex v-center row">
                  <button  @click="prevStep" type="button" class="social-button google col-6">Back</button>
                  <button  @click="nextStep(validate)" type="button" class="social-button fb col-6">Next</button>
                </div>
              </div>

              <!-- Step 3: Vehicle Details -->
              <div v-if="step === 3">
                <ValidationProvider name="VehicleType" rules="required" v-slot="{ errors }">
                  <label for="vehicleType">Vehicle Type</label>
                  <input type="text" v-model="form.vehicleType" placeholder="Vehicle Type" class="form-group" />
                  <p class="p-error text-danger" v-if="errors[0]">{{ errors[0] }}</p>
                </ValidationProvider>

                <ValidationProvider name="vehicleMakeModel" rules="required" v-slot="{ errors }">
                  <label for="vehicleMakeModel">Vehicle Make/Model</label>
                  <input name="vehicleMakeModel" type="text" v-model="form.vehicleMakeModel" class="form-group"/>
                  <p class="p-error text-danger" v-if="errors[0]">{{ errors[0] }}</p>
                </ValidationProvider>

                <ValidationProvider name="yearOfProduction" rules="required" v-slot="{ errors }">
                  <label for="yearOfProduction">Year of Production</label>
                  <input name="vehicleMakeModel" type="number" v-model="form.yearOfProduction" class="form-group"/>
                  <p class="p-error text-danger" v-if="errors[0]">{{ errors[0] }}</p>
                </ValidationProvider>

                <ValidationProvider name="vehicleColor" rules="required" v-slot="{ errors }">
                  <label for="vehicleColor">Vehicle Color</label>
                  <input name="vehicleColor" type="text" v-model="form.vehicleColor" class="form-group"/>
                  <p class="p-error text-danger" v-if="errors[0]">{{ errors[0] }}</p>
                </ValidationProvider>

                <ValidationProvider name="vehiclePlates" rules="required" v-slot="{ errors }">
                  <label for="vehiclePlates">Vehicle Plates</label>
                  <input name="vehiclePlates" type="text" v-model="form.vehiclePlates" class="form-group"/>
                  <p class="p-error text-danger" v-if="errors[0]">{{ errors[0] }}</p>
                </ValidationProvider>

                <ValidationProvider name="drivingExperience" rules="required" v-slot="{ errors }">
                  <label for="drivingExperience">Driving Experience</label>
                  <input name="drivingExperience" type="text" v-model="form.drivingExperience" class="form-group"/>
                  <p class="p-error text-danger" v-if="errors[0]">{{ errors[0] }}</p>
                </ValidationProvider>

                <div class="social-buttons">
                  <button @click="prevStep" type="button" class="back social-button fb">Back</button>
                  <button  type="submit" class="social-button fb">
                    {{ loading ? "Signing up..." : "Sign Up" }}
                  </button>
                </div>

              </div>
            </form>
          </ValidationObserver>

  
            <!-- Social Media Sign Up Options -->
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
              Already an account? <a href="/driver/login">Login</a>
            </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import { ValidationProvider, ValidationObserver } from "vee-validate";
  import AuthService from "../services/AuthService.js";
  
  export default {
    components: {
      ValidationObserver,
      ValidationProvider,
    },
    data() {
      return {
        step: 1,
        loading: false, // Define loading here for Vue 2
        form: {
          first_name: "",
          last_name: "",
          email: "",
          password: "",
          state_id: "",
          city_id: "",
          contact_no: "",
          uploadedImages: {
            cnic_front: null,
            cnic_back: null,
            driving_license: null,
            vehicle_insurance: null,
          },
          vehicleType: "",
          vehicleMakeModel: "",
          yearOfProduction: "",
          vehicleColor: "",
          vehiclePlates: "",
          drivingExperience: "",
          trafficAccidents: false,
          role: 1,
        },
        states: [],
        cities: [],
        isDisabled: false,
      };
    },
    mounted() {
      this.fetchStates();
    },
    watch: {
      "form.state_id"(newVal) {
        if (newVal) {
          this.handleChnageState();
        }
      },
    },
    methods: {
      async fetchStates() {
        try {
          const response = await AuthService.getStates();
          this.states = response.data.data.map((state) => ({
            id: state.id,
            name: state.name,
          }));
        } catch (error) {
          console.error("Error fetching states:", error);
        }
      },
      handleChnageState() {
        this.fetchCities();
      },
    async fetchCities() {
        try {
          const data = { state_id: this.form.state_id };
          const response = await AuthService.getCities(data);
          this.cities = response.data.data.map((city) => ({
            id: city.id,
            name: city.name,
          }));
        } catch (error) {
          console.error("Error fetching cities:", error);
        }
      },
      handleFileChange(event, type) {
        const file = event.target.files[0];
        if (file) {
          const reader = new FileReader();
          reader.onload = (e) => {
            this.form.uploadedImages[type] = e.target.result;
          };
          reader.readAsDataURL(file);
        }
      },
      removeImage(type) {
        this.form.uploadedImages[type] = null;
        const input = document.querySelector(`#${type}`);
        if (input) input.value = "";
      },
      nextStep(validate) {
      // const valid = await validate();
      console.log("here");
      // if (valid.valid) {
        this.step++;
      // }
      },
      prevStep() {
        if (this.step > 1) this.step--;
      },
      async submitForm() {
        console.log("submit");
        this.loading = true;
        this.isDisabled = true;
        try {
          let formData = new FormData();
          formData.append("cnic_back", this.form.uploadedImages.cnic_back);
          formData.append("cnic_front", this.form.uploadedImages.cnic_front);
          formData.append("driving_license", this.form.uploadedImages.driving_license);
          formData.append("vehicle_insurance", this.form.uploadedImages.vehicle_insurance);
          formData.append("first_name", this.form.first_name);
          formData.append("last_name", this.form.last_name);
          formData.append("email", this.form.email);
          formData.append("password", this.form.password);
          formData.append("state_id", this.form.state_id);
          formData.append("city_id", this.form.city_id);
          formData.append("contact_no", this.form.contact_no);
          formData.append("vehicleType", this.form.vehicleType);
          formData.append("vehicleMakeModel", this.form.vehicleMakeModel);
          formData.append("yearOfProduction", this.form.yearOfProduction);
          formData.append("vehicleColor", this.form.vehicleColor);
          formData.append("vehiclePlates", this.form.vehiclePlates);
          formData.append("drivingExperience", this.form.drivingExperience);
          formData.append("trafficAccidents", this.form.trafficAccidents);
          formData.append("role", this.form.role);
  
          const response = await axios.post("/driver/register", formData, {
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

    },
  };
  </script>
  
  <style>
  .social-container {
    display: flex;
    justify-content: center;
    gap: 20px;
    /* space between buttons */
    margin-top: 20px;
  }
  
  .social-button {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 60px;
    height: 60px;
    border: 1px solid #ddd;
    border-radius: 8px;
    transition: all 0.3s ease;
  }
  
  /* Hover effect */
  .social-button:hover {
    border-color: #aaa;
    cursor: pointer;
  }
  
  /* Social button icons */
  .social-button img {
    width: 30px;
    height: 30px;
  }
  
  .signup-text {
    text-align: center;
    margin-top: 20px;
    font-size: 14px;
  }
  
  .signup-text a {
    text-decoration: none;
    color: #007bff;
    font-weight: bold;
  }
  
  .signup-text a:hover {
    text-decoration: underline;
  }
  
  .separator {
    display: flex;
    align-items: center;
    text-align: center;
    margin: 20px 0;
  }
  
  .separator::before,
  .separator::after {
    content: '';
    flex: 1;
    border-bottom: 1px solid #ddd;
  }
  
  .separator::before {
    margin-right: 10px;
  }
  
  .separator::after {
    margin-left: 10px;
  }
  
  .separator-text {
    color: #B1BBC6;
    font-size: 14px;
  }
  
  
  .panel {
    display: flex;
    width: 100%;
    height: 100vh;
    background-color: #fff;
    overflow: hidden;
  }
  
  .footer {
    position: absolute;
    bottom: 0;
    text-align: center;
    padding: 10px 0;
    background-color: #007bff;
    color: white;
    font-family: Inter, sans-serif;
    font-size: 14px;
  }
  
  .left-panel,
  .right-panel {
    flex: 1;
    padding: 40px;
  }
  
  .left-panel {
    background-color: #007bff;
    color: white;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
  }
  
  .left-panel img {
    width: 60%;
    margin-bottom: 30px;
  }
  
  .left-panel h1 {
    font-size: 2rem;
    margin-bottom: 10px;
  }
  
  .left-panel p {
    margin-bottom: 10px;
    font-size: 1rem;
    line-height: 1.5;
  }
  
  .left-panel a {
    color: white;
    text-decoration: underline;
    display: block;
    margin-top: 10px;
  }
  
  .right-panel {
    background-color: #f8f9fa;
    display: flex;
    flex-direction: column;
    overflow-y: auto;
    height: 100%;
  }
  
  
  .form-container {
    width: 100%;
    max-width: 600px;
    padding-left: 40px;
  }
  
  .form-container h2 {
    font-size: 2rem;
    color: #333;
    margin-bottom: 10px;
  }
  
  .form-container p {
    color: #777;
    font-size: 1rem;
    line-height: 1.5;
    margin-bottom: 20px;
  }
  
  .field-row {
    margin-bottom: 15px;
  }
  
  .field-row.flex {
    display: flex;
    justify-content: space-between;
  }
  
  .field-col {
    flex: 1;
    margin-right: 10px;
  }
  
  .field-col:last-child {
    margin-right: 0;
  }
  
  .form-container input,
  .form-container .vue-tel-input input {
    padding: 12px;
    border: 1px solid #ddd;
    border-radius: 5px;
    width: 100%;
  }
  
  .social-buttons {
    display: flex;
    justify-content: space-between;
    margin: 20px 0;
  }
  
  .social-button {
    padding: 10px;
    width: 30%;
    text-align: center;
    border-radius: 5px;
  }
  
  .social-button.fb {
    background-color: #3b5998;
    color: white;
  }
  .uploaded-image {
    width: 100px;
    height: 100px;
    object-fit: cover;
    display: block;
    margin-top: 10px;
  }
  
  .social-button.google {
    background-color: #db4437;
    color: white;
  }
  
  .social-button.instagram {
    background-color: #E1306C;
    color: white;
  }
  
  .p-error {
    color: red !important;
    margin-top: 5px;
  }
  
  .or {
    margin: 15px 0;
    text-align: center;
    font-size: 1rem;
    color: #666;
  }
  
  .btn-create {
    color: #007bff;
    text-decoration: underline;
    cursor: pointer;
  }
  /* Hide the left panel and center the right panel on medium screens and smaller */
  @media (max-width: 992px) { /* For tablets and smaller */
    .panel {
      display: block; /* Stack elements vertically */
    }
  
    .left-panel {
      display: none; /* Hide the left panel */
    }
  
    .right-panel {
      margin: 0 auto; /* Center the right panel */
      width: 100%; /* Take full width */
      max-width: 600px; /* Optional: control maximum width */
      padding: 20px; /* Adjust padding as needed */
      justify-content: center;
    }
  
    .form-container {
      padding-left: 0; /* Remove padding for the form */
    }
  }
  
  /* Add margin to the right panel on extra-large screens */
  @media (min-width: 1400px) { /* For extra-large screens (e.g., desktops) */
    .form-container {
      width: 100%;
      max-width: 600px;
      padding-left: 80px;
    }
  }
  
  </style>
  