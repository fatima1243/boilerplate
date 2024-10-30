<script setup>
import { ref, onMounted, onUnmounted, getCurrentInstance } from "vue";
import SimpleLayout from "./layouts/SimpleLayout.vue";
import MasterLayout from "./layouts/MasterLayout.vue";
import Auth from "./auth.js";
import { useAppStore } from "./stores/app";
const { proxy } = getCurrentInstance();

const appStore = useAppStore();

const isLogin = ref(false);
const user = ref(null);
const userType = ref("");

onMounted(() => {

  const handleLoginSuccess = () => {
    user.value = Auth.getUser();
    if (user.value) {
      userType.value = user.value.role;
      isLogin.value = true;
    }
  };

  const handleLogout = () => {
    user.value = null;
    userType.value = null;
    isLogin.value = false;
  };

  proxy.emitter.on("login-success", handleLoginSuccess);
  proxy.emitter.on("logout-success", handleLogout);
  handleLoginSuccess();
});

onUnmounted(() => {
  proxy.emitter.off("login-success", handleLoginSuccess);
  proxy.emitter.off("logout-success", handleLoginSuccess);
});
</script>

<template>
  <MasterLayout v-if="user" :role="user?.role" />

  <SimpleLayout v-if="!isLogin && !user" />
</template>

<style scoped>
/* Add your styles here */
</style>
<template>
  <div id="app">
    <router-view></router-view>
  </div>
</template>

