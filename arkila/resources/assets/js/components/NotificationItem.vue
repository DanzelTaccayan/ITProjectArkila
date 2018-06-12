<template>
<a v-bind:href="notificationUrl" class="list-group-item">
  <div class="row">
    <div class="col-md-10">
        <p class="text-limit-1" style="margin:0 0 0;">{{title}}</p>
        <span class="text-orange fa fa-book"></span>
        <small>{{details}}</small>
    </div>
    <div class="col-md-2">
      <button @click="markSpecificAsRead" type="button" class="btn btn-xs" name="button"><i class="fa fa-circle-o"></i></button>
    </div>
  </div>
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
        details:"",
      }
    },
    mounted(){
      //Done
      if(this.unread.data.notif_type == 'Van Rental'){
        if(this.unread.data.info.status == 'Pending'){
          this.title= this.unread.data.notif_type + " Request by " + this.unread.data.name;
          this.destination=this.unread.data.info.destination;
          this.date=moment(this.unread.data.info.departure_date).format('MM D YYYY');
          this.time=moment(this.unread.data.info.departure_time, 'HH:mm').format('hh:mm a');
          this.details=this.destination + " on " + this.date + " at " + this.time;
          this.notificationUrl="/home/rental/"+this.unread.data.info.rent_id;
        }else if(this.unread.data.info.status == 'Cancelled'){
          this.title= this.unread.data.notif_type + " Request by " + this.unread.data.name + " -- Cancelled";
          this.destination=this.unread.data.info.destination;
          this.date=moment(this.unread.data.info.departure_date).format('MM D YYYY');
          this.time=moment(this.unread.data.info.departure_time, 'HH:mm').format('hh:mm a');
          this.details=this.destination + " on " + this.date + " at " + this.time;
          this.notificationUrl="/home/rental/"+this.unread.data.info.rent_id;
        }
      //Done
      }else if(this.unread.data.notif_type == 'VanRentalDriver'){
        var admin = this.unread.data.name.split(' ');
        if(this.unread.data.info.status == 'Unpaid'){
          this.title= admin[0].charAt(0).toUpperCase()+admin[0].slice(1)+" has appointed you a Van Rental for "+this.unread.data.info.customer_name;
          this.destination=this.unread.data.info.destination;
          this.date=moment(this.unread.data.info.departure_date).format('MM D YYYY');
          this.time=moment(this.unread.data.info.departure_time, 'HH:mm').format('hh:mm a');
          this.details=this.destination + " on " + this.date + " at " + this.time;
          this.notificationUrl="/home/view-rentals";
        }else if(this.unread.data.info.status == 'Cancelled'){
          this.title= this.unread.data.notif_type + " Request by " + this.unread.data.info.customer_name + " -- Cancelled";
          this.destination=this.unread.data.info.destination;
          this.date=moment(this.unread.data.info.departure_date).format('MM D YYYY');
          this.time=moment(this.unread.data.info.departure_time, 'HH:mm').format('hh:mm a');
          this.details=this.destination + " on " + this.date + " at " + this.time;
          this.notificationUrl="/home/view-rentals";
        }
      //Done
      }else if(this.unread.data.notif_type == 'Reservation'){
        if(this.unread.data.info.status == 'UNPAID'){
          this.title=this.unread.data.notif_type + " Request by " + this.unread.data.name;
          this.destination=this.unread.data.info.destination_name;
          this.date=moment(this.unread.data.reservation_date.reservation_date).format('MMM D YYYY');
          this.time=moment(this.unread.data.reservation_date.departure_time, 'HH:mm').format('hh:mm a');
          this.details=this.destination + " on " + this.date + " at " + this.time;
          this.notificationUrl="/home/reservations/"+this.unread.data.reservation_date.id;
        }else if(this.unread.data.info.status == 'CANCELLED'){
          this.title= this.unread.data.notif_type + " Request by " + this.unread.data.name + " -- Cancelled";
          this.destination=this.unread.data.info.destination_name;
          this.date=moment(this.unread.data.reservation_date.reservation_date).format('MMM D YYYY');
          this.time=moment(this.unread.data.reservation_date.departure_time, 'HH:mm').format('hh:mm a');
          this.details=this.destination + " on " + this.date + " at " + this.time;
          this.notificationUrl="/home/reservations/"+this.unread.data.reservation_date.id;
        }
      //DONE
      }else if(this.unread.data.notif_type == 'Trip'){
        if(this.unread.data.info.report_status == 'Pending' && this.unread.data.info.reported_by == 'Driver'){
          this.title = this.unread.data.name + ' has made a trip from '+ this.unread.data.info.origin +' to ' + this.unread.data.info.destination;
          this.details = "On " + moment(this.unread.data.info.date_departed).format('MM D YYYY') + " " +moment(this.unread.data.info.time_departed, 'HH:mm').format('hh:mm a');
          this.notificationUrl="/home/driver-report/"+this.unread.data.info.trip_id;
        }else if(this.unread.data.info.report_status == 'Accepted' && this.unread.data.info.reported_by == 'Admin'){
          this.title = 'The Admin has departed you from '+ this.unread.data.info.origin +' to ' + this.unread.data.info.destination;
          this.details = "On " + moment(this.unread.data.info.date_departed).format('MM D YYYY') + " " +moment(this.unread.data.info.time_departed, 'HH:mm').format('hh:mm a');
          this.notificationUrl="/home/view-trips/"+this.unread.data.info.trip_id;
        }else if(this.unread.data.info.report_status == 'Accepted' && this.unread.data.info.reported_by == 'Driver'){
          this.title = 'Your trip from '+ this.unread.data.info.origin +' to ' + this.unread.data.info.destination + ' has been accepted by the Admin';
          this.details = "On " + moment(this.unread.data.info.date_departed).format('MM D YYYY') + " " +moment(this.unread.data.info.time_departed, 'HH:mm').format('hh:mm a');
          this.notificationUrl="/home/view-trips/"+this.unread.data.info.trip_id;
        }else if(this.unread.data.info.report_status == 'Declined' && this.unread.data.info.reported_by == 'Driver'){
          this.title = 'Your trip from '+ this.unread.data.info.origin +' to ' + this.unread.data.info.destination + ' has been declined by the Admin';
          this.details = "On " + moment(this.unread.data.info.date_departed).format('MM D YYYY') + " " +moment(this.unread.data.info.time_departed, 'HH:mm').format('hh:mm a');
          this.notificationUrl="/home/view-trips/"+this.unread.data.info.trip_id;
        }
      }else if(this.unread.data.notif_type == 'Walk-in Rental'){
        if(this.unread.data.info.status == 'Paid'){
          this.title= "The Admin has assigned you a Van Rental for " + this.unread.data.info.customer_name;
          this.destination=this.unread.data.info.destination;
          this.date=moment(this.unread.data.info.departure_date).format('MM D YYYY');
          this.time=moment(this.unread.data.info.departure_time, 'HH:mm').format('hh:mm a');
          this.details=this.destination + " on " + this.date + " at " + this.time;
          this.notificationUrl="/home/view-rentals";
        }else if(this.unread.data.info.status == 'Refunded'){
          this.title= this.unread.data.info.customer_name + " has cancelled the rental";
          this.destination=this.unread.data.info.destination;
          this.date=moment(this.unread.data.info.departure_date).format('MM D YYYY');
          this.time=moment(this.unread.data.info.departure_time, 'HH:mm').format('hh:mm a');
          this.details=this.destination + " on " + this.date + " at " + this.time;
          this.notificationUrl="/home/view-rentals";
        }
      }

    },
    methods:{
      markSpecificAsRead(){
        axios.post('/markAsReadSpecific/'+this.unread.id);
      }
    }
  }
</script>
