import Vue from "vue";
import Vuex from "vuex";
import modules from "./modules"; //This will import all modules at once.
import axios from "axios";
import VueDatePicker from "@mathieustan/vue-datepicker";
import "@mathieustan/vue-datepicker/dist/vue-datepicker.min.css";

Vue.use(Vuex);
Vue.use(VueDatePicker);

axios.defaults.baseURL = "http://localhost:8000";

export default new Vuex.Store({
    modules
});
