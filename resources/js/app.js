/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import Vue from 'vue'
import Vuetify from "../plugins/vuetify";
import router from "./router";
require('./bootstrap');

window.Vue = require('vue');
import '@mdi/font/css/materialdesignicons.css'


// import VuePersianDatetimePicker from 'vue-persian-datetime-picker';
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

//General Components
Vue.component('loading-component', require('./components/info/loading.vue').default);
Vue.component('processing-component', require('./components/info/waitForResponse.vue').default);
Vue.component('tarh1-header', require('./components/general/tarh1Header').default);
Vue.component('reset-password', require('./components/general/ResetPassword').default);

//Safir Routes
Vue.component('app-container', require('./components/safir/appContainer.vue').default);
Vue.component('register-component', require('./components/safir/RegisterComponent.vue').default);
Vue.component('login-component', require('./components/safir/LoginComponent.vue').default);
Vue.component('header-component', require('./components/safir/HeaderComponent.vue').default);
Vue.component('navbar-component', require('./components/elements/NavbarComponent.vue').default);
Vue.component('not-registered', require('./components/errors/notRegistered.vue').default);
//Admin Routes
Vue.component('admin-app-container', require('./components/admin/general/adminAppContainer.vue').default);
Vue.component('admin-header-component', require('./components/admin/general/AdminHeaderComponent.vue').default);
Vue.component('admin-dashboard', require('./components/admin/dashboard/dashboardComponent.vue').default);
Vue.component('admin-login-component', require('./components/admin/auth/login').default);
// Shop Routes
Vue.component('shop-app-container', require('./components/shop/shopAppContainer.vue').default);
Vue.component('shop-register-component', require('./components/shop/shopRegisterComponent.vue').default);
Vue.component('shop-header-component', require('./components/shop/shopHeaderComponent.vue').default);
Vue.component('shop-inv-alert', require('./components/shop/Alerts/invAlert.vue').default);
Vue.component('shop-saf-ord-alert', require('./components/shop/Alerts/safirOrderAlert.vue').default);
Vue.component('shop-saf-ord-footer', require('./components/shop/Alerts/safirOrderFooter.vue').default);
Vue.component('shop-sidebar-component', require('./components/shop/assets/sidebarNormal').default);
Vue.component('shop-login-component', require('./components/shop/shopLogin').default);
//Distributor Routes
Vue.component('distributor-app-container', require('./components/distributor/general/distributorAppContainer.vue').default);
Vue.component('distributor-header-component', require('./components/distributor/general/distributorHeaderComponent.vue').default);
Vue.component('distributor-dashboard', require('./components/distributor/dashboard/dashboardComponent.vue').default);
Vue.component('distributor-register', require('./components/distributor/Register/distributorRegisterComponent').default);
// Vue.component('date-picker', VuePersianDatetimePicker);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    vuetify: Vuetify,
    router,
});
