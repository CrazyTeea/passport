import Vue from "vue";
import VueRouter from "vue-router";

Vue.use(VueRouter);

const routes = [
    {
        path:'/main',
        component: require('./components/pages/passport/userIndex.vue').default
    },
    {
        path:'/org-info',
        component: require('./components/pages/passport/orgInfo.vue').default
    }

];

export default new VueRouter({
    mode: "history",
    routes
});
