require('./bootstrap');
import vuetify from "./plugins/vuetify";
import Alpine from 'alpinejs';
import routes from './router/routes.js'
import VueRouter from 'vue-router'

window.Alpine = Alpine;
window.Vue = require('vue').default;
Vue.component('vue_app', require('./App.vue').default);


Vue.use(VueRouter)
const router = new VueRouter({
    base: '/',
    mode: 'history',
    routes: routes, 
});

const app = new Vue({
    el: '#app',
    vuetify: vuetify,
    router: router,
});

Alpine.start();

export default app;