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
        <div class="col-xs-6">Notifications</div>
        <div class="col-xs-6">
          <div v-show="unreadNotifications.length > 0">
            <a href="#" role="button" class="btn btn-primary btn-flat btn-xs" @click="markNotificationAsRead">Mark All as Read</a>
          </div>
        </div>
      </div>
    </li>
      <li style="height: 300px;" class="scrollbar scrollbar-info thin">
          <div v-if="unreadNotifications.length == 0">
            <div style="margin-top:10%">
              <h4 class="text-center text-gray">You have no notifications</h4>
            </div>
          </div>
          <div v-else>
            <div class="list-group">
              <notification-item v-for="unread in unreadNotifications" :key="unread.user_id" :unread="unread">
              </notification-item>
            </div>
          </div>

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
      Echo.private(`App.User.` + this.userid)
        .notification((notification) => {
        let newUnreadNotifications = {
          id:notification.id,
          data:{
            notif_type:notification.notif_type,
            reservation_date:notification.reservation_date == null ? null : notification.reservation_date,
            info:notification.info,
            id:notification.user_id,
            name:notification.name,
            date:notification.date,
          }
        };
        this.unreadNotifications.push(newUnreadNotifications);
        });
    }
  }
</script>
