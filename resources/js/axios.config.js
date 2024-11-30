import axios from "axios";
import config from './config';

// ======================Axios configuration===============================
// axios.defaults.baseURL = 'http://127.0.0.1:8000/api/';
axios.defaults.baseURL = config.apiUrl;
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.headers.common['Accept'] = 'application/json';

axios.interceptors.request.use(
    function (config) {
        if (localStorage.getItem("token") === null || localStorage.getItem("token") === "undefined") {
            config.headers.Authorization = ""; // Update Authorization header
        } else {
            config.headers.Authorization = `Bearer ${localStorage.getItem("token")}`; // Update Authorization header
        }
        return config;
    },
    function (error) {
        return Promise.reject(error);
    }
);

axios.interceptors.response.use(
    function (response) {
        return response;
    },
    function (error) {
        if (error.response.status === 401) {
            localStorage.removeItem("token");
            localStorage.removeItem("user");
            router.push({ path: '/' })
        }
        return Promise.reject(error);
    }
);

export default axios;
// ======================Axios configuration===============================