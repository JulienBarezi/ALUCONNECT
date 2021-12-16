<template>
    <div class="auth-container login-container">
            
            <img :src="'assets/images/ALU-Connect-Logo.png'" alt="logo" class="auth-logo">
            <h5 class="auth-title">Login Page</h5>
            
            <div class="alert mt-2" style="margin-bottom: 0; text-align: center" 
            :class="{ 'alert-danger': !success, 'alert-success': success,}" v-if="showMsg">
                  {{ message }}
            </div>

            <form class="auth-form" @submit.prevent="login">
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text "><img :src="'assets/images/icons-use/email.png'" class="form-group-img"></div>
                        </div>
                        <input type="email" class="form-control" v-model="formdata.email"  placeholder="Your ALU email address">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><img :src="'assets/images/icons-use/password.png'" class="form-group-img"></div>
                        </div>
                        <input type="password" class="form-control" v-model="formdata.password" placeholder="Password">
                    </div>
                </div>
                <button class="btn btn-block auth-btn" type="submit" @click="login">Submit</button>
                <div class="row plink">
                    <p>Don't have an account?</p><a><router-link to="/register">Sign up</router-link></a>
                </div>
            </form>
        </div>
</template>

<script>

export default {
   data() {
      return {
         formdata: {
            email: "",
            password: "",
         },
         showMsg: false,
         success: false,
         message: "",
      };
   },
   methods: {
      login() {
         this.$store
            .dispatch("users/login", this.formdata)
            .then((response) => {
               console.log("response", response);
               this.success = true;
               this.message = "Logging in.....";
               this.showMsg = true;
               setTimeout(() => {
                  window.location.href = "/";
               }, 2000);
            })
            .catch((error) => {
               console.log(error);
               this.success = false;
               this.message = error.response.data.message;
               this.showMsg = true;
            });
      },
   },
};

</script>