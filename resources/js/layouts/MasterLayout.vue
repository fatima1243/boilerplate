<template>
    <div class="header">
      <div class="header-container d-flex justify-content-between align-items-center">
      <div class="log-container">
        <a href="/jobPosts"> <img :src="`/images/home/header-logo.svg`" /></a>
      </div>
      <nav class="navbar navbar-expand-lg auth-menu">
        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
          <ul class="navbar-nav">
            <li v-for="menuItem in menuItems" :key="menuItem.name" class="nav-item">
                <a :href="menuItem.routeName" class="nav-link"> {{ menuItem.name }}</a>
            <!-- <router-link :to="{ name: menuItem.routeName }" class="nav-link">
                {{ menuItem.name }}
              </router-link> -->
            </li>
          </ul>
        </div>
      </nav>
      <div class="user-menu d-flex justify-content-between align-items-center">
        <div class="notification-icon">
          <a href="#"><img :src="`/images/home/bell.svg`" /></a>
        </div>
        <div class="profile-icon" @click="toggleProfileDropdown">
          <a href="#"><img :src="`/images/home/user.png`" /></a>
        </div>
        <div class="dropdown-menu-card" v-if="profileDropdown">
          <div>
            <ul class="navbar-nav">
              <li class="nav-item ">
                <a @click="logout" class="nav-link">
                  <img :src="`${$public}/logout.png`" alt="">
                  logout
                </a>
              </li>
              <li class="nav-item">
                <a @click="goToSettings" class="nav-link">
                  <img :src="`${$public}/setting.png`" alt="">
                Setting</a>
              </li>
            </ul>
          </div>
  
        </div>
      </div>
    </div>
    <div class="my-content">
      <!-- <RouterView /> -->
      <component :is="dynamicComponent"></component>
    </div>
    </div>
  </template>
  
  <script>
  export default {
    name: 'Navbar'
  };
  </script>
  
  
  <script setup>
  import { ref, onMounted,mounted, onUnmounted, getCurrentInstance, computed } from "vue";
  // import AuthService from "../../services/AuthService.js";
  import { userMenu, driverMenu } from './menu.js';
  
  const user = ref(null); // Replace this with actual user data as needed
  const profileDropdown = ref(false);
  const messageCount = ref(0);
  const { proxy } = getCurrentInstance();
  
  const props = defineProps({
    role: {
      type: String,
      required: true
    },

    dynamicComponent: {
      type: String,
      required: true
    },
  })
  
  const menuItems = computed(() => {
    return props.role === "1" ? driverMenu : userMenu;
  });
  
  onUnmounted(() => {
    alert(`Role value: ${props.role}`);
    window.removeEventListener("click", clickEventListener);
  });
  
  function toggleProfileDropdown() {
    profileDropdown.value = !profileDropdown.value;
  }
  function clickEventListener(event) {
    const profileIcon = document.querySelector('.profile-icon');
    const dropdownMenu = document.querySelector('.dropdown-menu-card');
    if (profileDropdown.value && !profileIcon.contains(event.target) && !dropdownMenu.contains(event.target)) {
      profileDropdown.value = false;
    }
  }
  
  
  function logout() {
    AuthService.logout()
      .then(({ data }) => {
        if (data.statusCode != 200) {
          proxy.$toast.error(`Error: ${data.message}`);
        } else {
          localStorage.clear();
          proxy.$toast.success("Logged out successfully!");
          proxy.emitter.emit("logout-success");
          router.push({ name: "Index" });
          window.location.reload();
        }
      })
      .catch((error) => {
        proxy.$toast.error(error.response.data.message);
      });
  }
  function goToSettings() {
    profileDropdown.value = false;
  
    router.push({ name: "UpdateProfile" });
  
  }
  
  onMounted(() => {
    user.value = {
      role: 0,
      full_profile_path: null,
    };
    window.addEventListener("click", clickEventListener);
  });
  
  </script>
  
  <style scoped>
  .header{
    background-color: #EEF5FF;
  }
  .my-content{
    padding-bottom: 50px;
  }
  .auth-menu .nav-link {
    color: #313131;
    font-family: Poppins;
    font-size: 18px;
    font-style: normal;
    font-weight: 400;
    line-height: normal;
  }
  
  .auth-menu .nav-link:hover {
    color: #007bff;
  }
  
  .nav-link.active {
    position: relative;
    padding-bottom: 10px;
  }
  
  .nav-link.active::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 3px;
    /* Change this to the desired thickness */
    background-color: #0D6EFD;
    border-radius: 0 0 5px 5px;
    /* Adjust the border-radius as needed */
  }
  
  .notification-icon {
    color: #FFF;
    font-family: Inter;
    padding-right: 20px;
  }
  
  .profile-icon {
    width: 50px;
    height: 50px;
    border-radius: 60px;
    border: 2px solid #0D6EFD;
  }
  
  .profile-icon img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }
  
  .log-container {
    background-color: #0D6EFD;
      padding: 20px;
      display: flex;
      align-self: baseline;
    /* padding: 6px;
    background-color: #0D6EFD;
    border: 2px solid #FFF;
    width: 118px;
    height: 84px; */
  
  }
  .nav-item{
    padding: 10px;
  }
  
  .dropdown-menu-card {
    position: absolute;
    top: 110px;
    right: 40px;
    background: white;
    border: 1px solid #ddd;
    border-radius: 5px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    z-index: 1000;
    width: 200px;
    /* padding: 20px; */
  }
  
  .dropdown-menu-card a {
    color: #313131;
    font-family: Poppins;
    font-size: 18px;
    font-style: normal;
    font-weight: 400;
    line-height: normal;
    display: flex;
    align-items: center;
    gap: 10px;
  }
  
  .dropdown-menu-card li:hover {
    background: #EEF5FF;
    color: #fff;
    transition: background 0.3s ease;
    font-family: Poppins;
    font-size: 18px;
    font-style: normal;
    font-weight: 400;
    line-height: normal;
    /* padding: 10px; */
  }
  </style>