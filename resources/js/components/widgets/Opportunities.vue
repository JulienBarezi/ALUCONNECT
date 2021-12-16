<template>
    <div class="main">
        <div class="row main-row">
            <div class="sidebar  col-md-2">
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
                    <li class="list-group-item" value="all" @click="getfilteredopp('all', -1, 'all')" :class="{'active' : activeIndex === -1}">All</li>
                    <li class="list-group-item" v-for="(category, index) in opportunityData.categories" :key="category.id" :value="category.id" 
                    @click="getfilteredopp(category.id, index, category)" :class="{'active' : activeIndex === index}">
                        {{category.categoryName}}
                    </li>
                </ul>
            </div>

            <div class="main-content col-md-6">
                <h6 class="main-heading">Opportunities/{{categoryname}}</h6>
                <div class="create-post create-opport">
                    <div class="row create-post-row">
                        <div class="col-md-1">
                            <img :src="'uploads/images/' + `${authuser.profile}`" alt="" class="post-img">
                        </div>
                        
                        <div class="col-md-10" style="max-width: 87.33333%; padding-left: 0;">
                            <button class="btn shareopp-btn opp-share" data-toggle="modal" data-target="#exampleModal2">Click to share</button>              
                        </div>
                    </div>
                </div>
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

                        <div class="row sharedby"><img :src="'uploads/images/' + `${opportunity.user.profile}`" alt="" class="col-md-1">
                        <div class="row col-md-4"><a href="#" class="col-md-12">{{opportunity.user.name}} shared this</a></div></div>
                    </div>
                </div>

                <div v-else>
                    <div v-if="loadopportunities" class="mt-5">
                        <center><p>Loading opportunities<span class="spinner-border spinner-border-sm" role="status"></span></p></center>
                    </div>

                    <div v-else class="mt-5">
                        <center><p>No opportunities created here</p></center>
                    </div>
                </div>

            </div>
            <div class="col-md-2"></div>

            <!-- Modal for adding an opportunity -->

            <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog mw-100 w-75" role="document">
                <div class="modal-content">
                <div class="modal-header shareopp-header">
                    <h5 class="">Share an opportunity</h5>
                </div>
                <div class="modal-body shareopp-body">
                    <form action="#" class="shareopp-form" >
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="category">Category name</label>
                                <select id="category" class="form-control" v-model="opportunityData.opportunity.oppCategoryid">
                                    <option value="">Select category</option>
                                    <option v-for="(category, index) in opportunityData.categories" :key="category.id" :value="category.id">
                                        {{category.categoryName}}</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="companyname">Company name</label>
                                <input type="text" class="form-control" v-model="opportunityData.opportunity.companyName" placeholder="Ex: Google">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="jobtitle">Job Title</label>
                                <input type="text" class="form-control" v-model="opportunityData.opportunity.jobTitle" placeholder="Ex: Senior Designer">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="duedate">Due Date</label>
                                <input type="date" class="form-control" v-model="opportunityData.opportunity.dueDate">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="companylogo">Company logo</label><br>
                                <input type="file" accept="image/*" name="companyImg" class="form-control" v-on:change="onChange">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="companylink">Company link</label>
                                <input type="text" class="form-control" v-model="opportunityData.opportunity.companyLink" placeholder="Ex: Paste the link here">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="Description">Role Description</label>
                            <textarea class="form-control" rows="3" placeholder="Paste description here" v-model="opportunityData.opportunity.description"></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <button class="attach-btn" v-if="opportunityData.creatingOpportunity">
                                    <span
                                        class="spinner-border spinner-border-sm"
                                        role="status"
                                    ></span>
                                </button>
                                <button class="attach-btn" @click="saveOpportunity" v-else>Share opportunity</button>
                                <span class="updatemessage">{{opportunityData.message}}</span>
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
        props: ['authuser'],
        data(){
            return{
                activeIndex: -1,
                categoryname: 'All',
                opportunities: [],
                loadopportunities: false,
                oppserror: '',
                file: '',
                timeDiff: '',
                opportunityData: {
                    creatingOpportunity: false,
                    message: '',
                    categories: [],
                    opportunity:{
                        oppUserid: '',
                        oppCategoryid: '',
                        companyName: '',
                        jobTitle: '',
                        dueDate: '',
                        companyLink: '',
                        description: '',
                        postTime: ''
                    }
                }
            }
        },

        created(){
            this.getopportunities();
            this.getcategories();
        },

        methods: {

            getfilteredopp($category, index, $cat){
                if($cat == 'all'){
                    this.categoryname = 'All';
                }

                else{
                    this.categoryname = $cat.categoryName;
                }

                this.activeIndex = index;
                this.loadopportunities = true;
                let id = $category;
                if($category == 'all'){
                    var link = "api/opportunities/";
                }
                else{
                    var link = "api/opportunities/category/"+$category+"";
                }

                axios
                .get(link)
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
                    this.opportunityData.categories = result.data;
                })
                .catch((err) => {
                    this.categoryerrors = err;            
                });
            },

            onChange(e){
                this.file = e.target.files[0];
            },

            saveOpportunity(){

                this.opportunityData.creatingOpportunity = true; 
                this.opportunityData.message='Sharing ...';

                var today = new Date();
                var date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
                var time = today.getHours() + ":" + today.getMinutes() + ':' + today.getSeconds();
                var dateTime = date + ' ' + time;

                this.opportunityData.opportunity.oppUserid = this.authuser.id;
                this.opportunityData.opportunity.postTime = dateTime;

                let formData = new FormData();
                formData.append('oppCategoryid', this.opportunityData.opportunity.oppCategoryid);
                formData.append('oppUserid', this.opportunityData.opportunity.oppUserid);
                formData.append('companyName', this.opportunityData.opportunity.companyName);
                formData.append('jobTitle', this.opportunityData.opportunity.jobTitle);
                formData.append('dueDate', this.opportunityData.opportunity.dueDate);
                formData.append('companyImg', this.file);
                formData.append('companyLink', this.opportunityData.opportunity.companyLink);
                formData.append('description', this.opportunityData.opportunity.description);
                formData.append('postTime', this.opportunityData.opportunity.postTime);

                axios.post('/api/opportunities',formData).then(response=>{
                    if (response.data.status) {
                        this.opportunityData.creatingOpportunity = false; 
                        this.opportunityData.message="Opportunity shared";   
                        this.opportunityData.opportunity.oppCategoryid='';
                        this.opportunityData.opportunity.companyName='';
                        this.opportunityData.opportunity.jobTitle='';
                        this.opportunityData.opportunity.dueDate='';
                        this.opportunityData.opportunity.companyLink='';
                        this.opportunityData.opportunity.description='';
                        this.opportunityData.opportunity.postTime=''; 
                        setTimeout(() => {
                            this.getopportunities();
                            this.opportunityData.message="";
                        }, 2000);
                    }
                    else {
                        this.opportunityData.creatingOpportunity = false; 
                        this.opportunityData.message=response.data.message; 
                    }
                })
                .catch(error=>{
                    this.opportunityData.creatingOpportunity = false; 
                    this.opportunityData.message=error.response.data.message; 
                })
            }


        },
    }
</script>

<style>
    .sharedby a{
        padding-right: .25em;
    }

    .sharedby img{
        padding-left: 0;
        padding-right: 0;
        max-width: 20px;
    }

    .comp-img{
        padding-top: .4em;
    }

    .create-opport{
        padding-top: 1em;
    }

    .opp-share{
        margin-top: 1em;
        margin-bottom: 1em;
        background-color: #707070;
        color: white;
        border: 1px solid #70707096;
    }

    .opp-share:hover{
        border: 1px solid #70707096;
        background-color: #fff;
        color: #707070;
    }

    .opp-img{
        margin-left: 1em;
    }

    .sharedby img{
        border-radius: 100% !important;
    }

</style>