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
    <header/>
    <home-component/>
  </div>
</template>

