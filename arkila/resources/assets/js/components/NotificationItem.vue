<template>
  <div class="wrap">
    <a v-bind:href="notificationUrl">
      {{unread.data.name}}
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
      this.notificationUrl=""
    }
  }
</script>
