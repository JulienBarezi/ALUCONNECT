<template>

    <nav class="navbar navbar-expand-lg navbar-light">
            <a class="navbar-brand"><router-link to="/"><img :src="url + '/assets/images/ALU-Connect-Logo.png'" class="logo-img"></router-link></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
          
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto justify-content-center">
                    <li class="nav-item pr-5" :class="{active: isActive('/')}">
                        <a class="nav-link"><router-link to="/">Home</router-link></a>
                    </li>
                    <li class="nav-item pr-5" :class="{active: isActive('/posts')}">
                        <a class="nav-link"><router-link to="/posts">Posts</router-link></a>
                    </li>
                    <li class="nav-item pr-5" :class="{active: isActive('/opportunities')}">
                        <a class="nav-link"><router-link to="/opportunities">Opportunities</router-link></a>
                    </li>
                    <!-- <li class="nav-item pr-5" :class="{active: isActive('/chats')}">
                        <a class="nav-link"><router-link to="/chats">Chats</router-link></a>
                    </li> -->
                    <li class="nav-item" :class="{active: isActive('/profile')}">
                        <a class="nav-link"><router-link to="/profile">Profile</router-link></a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <div class="row">
                            <div class="image-block col-md-3">
                                <router-link to="/profile"><img :src="url + '/uploads/images/' + `${authuser.profile}`" class="user-img"></router-link>
                            </div>
                            
                            <li class="nav-item dropdown col-md-4">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  {{authuser.name}}</a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                  <a class="dropdown-item" @click.prevent="logout"><img :src="url + '/assets/images/icons-use/logout.png'" class="chat-icon mr-2">Logout</a>
                                </div>
                            </li>
                        </div>
                    </li>
                </ul>
            </div>
          </nav>
</template>

<script>
import { mapState } from "vuex";
import axios from "axios";
export default {
   props: ['authuser', 'viewPostactive', 'url'],

   computed:{
        ...mapState("users", ["user"])
    },
    

   methods: {
       
      logout() {
            this.$store
            .dispatch("users/logout", this.user)
            .then((response) => {
            window.location.href = "/login";
            })
            .catch((error) => {
            console.log(error);
            });
      },
      isActive(route) {
         
         let myRoute = window.location.href;
         let baseUrl = axios.defaults.baseURL;
         let dRoute = baseUrl + route;
         if (myRoute == dRoute) {
            return true;
         }
      },
   },
};
</script>

<style scoped>
    .nav-item.active a:hover{
        text-decoration: none
    }

    .user-img{
        border-radius: 55px;
    }
    
</style>