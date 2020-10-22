import Vue from 'vue';
import App from './App.vue';
import router from './router';
import AsyncComputed from 'vue-async-computed';

Array.prototype.deleteByValue = function (value,attr = null) {
    let index = attr ? this.findIndex(item=>item[attr]===value) : this.findIndex(item=>item===value);
    this.splice(index,1);
};

String.prototype.toNumber = function () {
    if (this.split(',').length - 1 > 1) {
        return 0;
    }
    let n = this.replace(',', '.');
    n = Number(n);
    return isNaN(n) ? 0 : n;
};


Vue.use(AsyncComputed);


Vue.directive('can', {
    bind(el, binding, node) {
        const roles = binding.arg.split(',');
        setTimeout(() => {
            if (!roles.includes(window.Permission)) {
                el.style.display = 'none';
                el.childNodes.innerHTML = '';

                node.elm.parentElement.removeChild(node.elm);
                if (node.child) {
                    let e = document.getElementById(node.child.controlledBy);
                    if (e) {
                        e.parentElement.removeChild(e);
                    }
                }

            }
        }, 1);
    }
});


new Vue({
    render: (h) => h(App),
    router,

}).$mount('#app');
