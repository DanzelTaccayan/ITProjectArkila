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
        <div class="col-md-6">
          <a href="#" role="button" @click="markNotificationAsRead">Mark All as Read</a>
        </div>
      </div>
    </li>
      <li>
          <notification-item v-for="unread in unreadNotifications" :key="unread.user_id" :unread="unread"></notification-item>
      </li>     
    <li class="footer">
      <a href="#">View all</a>
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
          data:{
            notif_type:notification.notif_type,
            reservation_date:notification.reservation_date,
            info:notification.info,
            id:notification.user_id,
            name:notification.name,
          }
        };
        //console.log(newUnreadNotifications.data);
        this.unreadNotifications.push(newUnreadNotifications);
        });
    }
  }
</script>
