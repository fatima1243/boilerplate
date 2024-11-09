<script>

export default {
  created() {
    console.log("Auth layout created");
    this.setAppLoading(false); // Ensure this function is defined or accessible
  },
  methods: {
    pushRoute(data) {
      // Accessing `this.$router` directly instead of `useRouter`
      this.$router.push({ name: data });
    },
    setAppLoading(state) {
      // Define your setAppLoading function here if it’s not defined elsewhere
      console.log("App loading state:", state);
    }
  }
};
</script>
<template>
  <div>
    <header-component/>
    <home-component/>
    <footer-component/>
  </div>
</template>
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