import Vue from 'vue';
import App from './App.vue';
import router from './router';

Array.prototype.findByValue = function (value) {
    //
};

String.prototype.toNumber = function () {
    if (this.split(',').length - 1 > 1) {
        return 0;
    }
    let n = this.replace(',', '.');
    n = Number(n);
    return isNaN(n) ? 0 : n;
};


new Vue({
    render: (h) => h(App),
    router,

}).$mount('#app');
