<template>
    <div class="d-flex panel">
        <login-side-bar-component></login-side-bar-component>
        <div class="right-panel" style="font-family:Inter;">
            <div class="form-container">
                <h2 style="font-size:36px; font-weight: 400;">Log in</h2>
                <p style="color:#8D93A1; font-size: 12px;" class="pt-3">Log in to your account</p>
                <ValidationObserver v-slot="{ handleSubmit }">
                    <form @submit.prevent="handleSubmit(onSubmit)">
                        <div class="field-row">
                            <ValidationProvider name="Email" rules="required|email" v-slot="{ errors }">
                                <input type="email" placeholder="Email address" v-model="email" />
                                <p class="p-error">{{ errors[0] }}</p>
                            </ValidationProvider>
                        </div>
                        <div class="field-row position-relative">
                            <ValidationProvider name="Password" rules="required|min:6" v-slot="{ errors }">
                                <input :type="is_password_visible ? 'text' : 'password'" placeholder="Password"
                                    v-model="password" />
                                <i :class="is_password_visible ? 'fas fa-eye-slash' : 'fas fa-eye'"
                                    @click="toggleShowPassword" class="toggle-eye-icon"></i>
                                <p class="p-error">{{ errors[0] }}</p>
                            </ValidationProvider>
                        </div>
                        <div class="field-row flex">
                            <button class="btn btn-blue w-100" type="submit">
                                {{ loading ? "Loading..." : "Sign In" }}
                            </button>
                        </div>
                    </form>
                </ValidationObserver>
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
                    Want to create an account? <a v-bind:href="'/recruiter/register'">Sign up</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import { ValidationProvider, ValidationObserver } from "vee-validate";
import AuthService from "../services/AuthService";
import Auth from "../../auth";

export default {
    components: {
        ValidationObserver,
        ValidationProvider,
    },
    data() {
        return {
            loading: false,
            email: "",
            password: "",
            notifmsg: {},
            isDisabled: false,
            is_password_visible: false, // State for toggling password visibility
        };
    },
    methods: {
        async onSubmit() {
            this.loading = true;
            this.isDisabled = true;

            const formData = new FormData();
            formData.append("email", this.email);
            formData.append("password", this.password);

            try {
                const response = await axios.post("/recruiter/post-login", formData, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                    },
                });
                let user = response.data.data;
                this.loading = false;
                Auth.login(user.token, user);
                this.$toast.success(response.data.message); // Display success message
                window.location.href = '/jobPosts/create';
            } catch (error) {
                this.loading = false;
                this.isDisabled = false;

                // Display appropriate error messages
                if (error.response && error.response.status === 422) {
                    this.notifmsg = error.response.data.errors; // validation errors
                    this.$toast.error("Validation error. Please check your input.");
                } else if (error.response && error.response.status === 403) {
                    this.notifmsg.general = "Your email address is not verified. Please verify it before logging in.";
                    this.$toast.error(this.notifmsg.general); // Show email verification error
                } else if (error.response && error.response.status === 401) {
                    this.notifmsg.general = "Invalid credentials, Please try again.";
                    this.$toast.error(this.notifmsg.general); // Show invalid credentials error
                } else {
                    this.notifmsg.general = "An error occurred. Please try again.";
                    this.$toast.error(this.notifmsg.general); // General error
                }
            }
        },
        toggleShowPassword() {
            this.is_password_visible = !this.is_password_visible;
        },
    },
};
</script>

<style scoped>
.position-relative {
    position: relative;
}

.toggle-eye-icon {
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    color: #666;
    font-size: 16px;
    /* Adjust size as needed */
}


/* Remaining CSS styles (as provided previously) */

.p-error {
    color: red !important;
}

.social-container {
    display: flex;
    justify-content: center;
    gap: 20px;
    /* space between buttons */
    margin-top: 20px;
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


/* Styling each social button */
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

/* Sign up text */
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
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

input::placeholder {
    color: #B1BBC6;
}

.left-panel,
.right-panel {
    flex: 1;
    padding: 20px;
}

.left-panel {
    background-color: #007bff;
    color: white;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

.left-panel img {
    width: 80%;
    max-width: 300px;
    margin-bottom: 20px;
}

.left-panel p {
    text-align: center;
    margin-bottom: 10px;
}

.right-panel {
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.form-container {
    padding-left: 60px;
    width: 80%;
    max-width: 500px;
}

.form-container h2 {
    margin-bottom: 10px;
    color: #333;
}

.form-container p {
    margin-bottom: 20px;
    color: #777;
}

.form-container form {
    display: flex;
    flex-direction: column;
}

.form-container input {
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 5px;
    width: 100%;
}

.form-container button {
    padding: 10px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.form-container .social-buttons {
    display: flex;
    justify-content: space-between;
    margin: 20px 0;
}

.form-container .social-button {
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    cursor: pointer;
    width: 30%;
    text-align: center;
}

.form-container .social-button.fb {
    background-color: #3b5998;
    color: white;
}

.form-container .social-button.google {
    background-color: #db4437;
    color: white;
}

.form-container .social-button.twitter {
    background-color: #1da1f2;
    color: white;
}

.p-error {
    color: red !important;
}

.images-logo {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 10px
}

/* Responsive design */
@media (max-width: 768px) {
    .container {
        flex-direction: column;
        height: auto;
    }

    .left-panel,
    .right-panel {
        padding: 10px;
    }

    .left-panel {
        text-align: center;
    }
}

/* Hide the left panel and center the right panel on medium screens (768px or smaller) */
@media (max-width: 768px) {
    .left-panel {
        display: none;
        /* Hide the left panel */
    }

    .right-panel {
        flex: 1;
        /* Make the right panel take up the full width */
        justify-content: center;
        /* Center the form vertically */
        align-items: center;
        /* Center the form horizontally */
        padding: 20px;
        /* Add some padding for better spacing */
    }

    .form-container {
        width: 100%;
        /* Full width for the form on smaller screens */
        max-width: 500px;
        /* Limit max-width for better appearance */
        padding: 0 20px;
        /* Add horizontal padding */
    }
}

/* Responsive adjustments */
@media (max-width: 480px) {
    .form-container {
        width: 100%;
        padding: 0 10px;
        /* Smaller padding for extra small devices */
    }
}
</style>
