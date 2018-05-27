<template>
<li class="dropdown notifications-menu" id="markasread">
  <!-- Menu toggle button -->
  <a href="#" id="notifications" class="dropdown-toggle" role="button" data-toggle="dropdown">
    <i class="fa fa-bell-o"></i>
    <span class="label label-warning">{{unreadNotifications.length}}</span>
  </a>
  <ul class="dropdown-menu" role="menu">
    <li>
      <notification-item v-for="unread in unreadNotifications" :key="unread.user_id" :unread="unread"></notification-item>
      <a href="#" @click="markNotificationAsRead">Mark All As Read</a>
    </li>
    <li class="footer"><a href="#">View all</a></li>
  </ul>
</li>
</template>
<script>
  import NotificationItem from './NotificationItem.vue';
  export default{
    props:['unreads', 'userid'],
    components:{NotificationItem},
    data(){
      return {
        unreadNotifications: this.unreads
      }
    },
    methods: {
      markNotificationAsRead() {
        if (this.unreadNotifications.length) {
          axios.get('/markAsRead');
        }
      }
    },
    mounted() {
      console.log('Component mounted');
      console.log(Laravel.userId);
      Echo.private(`App.User.` + this.userid)
        .notification((notification) => {
        console.log(notification);
        let newUnreadNotifications = {
          data:{
            rent_info:notification.rent_info,
            user_id:notification.user_id,
            name:notification.name,
          }
        };

        this.unreadNotifications.push(newUnreadNotifications);
         console.log(notification);
        });
    }
  }
</script>
