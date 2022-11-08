<template>
  <top-navbar></top-navbar>
  <router-view></router-view>
  <Message v-if="globalStore.hasMessage" :messageHeader="globalStore.messageHeader" :messageText="globalStore.messageMessage" :messageType="globalStore.messageType"></Message>
</template>

<script setup lang="ts">
  import Message from './components/Message.vue';
  import TopNavbar from './components/TopNavbar.vue';
  import { useGlobalStore } from './_store/globalStore';
  const globalStore = useGlobalStore()
  navigator.serviceWorker.register('/serviceWorker.js')

</script>

<style lang="css">
  @import './assets/bulma.css';
  /* @import '../node_modules/bulma/css/bulma.css'; */
</style>

<!-- <style scoped>
.logo {
  height: 6em;
  padding: 1.5em;
  will-change: filter;
}
.logo:hover {
  filter: drop-shadow(0 0 2em #646cffaa);
}
.logo.vue:hover {
  filter: drop-shadow(0 0 2em #42b883aa);
}
</style> -->
