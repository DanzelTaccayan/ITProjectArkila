<template>
  <div class="wrap">
    <a v-bind:href="notificationUrl">
      {{unread.data.name}} has made a rental request
    </a>
  </div>
</template>
<script>
  export default {
    props:['unread'],
    data(){
      return{
        notificationUrl:""
      }
    },
    mounted(){
      this.notificationUrl="home/view-rentals"
    }
  }
</script>
