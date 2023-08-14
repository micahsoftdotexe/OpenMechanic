<template>
  <q-layout view="hHh lpR fFf">

    <q-header elevated class="bg-primary text-white" height-hint="98">
      <top-bars :is-logged-in="globalStore.isLoggedIn" :user-info="globalStore.userInfo" @logout="globalStore.logout"/>

      <q-tabs align="left">
        <q-route-tab to="/page1" label="Page One" />
        <q-route-tab to="/page2" label="Page Two" />
        <q-route-tab to="/page3" label="Page Three" />
      </q-tabs>
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
import { useGlobalStore } from 'src/_store/globalStore';
import TopBars from 'src/components/TopBars.vue';
const globalStore = useGlobalStore()

// const accountIcon = computed(() => {
//   return globalStore.isLoggedIn ? globalStore.getFullName() : 'Guest'
// })
</script>
