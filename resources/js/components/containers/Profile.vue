<template>
    <div class="container-fluid page-container">
        <TheNavigation 
            v-bind:authuser ="Authuser" 
            v-bind:url = url
        />
        <Profile 
            @submit="updateProfile"
            v-bind:updatingprofile="updatingprofile"
            v-bind:message="updatemessage"
            v-bind:authuser ="Authuser"
        /> 
    </div>
</template>

<script>
    import { mapState } from "vuex";
    import TheNavigation from "../widgets/common/TheNavigation";
    import Profile from "../widgets/Profile"
    export default {
        components: {
            TheNavigation,
            Profile
        },

        data() {
            return {
                url: axios.defaults.baseURL,
                updatingprofile:false,
                updatemessage:'',
                Authuser: [],
                Authusererrors: ''
            };
        },

        created(){
            // this.getusers();
            this.getAuthuser();
        },

        computed:{
            ...mapState("users", ["user"])
        },

        methods: {

            getAuthuser(){
                axios
                .get("api/users/"+this.user.user.id+"")
                .then((result) => {
                    this.Authuser = result.data;
                })
                .catch((err) => {
                    this.Authusererrors = err;            
                });
            },

            updateProfile(updateProfileData) {
                
                this.updatingprofile = true; 
                this.updatemessage='Sending data...';
                axios.post("/api/edit-profile", updateProfileData).then(response=>{
                    if (response.data.status) {
                        this.updatingprofile = false; 

                        setTimeout(() => {
                            this.getAuthuser();
                            this.updatemessage='Updated';
                        }, 2000);
                    }
                    else {
                        this.updatingprofile = false; 
                        this.updatemessage=response.data.message; 
                    }
                })
                .catch(error=>{
                    this.updatingprofile = false; 
                    this.updatemessage=error; 
                })
            },
        }

    };
</script>