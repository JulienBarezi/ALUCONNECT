const state = {
    users: [],
    user: localStorage.getItem("user"),
    mobOpen: false
};
const getters = {};
const actions = {
    register({ commit }, data) {
        return axios.post("api/register", data).then(response => {
            console.log("responseee", response);
        });
    },
    login({ commit }, data) {
        return axios.post("api/login", data).then(response => {
            console.log("responseee", response);
            commit("setUserData", response.data);
        });
    },
    logout({ commit }, user) {
        return axios.post("api/logout", user.user).then(response => {
            console.log(response);
            commit("logout");
        });
    },

    users({ commit }, users) {
        return axios
            .get("api/users")
            .then(response => {
                commit("users", response.data);
            })
            .catch(error => {
                console.log(error);
            });
    },
    openMobile({ commit }) {
        commit("openMobile");
    }
};
const mutations = {
    setUserData(state, userData) {
        state.user = userData;
        localStorage.setItem("user", JSON.stringify(userData));
        axios.defaults.headers.common.Authorization = `Bearer ${userData.token}`;
    },
    logout(state, data) {
        localStorage.removeItem("user");
        state.user = [];
    },
    users(state, data) {
        state.users = data;
    },
    openMobile(state) {
        state.mobOpen = !state.mobOpen;
    }
};
export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
};
