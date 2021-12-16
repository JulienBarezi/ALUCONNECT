<template>
    <div class="auth-container">
            <img :src="'assets/images/ALU-Connect-Logo.png'" alt="logo" class="auth-logo">
            <h5 class="auth-title">Signup Page</h5>
            
            <div class="alert mt-2" style="margin-bottom: 0; text-align: center" 
            :class="{ 'alert-danger': !success, 'alert-success': success,}" v-if="showMsg">
                  {{ message }}
            </div>

            <form class="auth-form" @submit.prevent="register">
            
                <div class="form-group"> 
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><img :src="'assets/images/icons-use/user.png'" class="form-group-img"></div>
                        </div>
                        <input type="text" class="form-control" v-model="formdata.name"  placeholder="Your first name">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><img :src="'assets/images/icons-use/email.png'" class="form-group-img"></div>
                        </div>
                        <input type="email" class="form-control" v-model="formdata.email"  placeholder="Your ALU email address">
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><img :src="'assets/images/icons-use/tag.png'" class="form-group-img" ></div>
                        </div>
                        <input type="text" class="form-control" v-model="formdata.tag"  placeholder="Your tag(Ex: designer, Entrepreneur,...)">
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

                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><img :src="'assets/images/icons-use/login.png'" class="form-group-img"></div>
                        </div>
                        <input type="password" class="form-control" v-model="formdata.password_confirmation" placeholder="Confirm Password">
                    </div>
                </div>
                <button class="btn btn-block auth-btn" type="submit" @click.prevent="register">Submit</button>
                <div class="row plink">
                    <p>Have an account?</p><a><router-link to="/login">Log in</router-link></a>
                </div>
            </form>
        </div>
</template>

<script>
export default {
   data() {
      return {
         formdata: {
            name: "",
            email: "",
            tag: "",
            password: "",
            password_confirmation: "",
         },
         showMsg: false,
         success: false,
         message: "",
      };
   },
   methods: {
      register() {
         console.log(this.formdata);
         this.$store
            .dispatch("users/register", this.formdata)
            .then((response) => {
               console.log(response);
               this.success = true;
               this.message =
                  "User Created Successfully!! redirecting to login.....";
               this.showMsg = true;
               setTimeout(() => {
                  window.location.href = "/login";
               }, 2000);
            })
            .catch((error) => {
               console.log(error);
               this.success = false;
               this.message = "Some of the given data were invalid!!!";
               this.showMsg = true;
            });
      },
      scrollTop: function () {
         this.intervalId = setInterval(() => {
            if (window.pageYOffset === 0) {
               clearInterval(this.intervalId);
            }
            window.scroll(0, window.pageYOffset - 50);
         }, 20);
      },
   },
};
</script>