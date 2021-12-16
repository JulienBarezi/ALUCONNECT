<template>
    <div class="container-fluid page-container">
        <TheNavigation 
            v-bind:authuser ="Authuser" 
            v-bind:url ="url"
        />
        <div class="main">
            <div class="row main-row">
                <Categories 
                    v-bind:categories ="categories" 
                    v-bind:url ="url"
                
                />
                <ViewPost 
                    v-bind:authuser ="Authuser" 
                    v-bind:url ="url"
                />

                <div class="col-md-2"></div>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapState } from "vuex";
    import TheNavigation from "../widgets/common/TheNavigation";
    import Categories from "../widgets/common/Categories";
    import ViewPost from "../widgets/ViewPost"
    import axios from "axios";
    export default {
        components: {
            TheNavigation,
            Categories,
            ViewPost
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

        methods: {
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
    }
</script>