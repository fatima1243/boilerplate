import axios from "axios";
// alert(`${import.meta.env.VITE_APP_URL}`)
export default {
  // listTasks: (status) => axios.get(`/get-all-task?status=${status}`),
  addTask: (data) => axios.post(`/jobPosts`, data),
  deleteTask: (id) => axios.delete(`/delete-task/${id}`),
  list: (page, search, orderBy) =>
    axios.get(`/jobPosts?page=${page}&search=${search}&orderBy=${orderBy}`),
  show: (data) => axios.get(`/get-task-by-id/${data}`),
  updateTask: (data) => axios.post(`/jobPosts`, data),
  getAllJobskList: (data) => axios.get(`/all-jobs-listing`),
  getJobDetailById: (id) => axios.get(`/get-job-detail/${id}`),
  currentJob: () => axios.get("/current-job"),
  jobHistories: () => axios.get("/job-histories"),

  cancelTask: (data) => axios.post(`/services/cancel-entire-job`, data),
  listWithOutPagination: () => axios.get(`/get-all-task-listing`),
  updateSchedule: (data) => axios.post(`/update-schedule`, data),
  cancelRequest: (data) => axios.post(`/job-request-cancel`, data),
  acceptRequest: (data) => axios.post(`/accept-task-request`, data),
  getTasks: (data) => axios.post(`/get-all-tasks`, data),
  getTaskDetailById: (id) => axios.get(`/get-task-detail/${id}`),
  sendRequest: (data) => axios.post(`/assign-task`, data),
  startChat: (data) => axios.post(`/chat/create-room`, data),
  getChat: (data) => axios.post(`/chat/get-room`, data),
  checkStripeCard: () => axios.get(`/is-card-add`),
  isExistTask: () => axios.get(`/is-exist-task`),
  loadPaginate: (path) => axios.get(path),
};
