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
                    <li class="list-group-item" value="all" @click="getfilteredpost_opp('all', -1, 'all')" :class="{'active' : activeIndex === -1}">All</li>
                    <li class="list-group-item" v-for="(category, index) in postData.categories" :key="category.id" :value="category.id" 
                    @click="getfilteredpost_opp(category.id, index, category)" :class="{'active' : activeIndex === index}">
                        {{category.categoryName}}
                    </li>
                </ul>
            </div>
            <div class="main-content col-md-6">
                <h6 class="main-heading">Home/{{categoryname}}-Latest</h6>
                <div v-if="posts.length > 0">
                    <div class="display-content display-posts home-posts" v-for="(post, index) in homefilterposts" :key="post.id">
                        <div class="catdiv"><router-link to="/posts" class="post-category">In Posts</router-link></div>
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
                                    <router-link :to="'/post/view/' + post.id">{{post.comments.length}} Thoughts</router-link></span>
                                </div>
                            </div>

                        </div> 
                    </div>
                </div>

                <div v-if="opportunities.length > 0">
                    <div class="display-content displayOpportunities home-opps" v-for="(opportunity, index) in homefilteropps" :key="opportunity.id">
                        <div class="catdiv"><router-link to="/opportunities" class="post-category">In Opportunities</router-link></div>
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

                        <div class="row sharedby"><img :src="'uploads/images/' + `${opportunity.user.profile}`" alt="" class="col-md-1">
                        <div class="row col-md-4"><a href="#" class="col-md-12">{{opportunity.user.name}} shared this</a></div></div>
                    </div>
                </div>

                <div v-else>
                    <div v-if="loadposts && loadopportunities" class="mt-5">
                        <center><p>Loading content <span class="spinner-border spinner-border-sm" role="status"></span></p></center>
                    </div>

                    <div v-if="posts.length == 0 && opportunities.length == 0"  class="mt-5">
                        <center><p>No content yet</p></center>
                    </div>
                </div>
            </div>

            <div class="col-md-2"></div>
        </div>
    </div>
        
</template>

<script>
    export default{

        data(){
            return{
                activeIndex: -1,
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
            }
        },

        computed: {
            homefilteropps(){
                return this.opportunities.slice(0,2);
            },

            homefilterposts(){
                return this.posts.slice(0,2);
            }
        },

        created(){
            this.getposts();
            this.getopportunities();
            this.getcategories();
        },
       
        methods: {
            getfilteredpost_opp($category, index, $cat){
                if($cat == 'all'){
                    this.categoryname = 'All';
                }

                else{
                    this.categoryname = $cat.categoryName;
                }

                this.activeIndex = index;
                this.loadposts = true;
                this.loadopportunities = true;
                let id = $category;
                if($category == 'all'){
                    var link = "api/posts/";
                    var link2 = "api/opportunities/";
                }
                else{
                    var link = "api/posts/category/"+$category+"";
                    var link2 = "api/opportunities/category/"+$category+"";
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

                axios
                .get(link2)
                .then((result) => {
                    this.opportunities = result.data;
                    console.log(this.opportunities); 
                    this.loadopportunities = false;          
                })
                .catch((error) => {
                    this.oppserrors = error.response.data.message;
                    for (const property in error.response.data.errors) {
                        this.postserrors += " "+error.response.data.errors[property];
                    }       
                    this.loadopportunities = false;
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

            getopportunities(){
                this.loadopportunities = true;
                axios
                .get("api/opportunities")
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
        },
    }
</script>

<style>
    .home-opps, .home-posts{
        margin-top: .5em;
        margin-bottom: 2em;
    }
</style>