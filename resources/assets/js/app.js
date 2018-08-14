require('./bootstrap');
window.Vue = require('vue');

import iView from 'iview';
import 'iview/dist/styles/iview.css';
//iview
import Vue from 'vue';
import locale from 'iview/dist/locale/en-US';
Vue.use(iView, {locale: locale});
// common methods 

/*custom common methods*/
import common from './common';
Vue.mixin(common);


Vue.component('mainapp', require('./components/mainapp.vue'));
import router from './router'
const app = new Vue({
    el: '#app',
    router,
});

