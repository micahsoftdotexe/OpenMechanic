<template>

    <MenuBar items=""/>
    <!-- <v-app-bar color="primary">
      <template v-slot:prepend>
        <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
      </template>
      <v-app-bar-title>TuneUp</v-app-bar-title>
    </v-app-bar>
    <v-navigation-drawer location="left" v-model="drawer">
        <template v-slot:prepend>
            <v-list-item
                v-if="!globalStore.isLoggedIn"
                to="/sign-in"
                title="Sign In"
                prepend-icon="mdi-account-outline"
            ></v-list-item>
            <v-list-item
                v-if="globalStore.isLoggedIn"
                :title="`${globalStore.userInfo.first_name} ${globalStore.userInfo.last_name}`"
                to="/"
                prepend-icon="mdi-account"
                subtitle="Logged In"
                @click="globalStore.logout()"
            ></v-list-item>
        </template>
        <v-divider></v-divider>
        <v-list density="compact" nav>
            <v-list-item prepend-icon="mdi-home" title="Home" to="/"></v-list-item>
        </v-list>
    </v-navigation-drawer> -->
    
</template>
import Menubar from 'primevue/menubar';
<script lang="ts" setup>
import { ref, watch, computed } from 'vue';
import { useGlobalStore } from '../_store/globalStore';
    const drawer = ref(false)
    const globalStore = useGlobalStore()
    const props = defineProps({
        drawerValue: {
            type: Boolean,
            required: false,
            default: false
        }
    })
    const items = computed(() => {[
        {
            label: "Home",
            icon: "pi-home",
            to: "/home"
        },

    ]})
    watch(() => props.drawerValue, value => {
        console.log(value)
        drawer.value = value
    })
</script>