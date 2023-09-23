<template>

  <TopBars :is-logged-in="globalStore.isLoggedIn" :user-info="globalStore.userInfo" @logout="globalStore.logout"/>
  <RouterView/>
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
