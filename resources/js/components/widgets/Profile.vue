<template>
    <div class="main profile-main">
        <div class="row main-row">
            <div class="profile own-profile col-md-2">
                <h6 class="profile-heading">My Profile</h6>
                <div class="main-profile">
                    <a data-toggle="modal" data-target="#editprofile"><img :src="'assets/images/icons-use/edit.png'" alt="" class="edit-icon"></a>
                    <img :src="'uploads/images/' + `${authuser.profile}`" alt="" class="profile-pic" v-if="!preview">
                    <img v-bind:src="imagePreview" class="profile-pic" v-else>

                    <p class="profile-name">{{authuser.name}}</p>
                    <p class="profile-email">{{authuser.email}}</p>
                    <p class="profile-tag ownp-tag">{{authuser.tag}}</p>

                    <div class="row stats pcreated">
                        <a href="#" class="pcreated-title"><span class="creatednbr">{{posts.length}}</span> Created post(s)</a>
                    </div>

                    <div class="row stats oppshared">
                        <a href="#" class="pcreated-title"><span class="creatednbr">{{opportunities.length}}</span> Shared opportunity(s)</a>
                    </div>
                </div>
            </div>

            <div class="main-content col-md-6">
                <h6 class="main-heading">Created Posts</h6>
                <ul class="list-group list-group-flush profile-group">
                    <li class="list-group-item" value="all" @click="getfilteredpost('all', -1, 'all')" :class="{'active' : activeIndex === -1}">Latest</li>
                    <li class="list-group-item" v-for="(category, index) in postData.categories" :key="category.id" :value="category.id" 
                    @click="getfilteredpost(category.id, index, category)" :class="{'active' : activeIndex === index}">
                        {{category.categoryName}}
                    </li>
                </ul>

                <div v-if="posts.length > 0">
                    <div class="display-content display-posts" v-for="(post, index) in posts" :key="post.id">
                        <div class="row display-content-row">
                            <div class="col-md-1">
                                <img :src="'uploads/images/' + `${authuser.profile}`" alt="" class="post-img">
                            </div>
                            <div class="col-md-1" style="max-width: 5.33333%;"></div>
                            <div class="col-md-10 profile-container" style="padding-left: 0;">
                                <a href="#" class="profile-name">{{authuser.name}}</a>
                                <p class="user-email">{{authuser.email}}</p>
                                <p class="profile-tag">{{authuser.tag}}</p>
                                <p class="post-time">{{post.postTime}}</p>

                                <div class="profile-post">
                                    <p>{{post.postContent}}</p>
                                </div>

                                <div class="row like-comment">
                                    <span class="iconp iconp-comment col-md-3"><img :src="'assets/images/icons-use/comment.png'" alt="" class="lcicon">
                                    <router-link :to="'/post/view/' + post.id">{{post.comments.length}} Thoughts</router-link></span>
                                </div>
                            </div>

                        </div> 
                    </div>
                </div>
                <div v-else>
                    <div v-if="loadposts" class="mt-3">
                        <center><p>Loading the posts <span class="spinner-border spinner-border-sm" role="status"></span></p></center>
                    </div>

                    <div v-else class="mt-3">
                        <center><p>No posts created here</p></center>
                    </div>
                </div>

                <h6 class="main-heading" style="margin-top: 2em;">Shared Opportunities</h6>
                <ul class="list-group list-group-flush profile-group">
                    <li class="list-group-item" value="all" @click="getfilteredopps('all', -1, 'all')" :class="{'active' : activeOppIndex === -1}">Latest</li>
                    <li class="list-group-item" v-for="(category, index) in postData.categories" :key="category.id" :value="category.id" 
                    @click="getfilteredopps(category.id, index, category)" :class="{'active' : activeOppIndex === index}">
                        {{category.categoryName}}
                    </li>
                </ul>

                <div v-if="opportunities.length > 0">
                    <div class="display-content displayOpportunities" v-for="(opportunity, index) in opportunities" :key="opportunity.id">
                        <div class="row display-content-row opp-profile">
                            <div class="col-md-2 comp-img">
                                <img :src="'uploads/images/' + `${opportunity.companyImage}`" alt="" class="post-img opp-img">
                            </div>
                            <div class="col-md-1" style="max-width: 4.33333%; display: none;"></div>
                            <div class="col-md-9" style="padding-left: .5em; padding-top: .15em;">
                                <p class="opp-title"><span>Job Title:</span> {{opportunity.jobTitle}}</p>
                                <p class="opp-company"><span>Company:</span> {{opportunity.companyName}}</p>
                                <p class="opp-deadline"><span>Deadline:</span> {{opportunity.dueDate}}</p>
                            </div>
                        </div>
                        <div class="opp-des">
                            <p class="des-content">{{opportunity.description}}</p>
                            <p class="des-link">For more information: <a href="#">{{opportunity.companyLink}}</a></p>
                        </div>

                        <div class="row sharedby"><a href="#" class="col-md-12">You Shared this</a></div>
                    </div>
                </div>

                <div v-else>
                    <div v-if="loadopportunities" class="mt-3">
                        <center><p>Loading opportunities<span class="spinner-border spinner-border-sm" role="status"></span></p></center>
                    </div>

                    <div v-else class="mt-3">
                        <center><p>No opportunities created here</p></center>
                    </div>
                </div>

            </div>

            <div class="col-md-2"></div>

            <div class="modal fade" id="editprofile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog mw-100 w-75" role="document">
                        <div class="modal-content">
                            <div class="modal-header shareopp-header">
                                <h5 class="">Edit profile</h5>
                            </div>
                            <div class="modal-body shareopp-body">
                                <form  class="shareopp-form editpro-form"  enctype="multipart/form-data" @submit.prevent="submit">
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="username">Username</label>
                                            <input type="text" class="form-control" v-model="authuser.name" name="name" placeholder="New username..">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="tagname">Tag name</label>
                                            <input type="text" class="form-control" v-model="authuser.tag" name="tag" placeholder="New tag name..">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="tagname">Email address</label>
                                            <input type="text" class="form-control" v-model="authuser.email" name="email" placeholder="New email..">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="companylogo">Profile picture</label><br>
                                            <input type="file" accept="image/*" name="avatar" class="form-control" v-on:change="onChange">
                                        </div>
                                        <div>
                                            <button type="button" class="btn shareopp-btn" v-if="updatingprofile">
                                                <span
                                                    class="spinner-border spinner-border-sm"
                                                    role="status"
                                                ></span>
                                            </button>
                                            <button type="submit" class="btn shareopp-btn" @click.prevent="submit" v-else>update</button>
                                            <span class="updatemessage">{{message}}</span>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
    
