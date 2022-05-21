require('./bootstrap');
import VueRouter from 'vue-router'
import { routes } from './routes'
import App from './layouts/App';
import { BootstrapVue } from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import VAnimateCss from 'v-animate-css';

import { library } from '@fortawesome/fontawesome-svg-core'

import { faHatWizard, faPowerOff, faCirclePlus } from '@fortawesome/free-solid-svg-icons'

import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

window.Vue = require('vue').default;
Vue.use(BootstrapVue);
Vue.use(VueRouter);
Vue.use(VAnimateCss);
library.add(faHatWizard);
library.add(faPowerOff);
library.add(faCirclePlus);
Vue.component('font-awesome-icon', FontAwesomeIcon)
const router = new VueRouter({
    mode: 'history',
    routes
});

const app = new Vue({
    el: '#application',
    components: { App },
    router
});