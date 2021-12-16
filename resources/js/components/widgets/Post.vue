<template>
    <div class="main">
        <div class="row main-row">
            <div class="sidebar col-md-2">
                <form action="#" class="formsearch">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text "><img :src="'assets/images/icons-use/searching.png'" class="form-group-img"></div>
                            </div>
                            <input type="email" class="form-control" id="email"  placeholder="Search">
                        </div>
                    </div>
                </form>

                <ul class="list-group list-group-flush">
                    <li class="list-group-item" value="all" @click="getfilteredpost('all', -1, 'all')" :class="{'active' : activeIndex === -1}">All</li>
                    <li class="list-group-item" v-for="(category, index) in postData.categories" :key="category.id" :value="category.id" 
                    @click="getfilteredpost(category.id, index, category)" :class="{'active' : activeIndex === index}">
                        {{category.categoryName}}
                    </li>
                </ul>
            </div>
            
            <div class="main-content col-md-6">
                <h6 class="main-heading">Posts/{{categoryname}}</h6>
                <div class="create-post">
                    <div class="row create-post-row">
                        <div class="col-md-1">
                            <img :src="'uploads/images/' + `${authuser.profile}`" alt="" class="post-img">
                        </div>
                        
                        <div class="col-md-10" style="padding-left: 0;">
                            <select class="post-select" v-model="postData.post.postCategoryid"> 
                                <option value="">Select category</option>
                                <option v-for="(category, index) in postData.categories" :key="category.id" :value="category.id">{{category.categoryName}}</option>
                            </select>

                            <textarea class="form-control txta border-0 pl-0 pt-0" id="comment" placeholder="Select a category above first to post"
                            v-model="postData.post.postContent"></textarea>              

                            <div class="row">
                                <div class="col-md-12">
                                    <button class="attach-btn" v-if="postData.creatingPost">
                                        <span
                                            class="spinner-border spinner-border-sm"
                                            role="status"
                                        ></span>
                                    </button>
                                    <button class="attach-btn" @click="savePost" v-else>Post</button>
                                    <span class="updatemessage">{{postData.message}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div v-if="posts.length > 0">
                    <div class="display-content display-posts" v-for="(post, index) in posts" :key="post.id">
                        <div class="row display-content-row">
                            <div class="col-md-1">
                                <img :src="'uploads/images/' + `${post.user.profile}`" alt="" class="post-img">
                            </div>
                            <div class="col-md-1" style="max-width: 5.33333%;"></div>
                            <div class="col-md-10 profile-container" style="padding-left: 0;">
                                <a href="#" class="profile-name">{{post.user.name}}</a>
                                <p class="user-email">{{post.user.email}}</p>
                                <p class="profile-tag">{{post.user.tag}}</p>
                                <p class="post-time">{{post.postTime}}</p>

                                <div class="profile-post">
                                    <p>{{post.postContent}}</p>
                                </div>

                                <div class="row like-comment">
                                    <span class="iconp iconp-comment col-md-3"><img :src="'assets/images/icons-use/comment.png'" alt="" class="lcicon">
                                    <router-link :to="'post/view/' + post.id">{{post.comments.length}} Thoughts</router-link></span>
                                </div>
                            </div>

                        </div> 
                    </div>
                </div>
                <div v-else>
                    <div v-if="loadposts" class="mt-5">
                        <center><p>Loading the posts <span class="spinner-border spinner-border-sm" role="status"></span></p></center>
                    </div>

                    <div v-else class="mt-5">
                        <center><p>No posts created here</p></center>
                    </div>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>
</template>

<script>
import { mapState } from "vuex";
    export default {
        props: ['categories', 'loading', 'error', 'authuser'],

        data(){
            return{
                activeIndex: -1,
                categoryname: 'All',
                posts: [],
                loadposts: false,
                postserror: '',
                timeDiff: '',
                postData: {
                    creatingPost: false,
                    message: '',
                    categories: [],
                    post:{
                        postUserid: '',
                        postCategoryid: '',
                        postContent: '',
                        postTime: ''
                    }
                }
            }
        },

        created(){
            this.getposts();
            this.getcategories();
        },

        methods:{

            getfilteredpost($category, index, $cat){
                if($cat == 'all'){
                    this.categoryname = 'All';
                }

                else{
                    this.categoryname = $cat.categoryName;
                }

                this.activeIndex = index;
                this.loadposts = true;
                let id = $category;
                if($category == 'all'){
                    var link = "api/posts/";
                }
                else{
                    var link = "api/posts/category/"+$category+"";
                }

                axios
                .get(link)
                .then((result) => {
                    this.posts = result.data;
                    console.log(this.posts); 
                    this.loadposts = false;          
                })
                .catch((error) => {
                    this.postserrors = error.response.data.message;
                    for (const property in error.response.data.errors) {
                        this.postserrors += " "+error.response.data.errors[property];
                    }       
                    this.loadposts = false;
                });
            },

            getposts(){
                this.loadposts = true;
                axios
                .get("api/posts")
                .then((result) => {
                    this.posts = result.data;
                    console.log(this.posts);
                    this.loadposts = false;
                })
                .catch((error) => {
                    this.postserrors = error.response.data.message;
                    for (const property in error.response.data.errors) {
                        this.postserrors += " "+error.response.data.errors[property];
                    }       
                    this.loadposts = false;
                });
            },

            getcategories(){
                axios
                .get("api/categories")
                .then((result) => {
                    this.postData.categories = result.data;
                })
                .catch((err) => {
                    this.categoryerrors = err;            
                });
            },

            savePost(){

                var today = new Date();
                var date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
                var time = today.getHours() + ":" + today.getMinutes() + ':' + today.getSeconds();
                var dateTime = date + ' ' + time;

                this.postData.post.postUserid = this.authuser.id;
                this.postData.post.postTime = dateTime;


                this.postData.creatingPost = true; 
                this.postData.message='Posting ...';
                var dataPost = this.postData.post;
                axios.post('/api/posts',dataPost).then(response=>{
                    if (response.data.status) {
                        this.postData.creatingPost = false; 
                        this.postData.message="Post Created";   
                        this.postData.post.postCategoryid='';
                        this.postData.post.postContent='';
                        this.postData.post.postTime=''; 
                        setTimeout(() => {
                            this.getposts();
                            //this.scrollTop();
                            this.postData.message="";
                        }, 2000);
                    }
                    else {
                        this.postData.creatingPost = false; 
                        this.postData.message=response.data.message; 
                    }
                })
                .catch(error=>{
                    this.postData.creatingPost = false; 
                    this.postData.message=error.response.data.message; 
                })
            }

        }
    }

    
</script>  

<style>
    .post-select{
        border: 1px solid #70707096;
        padding: .5em;
        color: #707070;
        border-radius: 5px;
        margin-bottom: 1em
    }

    .post-select:focus{
        outline: none;
    }

    .iconp-like{
        margin-left: .2em;
        padding-right: 0;
    }

    .post-time{
        font-size: .8rem;
        float: right;
        margin-top: -4.8em;
    }

    .user-email{
        font-size: 14.5px;
    }

    .iconp{
        margin-left: 0;
    }

</style>