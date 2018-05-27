
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('notification', require('./components/Notifications.vue'));

const app = new Vue({
    el: '#app',
});
//window._ = require('lodash');
import Echo from 'laravel-echo';

//window._ = require('lodash');

window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: '37ad8b23289f06684693',
    cluster: 'ap1',
    encrypted: true,
    namespace: false,
});

