<template>
   <div class="App">
      <transition name="fade">
         <router-view />
      </transition>
   </div>
</template>
<script>
export default {
   name: "App",
   data() {
      return {};
   },
   created() {
      const userInfo = localStorage.getItem("user");
      axios.interceptors.response.use(
         (response) => response,
         (error) => {
            console.log(error);
            console.log(error.response);
            if (error.response.status == 401) {
               console.log("err=>401");
               localStorage.removeItem("user");
               window.location.href = "/login";
            }
            return Promise.reject(error);
         }
      );
      if (userInfo) {
         const userData = JSON.parse(userInfo);
         this.$store.commit("users/setUserData", userData);
         this.$store.dispatch("users/users");
      }
   },
};
</script>
