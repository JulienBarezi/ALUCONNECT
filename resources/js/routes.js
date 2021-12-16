import Vue from "vue";
import VueRouter from "vue-router";
import Login from "./components/containers/Login";
import Register from "./components/containers/Register";
import dashboard from "./components/containers/dashboard";
import Posts from "./components/containers/Posts";
import Viewpost from "./components/containers/Viewpost";
import Profile from "./components/containers/Profile";
import Opportunities from "./components/containers/Opportunities"

Vue.use(VueRouter);

const routes = [

    {
        name: "dashboard",
        path: "/",
        component: dashboard,
        meta:{
            auth: true
        }
    },

    {
        name: "Login",
        path: "/login",
        component: Login,
    },
    {
        name: "Register",
        path: "/register",
        component: Register,
    },

    {
        name: "Posts",
        path: "/posts",
        component: Posts,
        meta:{
            auth: true
        }
    },

    {
        name: "Viewpost",
        path: "/post/view/:id",
        component: Viewpost,
        meta:{
            auth: true
        }
    },

    {
        name: "Opportunities",
        path: "/opportunities",
        component: Opportunities,
        meta:{
            auth: true
        }
    },

    {
        name: "Profile",
        path: "/profile",
        component: Profile,
        meta:{
            auth: true
        }
    }
];

const router = new VueRouter({
    mode: "history",
    base: process.env.BASE_URL,
    routes
});

router.beforeEach((to, from, next) => {
    const loggedIn = localStorage.getItem("user");
    if (to.matched.some(record => record.meta.auth) && !loggedIn) {
        window.location.href = "/login";
        return;
    }
    next();
});
export default router;

