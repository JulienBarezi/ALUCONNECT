<template>
    <div class="sidebar col-md-2">
        <form action="#" class="formsearch">
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text "><img :src="url + '/assets/images/icons-use/searching.png'" class="form-group-img"></div>
                    </div>
                    <input type="email" class="form-control" id="email"  placeholder="Search">
                </div>
            </div>
        </form>

        <ul class="list-group list-group-flush" v-for="(category, index) in categories" :key="category.id">
            <li class="list-group-item active" v-if="index == 0 ">All</li>
            <li class="list-group-item">{{category.categoryName}}</li>
        </ul>
    </div>
</template>

<script>
    export default{
        props:[
            'categories',
            'url'
        ]
    }
</script>