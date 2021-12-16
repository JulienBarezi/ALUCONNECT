<template>
    <div class="container-fluid page-container">
        <TheNavigation 
            v-bind:authuser ="Authuser" 
            v-bind:url ="url"
        />
        <Post 
            v-bind:authuser ="Authuser"
            @submit="savePost" 
        />
    </div>
</template>

<script>
    import { mapState } from "vuex";
    import TheNavigation from "../widgets/common/TheNavigation";
    import Categories from "../widgets/common/Categories";
    import Post from "../widgets/Post"
    export default {
        components: {
            TheNavigation,
            Categories,
            Post
        },

        data(){
            return{
                url: axios.defaults.baseURL,
                categories: [],
                categoryerrors: '',
                loadposts: false,
                posts: [],
                postserrors: '',
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
            // this.getposts();
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

            savePost(addPostData){
                addPostData.creatingPost = true; 
                addPostData.message='Posting ...';
                var postData = addPostData.post;
                axios.post('/api/posts',postData).then(response=>{
                    if (response.data.status) {
                        addPostData.creatingPost = false; 
                        addPostData.message="Post Created";   
                        addPostData.post.postCategoryId='';
                        addPostData.post.postContent='';
                        addPostData.post.postTime=''; 
                        setTimeout(() => {
                            // this.getposts();
                            //this.scrollTop();
                            addPostData.message="";
                        }, 2000);
                    }
                    else {
                        addPostData.creatingPost = false; 
                        addPostData.message=response.data.message; 
                    }
                })
                .catch(error=>{
                    addPostData.creatingPost = false; 
                    addPostData.message=error.response.data.message; 
                })
            }
        }
    };
</script>