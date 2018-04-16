
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

// window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component('example-component', require('./components/ExampleComponent.vue'));
//
// const app = new Vue({
//     el: '#app'
// });

import Echo from 'laravel-echo'

//window._ = require('lodash');

window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: '37ad8b23289f06684693',
    cluster: 'ap1',
    encrypted: false,
});
var notifications = [];
const NOTIFICATION_TYPES = {
  rental: 'App\\Notifications\\CustomerRent'
};

$(document).ready(function(){
  if(Laravel.userId){
    $.get('/driverNotifications', function(data){
      console.log(data);
      window.Echo.private(`App.User.${Laravel.userId}`)
        .notification((notification) => {

          addNotifications(data, "#notifications");
        });
    });
  }
});

function addNotifications(newNotifications, target) {
  notifications = _.concat(notifications, newNotifications);
  // show only last 5 notifications
  notifications.slice(0, 5);
  showNotifications(notifications, target);
}

function showNotifications(notifications, target) {
  if(notifications.length) {
      var htmlElements = notifications.map(function (notification) {
          return makeNotification(notification);
      });
      $(target + 'Menu').html(htmlElements.join(''));
      $(target).addClass('has-notifications')
  } else {
      $(target + 'Menu').html('<li class="dropdown-header">No notifications</li>');
      $(target).removeClass('has-notifications');
  }
}

function makeNotification(notification) {
  var to = routeNotification(notification);
  var notificationText = makeNotificationText(notification);
  return '<li><a href="' + to + '">' + notificationText + '</a></li>';
}

function routeNotification(notification) {
  var to = '?read=' + notification.id;
  if(notification.type === NOTIFICATION_TYPES.rental) {
      to = 'users' + to;
  }
  return '/' + to;
}

function makeNotificationText(notification) {
  var text = '';
  if(notification.type === NOTIFICATION_TYPES.rental) {
      const name = notification.data.name;
      text += '<strong>' + name + '</strong> has requeted a rental';
  }
  return text;
}
