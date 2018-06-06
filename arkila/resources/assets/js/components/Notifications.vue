<template>
<li class="dropdown notifications-menu" id="markasread">
  <!-- Menu toggle button -->
  <a href="#" id="notifications" class="dropdown-toggle" role="button" data-toggle="dropdown">
    <i class="fa fa-bell-o"></i>
    <span class="label label-warning">{{unreadNotifications.length}}</span>
  </a>
  <ul class="dropdown-menu" role="menu">
    <li class="header">
      <div class="row">
        <div class="col-md-6">Notifications</div>
        <div v-show="unreadNotifications.length > 0" class="col-md-6">
          <a href="#" role="button" @click="markNotificationAsRead">Mark All as Read</a>
        </div>
      </div>
    </li>
      <li>
          <div v-if="unreadNotifications.length == 0"><p>You have no notifications</p></div>
          <div><notification-item v-for="unread in unreadNotifications" :key="unread.user_id" :unread="unread"></notification-item></div>

      </li>
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
        if (this.unreadNotifications.length != 0) {
          axios.post('/markAsRead');
        }
      }
    },
    mounted() {
      console.log('Component mounted');
      Echo.private(`App.User.` + this.userid)
        .notification((notification) => {
        console.log(notification.id);
        let newUnreadNotifications = {
          id:notification.id,
          data:{
            notif_type:notification.notif_type,
            reservation_date:notification.reservation_date == null ? null : notification.reservation_date,
            info:notification.info,
            id:notification.user_id,
            name:notification.name,
          }
        };
        this.unreadNotifications.push(newUnreadNotifications);
        console.log(newUnreadNotifications);
        });
    }
  }
</script>
