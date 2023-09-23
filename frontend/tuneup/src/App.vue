<template>

  <top-bars :is-logged-in="globalStore.isLoggedIn" :user-info="globalStore.userInfo" @logout="globalStore.logout"/>
  <ThemeProvider :theme="theme">
    <router-view/>
  </ThemeProvider>
  <!-- <TopBars></TopBars> -->
  <!-- <q-layout view="hHh LpR fFf">

    <q-header elevated class="bg-primary text-white" height-hint="98">
    </q-header>

    <q-page-container>
      <router-view />
    </q-page-container>

    <q-footer elevated class="bg-grey-8 text-white">
      <q-toolbar>
        <q-toolbar-title>
          <div>Tuneup</div>
        </q-toolbar-title>
      </q-toolbar>
    </q-footer>

  </q-layout> -->
  
  

</template>

<script setup lang="ts">
  import { onMounted, ref, watch } from 'vue';
  import { ThemeProvider, createThemeForest } from 'daisyui-vue';
  import { useGlobalStore } from './_store/globalStore';
  import { useMessageStore } from './_store/messageStore';
  import { useRoute } from 'vue-router';
  import { computed } from '@vue/reactivity';
  import TopBars from './components/TopBars.vue';
  const globalStore = useGlobalStore()
  const theme = createThemeForest()
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

<!-- <style lang="css">
  /* #app {
    font-family: Roboto, Helvetica, Ari
</style> -->


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
