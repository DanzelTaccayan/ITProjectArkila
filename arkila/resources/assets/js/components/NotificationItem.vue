<template>
    <a v-bind:href="notificationUrl">
      <p style="margin:0 0 0;">{{title}}</p>
      <span class="text-orange fa fa-book"></span>
      <small>{{destination}} on {{date}} at {{time}}</small>
    </a>
</template>
<script>
import moment from 'moment';
  export default {
    props:['unread'],
    data(){
      return{
        title:"",
        notificationUrl:"",
        destination:"",
        date:"",
        time:"",
      }
    },
    mounted(){
      if(this.unread.data.notif_type == 'Reservation'){
        if(this.unread.data.info.status == 'UNPAID'){
          this.title=unread.data.notif_type + " Request by " + unread.data.name;
          this.destination=this.unread.data.info.destination_name;
          this.date=moment(this.unread.data.reservation_date.reservation_date).format('MMM D YYYY');
          this.time=moment(this.unread.data.reservation_date.departure_time, 'HH:mm').format('hh:mm a');
          this.notificationUrl="/home/reservations/customer/"+this.unread.data.reservation_date.id;
        }else if(this.unread.data.info.status == 'CANCELLED'){
          this.title= unread.data.notif_type + " Request by " + unread.data.name + " -- Cancelled";
          this.destination=this.unread.data.info.destination_name;
          this.date=moment(this.unread.data.reservation_date.reservation_date).format('MMM D YYYY');
          this.time=moment(this.unread.data.reservation_date.departure_time, 'HH:mm').format('hh:mm a');
          this.notificationUrl="/home/reservations/customer/"+this.unread.data.reservation_date.id;
        }
      }else if(this.unread.data.notif.type == 'Van Rental'){
        if(this.unread.data.info.status == 'Pending'){
          this.title= unread.data.notif_type + " Request by " + unread.data.name + " -- Cancelled";
          this.destination=this.unread.data.info.destination;
          this.date=moment(this.unread.data.info.departure_date).format('MM D YYYY');
          this.time=moment(this.unread.data.info.departure_time, 'HH:mm').format('hh:mm a');
          this.notificationUrl="/home/rental/"+this.unread.data.info.id;
        }else if(this.unread.data.inof.status == 'Cancelled'){
          this.title= unread.data.notif_type + " Request by " + unread.data.name;
          this.destination=this.unread.data.info.destination;
          this.date=moment(this.unread.data.info.departure_date).format('MM D YYYY');
          this.time=moment(this.unread.data.info.departure_time, 'HH:mm').format('hh:mm a');
          this.notificationUrl="/home/rental/"+this.unread.data.info.id;
        }
      }
      console.log(this.unread.data.reservation_date.reservation_date);
    }
  }
</script>
