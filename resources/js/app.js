require('./bootstrap');

import Vue from 'vue';
window.Vue = Vue;

import { ValidationProvider, ValidationObserver, extend, localize } from "vee-validate";
import * as rules from "vee-validate/dist/rules";
import en from "vee-validate/dist/locale/en.json";
import VueTimepicker from "vue2-timepicker";
import "vue2-timepicker/dist/VueTimepicker.css";
import VueSimpleAlert from "vue-simple-alert";
import vSelect from "vue-select";
import "vue-select/dist/vue-select.css";
import "vue-tel-input/dist/vue-tel-input.css";

import Toast from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";

Vue.component("ValidationProvider", ValidationProvider);
Vue.component("ValidationObserver", ValidationObserver);
Vue.component("v-select", vSelect);

Object.keys(rules).forEach(rule => {
    extend(rule, rules[rule]);
});

localize("en", en);

Vue.use(VueSimpleAlert);
Vue.use(Toast, {
    position: "top-right",
  });

Vue.component("footer-component",require("./components/Footer.vue").default);
Vue.component("header-component",require("./components/Header.vue").default);
Vue.component("home-component",require("./pages/webpages/Index.vue").default);
Vue.component("main-component",require("./components/SimpleLayout.vue").default);
Vue.component("not_found-component",require("./pages/webpages/NotFound.vue").default);
Vue.component("login-component",require("./components/recruiter/LoginComponent.vue").default);
Vue.component("register-component",require("./components/recruiter/RegisterComponent.vue").default);
Vue.component("login-side-bar-component",require("./components/sideBar/loginSideBarComponent.vue").default);
Vue.component("register-side-bar-component",require("./components/sideBar/registerSideBarComponent.vue").default);


const app = new Vue({
    el: '#app',
});
