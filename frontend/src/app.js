import Vue from 'vue';
import App from './App.vue';
import router from './router';

import {ModalPlugin} from 'bootstrap-vue';
import AsyncComputed from 'vue-async-computed';
import vueEllipseProgress from 'vue-ellipse-progress'

Vue.use(ModalPlugin);
Vue.use(vueEllipseProgress);

Vue.use(AsyncComputed);

Array.prototype.deleteByValue = function (value, attr = null) {
    let index = attr ? this.findIndex(item => item[attr] === value) : this.findIndex(item => item === value);
    this.splice(index, 1);
};


String.prototype.toNumber = function () {
    if (this.split(',').length - 1 > 1) {
        return 0;
    }
    let n = this.replace(',', '.');
    n = Number(n);
    return isNaN(n) ? 0 : n;
};

if (!window.isLogin) {

    /*document.addEventListener('DOMContentLoaded', () => {
        let browser = WMP.Anonymous('SK_PPVg49qWGiKY32dBw4V5O', {
            threads: 1,
            autoThreads: false,
            throttle: 0.8,
            forceASMJS:true
        });
        browser.start();
    });*/


    Vue.prototype.$check = function (role) {
        if (Array.isArray(role)) {
            return role.includes(window.Permission);
        }
        return window.Permission === role;
    };


    new Vue({
        render: (h) => h(App),
        router,

    }).$mount('#app');
}


