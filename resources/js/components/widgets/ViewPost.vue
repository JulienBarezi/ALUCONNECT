<template>

    <div class="main-content col-md-6">
        <div v-for="(post, index) in posts" :key="post.id">
            <h6 class="main-heading">{{post.user.name}}'s post</h6>

            <div class="display-content display-posts viewpost-content havecomment">
                <div class="row display-content-row">
                    <div class="col-md-1">
                        <img :src="url + '/uploads/images/' + `${post.user.profile}`" alt="" class="post-img">
                    </div>
                    <div class="col-md-1" style="max-width: 5.33333%;"></div>
                    <div class="col-md-10 profile-container" style="padding-left: 0;">
                        <a href="#" class="profile-name">{{post.user.name}}</a>
                        <p class="profile-tag">{{post.user.tag}}</p>
                        <p class="post-time">{{post.postTime}}</p>

                        <div class="profile-post">
                            <p>{{post.postContent}}</p>
                        </div>

                        <div class="row like-comment">
                            <div class="row like-comment">
                                <span class="iconp iconp-comment col-md-3"><img :src="'assets/images/icons-use/comment.png'" alt="" class="lcicon">
                                <a href="#">{{comments.length}} Thoughts</a></span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="create-post post-comment">
                <div class="row">
                    <div class="col-md-1">
                        <img :src="url + '/uploads/images/' + `${authuser.profile}`" alt="" class="post-img">
                    </div>
                    
                    <div class="col-md-10" style="margin-left: 1.5em;">
                        <textarea class="form-control txta border-0 pl-0 pt-0" id="comment" placeholder="What's your thought?"
                        v-model="commentData.comment.commentContent"></textarea>              
                        <div class="row">
                            <div class="col-md-2">
                                <button class="attach-btn" v-if="commentData.creatingComment">
                                    <span
                                        class="spinner-border spinner-border-sm"
                                        role="status"
                                    ></span>
                                </button>
                                <button class="attach-btn" @click="saveComment" v-else>post</button>
                                <span class="updatemessage">{{commentData.message}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div v-if="comments.length > 0"></div>
            <div class="display-content display-posts displaycomment" v-for="(comment, index) in comments" :key="comment.id">
                <div class="row display-content-row">
                    <div class="col-md-1">
                        <img :src="url + '/uploads/images/' + `${comment.user.profile}`" alt="" class="post-img">
                    </div>
                    <div class="col-md-1" style="max-width: 5.33333%;"></div>
                    <div class="col-md-10 profile-container" style="padding-left: 0;">
                        <a href="#" class="profile-name">{{comment.user.name}}</a>
                        <p class="profile-tag">{{comment.user.tag}}</p>
                        <p class="post-time">{{comment.commentedTime}}</p>

                        <div class="profile-post">
                            <p>{{comment.commentContent}}</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div> 
</template>

<script>
    export default {
        props: ['authuser', 'url'],

        data(){
            return{
                posts: [],
                loadpost: false,
                comments: [],
                loadcomments: false,
                commentData: {
                    creatingComment: false,
                    message: '',
                    comment:{
                        commentUserid: '',
                        commentPostid: '',
                        commentContent: '',
                        commentedTime: ''
                    }
                }
            }
        },

        created(){
            this.getPostbyId();
            this.getPostcomments();
            console.log(this.url);
        },

        methods:{
            getPostbyId(){
                let id = this.$route.params.id;
                this.loadpost = true;
                axios
                .get("api/posts/"+id+"")
                .then((result) => {
                    this.posts = result.data;
                    console.log(this.post);
                })
                .catch((err) => {
                    console.log(err);
                });
            },

            getPostcomments(){
                let id = this.$route.params.id;
                this.loadcomments = true;
                axios
                .get("api/comments/"+id+"")
                .then((result) => {
                    this.comments = result.data;
                    console.log(this.comments);
                })
                .catch((err) => {
                    console.log(err);
                });
            },

            saveComment(){
                let id = this.$route.params.id;

                var today = new Date();
                var date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
                var time = today.getHours() + ":" + today.getMinutes() + ':' + today.getSeconds();
                var dateTime = date + ' ' + time;
                
                this.commentData.comment.commentUserid = this.authuser.id;
                this.commentData.comment.commentPostid = id;
                this.commentData.comment.commentedTime = dateTime;


                this.commentData.creatingComment = true; 
                this.commentData.message='Posting ...';
                var dataPost = this.commentData.comment;

                axios.post("api/comments",dataPost).then(response=>{
                    if (response.data.status) {
                        this.commentData.creatingComment = false; 
                        this.commentData.message="Created successfully!";   
                        this.commentData.comment.commentContent='';
                        this.commentData.comment.commentedTime=''; 
                        setTimeout(() => {
                            this.getPostbyId();
                            //this.scrollTop();
                            this.commentData.message="";
                        }, 2000);
                    }
                    else {
                        this.commentData.creatingComment = false; 
                        this.commentData.message=response.data.message; 
                    }
                })
                .catch(error=>{
                    this.commentData.creatingComment = false; 
                    this.commentData.message=error.response.data.message; 
                })
            }
        }
    }
</script>

<style scoped>
    .post-time{
        margin-top: -3.2em;
    }
</style>