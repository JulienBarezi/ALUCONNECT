<template>
    <div class="container-fluid page-container">
        <TheNavigation 
            v-bind:authuser ="Authuser" 
            v-bind:url = url
        />
        <dashboard />
    </div>
</template>

<script>
    import { mapState } from "vuex";
    import dashboard from "../widgets/dashboard";
    import TheNavigation from "../widgets/common/TheNavigation";
    export default {
        components: {
            TheNavigation,
            dashboard,
        },

        data(){
            return{
                url: axios.defaults.baseURL,
                Authuser: [],
                Authusererrors: ''
            }
        },

        computed:{
            ...mapState("users", ["user"])
        },

        created(){
            // this.getusers();
            this.getAuthuser();
        },

        methods:{

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
        }
    };
</script>