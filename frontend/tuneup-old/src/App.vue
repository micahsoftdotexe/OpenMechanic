<template>
  <v-app>
    <!-- <v-navigation-drawer></v-navigation-drawer> -->
    <top-bars :drawerValue = "drawer"></top-bars>
    
    <v-main>
      <v-container fluid>
        <router-view></router-view>
        <v-snackbar
          :timeout="messageStore.messageTimeout"
          :color="messageColor"
          elevation="24"
          v-model="hasMessage"
         >{{messageStore.messageMessage}}</v-snackbar>
      </v-container>
    </v-main>
  </v-app>
</template>

<script setup lang="ts">
  // import Message from './components/Message.vue';
  import TopBars from './components/TopBars.vue'
  import { ref, watch } from 'vue';
  import { useGlobalStore } from './_store/globalStore';
  import { useMessageStore } from './_store/messageStore';
  import { useRoute } from 'vue-router';
import { computed } from '@vue/reactivity';
  const messageStore = useMessageStore()
  const route = useRoute();
  const drawer = ref(false)

  watch(() => route, () => {
    drawer.value = false
  })

  const hasMessage = computed({
    get() {
      return messageStore.hasMessage
    },
    set(value) {
      console.log(value)
      if (!value) {
        messageStore.clearMessage()
      }
    }
  })

  const messageColor = computed(() =>{
    return (messageStore.messageType == 'Error') ? 'deep-red-accent-4' : 'deep-green-accent-4'
  })
</script>

<style lang="css">
  /* @import './assets/bulma.css'; */
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
