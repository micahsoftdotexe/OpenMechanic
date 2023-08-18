<template>

  <!-- <TopBars></TopBars> -->
  <q-layout view="hHh LpR fFf">

    <q-header elevated class="bg-primary text-white" height-hint="98">
      <top-bars :is-logged-in="globalStore.isLoggedIn" :user-info="globalStore.userInfo" @logout="globalStore.logout"/>

      <!-- <q-tabs align="left">
        <q-route-tab to="/page1" label="Page One" />
        <q-route-tab to="/page2" label="Page Two" />
        <q-route-tab to="/page3" label="Page Three" />
      </q-tabs> -->
    </q-header>

    <q-page-container>
      <router-view />
    </q-page-container>

    <q-footer elevated class="bg-grey-8 text-white">
      <q-toolbar>
        <q-toolbar-title>
          <!-- <q-avatar>
            <img src="https://cdn.quasar.dev/logo-v2/svg/logo-mono-white.svg">
          </q-avatar> -->
          <div>Tuneup</div>
        </q-toolbar-title>
      </q-toolbar>
    </q-footer>

  </q-layout>
  
  

</template>

<script setup lang="ts">
  import { ref, watch } from 'vue';
  import { useGlobalStore } from './_store/globalStore';
  import { useMessageStore } from './_store/messageStore';
  import { useRoute } from 'vue-router';
  import { computed } from '@vue/reactivity';
  import TopBars from './components/TopBars.vue';
  const globalStore = useGlobalStore()

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
