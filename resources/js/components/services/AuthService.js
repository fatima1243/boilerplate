import axios from 'axios';

export default {
    driverRegister: (data) => axios.post(`/driver/register`, data),
    signUp: (data) => axios.post(`/register`, data),
    addWorkingHours: (data) => axios.post(`/set-working-hours`, data),
    uploadLegalDocument: (data) => axios.post(`/upload-legal-documents`, data),
    login: (data) => axios.post(`/login`, data),
    logout: (data) => axios.post(`/logout`, data),
    sendOtp: (data) => axios.post(`/send-otp`, data),
    resetPassword: (data) => axios.post(`/reset-password`, data),
    socialLogin: (data) => axios.post(`/auth/social-login`, data),
    getStates: () => axios.get(`/get-states`),
    getCities: (data) => axios.post(`/get-cities-based-on-state`, data),
    verifyOTPAndResetPassword: (data) => axios.post(`/verify-otp-reset`, data),
};