</template>

<script>
    export default{
        props:[
            'name', 'error', 'updatingprofile', 'message', 'authuser'
        ],

        data(){
            return {
                file:'',
                imagePreview: null,
                preview: false,
                activeIndex: -1,
                activeOppIndex: -1,
                categoryname: 'All',
                posts: [],
                loadposts: false,
                postserror: '',
                postData: {
                    categories: [],
                },
                opportunities: [],
                loadopportunities: false,
                oppserror: '',
            };
        },

        created(){
            this.getposts();
            this.getopportunities();
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
                    axios
                    .get('api/profile/posts')
                    .then((result) => {
                        this.posts = result.data.splice(0,2);
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
                }
                else{
                    axios
                    .get("api/posts/profile/category/"+$category+"")
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
                }
            },

            getfilteredopps($category, index, $cat){
                if($cat == 'all'){
                    this.categoryname = 'All';
                }
                else{
                    this.categoryname = $cat.categoryName;
                }
                this.activeOppIndex = index;
                this.loadopportunities = true;
                let id = $category;
                if($category == 'all'){
                    axios
                    .get('api/profile/opportunities')
                    .then((result) => {
                        this.opportunities = result.data.splice(0,2);
                        console.log(this.opportunities); 
                        this.loadopportunities = false;          
                    })
                    .catch((error) => {
                        this.oppserror = error.response.data.message;
                        for (const property in error.response.data.errors) {
                            this.oppsserror += " "+error.response.data.errors[property];
                        }       
                        this.loadopportunities = false;
                    });
                }
                else{
                    axios
                    .get("api/opportunities/profile/category/"+$category+"")
                    .then((result) => {
                        this.opportunities = result.data;
                        console.log(this.opportunities); 
                        this.loadopportunities = false;          
                    })
                    .catch((error) => {
                        this.oppserror = error.response.data.message;
                        for (const property in error.response.data.errors) {
                            this.oppserror += " "+error.response.data.errors[property];
                        }       
                        this.loadopportunities = false;
                    });
                }
            },
            
           
            getposts(){
                this.loadposts = true;
                axios
                .get("api/profile/posts")
                .then((result) => {
                    this.posts = result.data.splice(0, 2);
                    console.log(result.data);
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

            getopportunities(){
                this.loadopportunities = true;
                axios
                .get("api/profile/opportunities")
                .then((result) => {
                    this.opportunities = result.data;
                    console.log(this.opportunities);
                    this.loadopportunities = false;
                })
                .catch((error) => {
                    this.oppserrors = error.response.data.message;
                    for (const property in error.response.data.errors) {
                        this.oppserrors += " "+error.response.data.errors[property];
                    }       
                    this.loadopportunities = false;
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


            onChange(e){
                this.file = e.target.files[0];

                let reader  = new FileReader();

                reader.addEventListener("load", function () {
                    this.preview = true;
                    this.imagePreview = reader.result;
                }.bind(this), false);


                if( this.file){
                    reader.readAsDataURL( this.file );
                }
            },

            submit() {
                if (this.authuser.name=='' || this.authuser.tag == '' || this.authuser.email == '') {
                    alert("Some fields are empty!");
                    return false;
                }

                let formData = new FormData();
                formData.append('name', this.authuser.name);
                formData.append('tag', this.authuser.tag);
                formData.append('email', this.authuser.email);
                formData.append('avatar', this.file);
                
                this.$emit('submit', formData);
            },

            changeImg(){
                return true;
            }
        }
    }
</script>

<style>

    .profile-pic{
        border-radius: 55px;
        padding-left: 0;
        margin-right: 6em;
        margin-bottom: .25em;
    }

    .own-profile{
        padding: 0;
    }

    .pliked, .pcomment{
        display: block;
    }

    .lcimg{
        width: 2em;
        margin-right: 0;
        padding-right: 0;
    }

    .stat-element{
        padding-left: .2em;
    }

    .num-pcreated{
        padding-left: .5em;
    }

    .shareopp-btn{
        margin: 1.9em 0;
        margin-bottom: 1.2em; 
        /* margin-left: -2em; */
    }

    .updatemessage{
        color: #00a71c;
        padding-left: 1em;
        position: relative;
        top: .3em;
    }

    .picselected{
        padding-top: .5em;
    }

    .profile-group{
        flex-direction: row;
        justify-content: space-between;
    }

    .profile-group .list-group-item{
        border: 1px solid #70707096;
        padding: .3em 2em;
        color: #707070;
        border-radius: 3em;
        font-size: .7rem;
        font-weight: 500;
    }

    .profile-group .list-group-item:hover{
        background-color: #707070;
        color: #fff;
    }

    .profile-group li.active{
        background-color: #707070 !important;
        color: #fff !important;
    }

    .profile-group > .list-group-item:last-child{
        border-bottom: 1px solid #70707096;
    }

    .navbar-nav{
        margin-left: -3em;
    }

    .creatednbr{
        color: #C50C2B;
        font-weight: bold;
    }

    .pcreated-title{
        text-align: center;
    }


</style>