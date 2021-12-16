require("./bootstrap");

import Vue from "vue";
import router from "./routes";
import axios from "axios";
import store from "./store";
import App from "./App.vue";

Vue.use("axios", axios);

const moment = require("moment");
require("moment/locale/es");
Vue.use(require("vue-moment"), {
    moment
});
const app = new Vue(
    Vue.util.extend(
        {
            router,
            store
        },
        App
    )
).$mount("#app");
