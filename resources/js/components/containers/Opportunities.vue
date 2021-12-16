<template>
    <div class="container-fluid page-container">
        <TheNavigation 
            v-bind:authuser ="Authuser"
            v-bind:url ="url"
        />
        <Opportunities v-bind:authuser ="Authuser" />
    </div>
</template>

<script>
    import { mapState } from "vuex";
    import TheNavigation from "../widgets/common/TheNavigation";
    import Categories from "../widgets/common/Categories";
    import Opportunities from "../widgets/Opportunities"
    export default {
        components: {
            TheNavigation,
            Categories,
            Opportunities
        },

        data(){
            return{
                url: axios.defaults.baseURL,
                categories: [],
                categoryerrors: '',
                Authuser: [],
                Authusererrors: ''
            }
        },

        computed:{
            ...mapState("users", ["user"])
        },

        created(){
            this.getAuthuser();
            this.getcategories();
        },

        methods:{
            getcategories(){
                axios
                .get("api/categories")
                .then((result) => {
                    this.categories = result.data;
                })
                .catch((err) => {
                    this.categoryerrors = err;            
                });
            },

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