<template id="topBar">
    <Menubar  :model="items">
        <template #end>
            <!-- <Avatar icon="pi pi-user" to="/sign-in"/> -->
            <RouterLink to="/sign-in"><Avatar icon="pi pi-user"/></RouterLink>
        </template>
    </Menubar>
    <!-- <MenuBar items=""/> -->
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
<script lang="ts" setup>
import Menubar from 'primevue/menubar';
import Avatar from 'primevue/avatar';
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
    const items = computed(() => {return [
        {
            label: "Home",
            icon: "pi pi-home",
            to: "/"
        },
        // {
        //     label: "Sign In",
        //     icon: "",
        //     to: "/signin"
        // }

    ]})
    // const items = [
    //     {
    //         label: "Home",
    //         icon: "pi-home",
    //         to: "/home"
    //     },
    //     {
    //         label: "Sign In",
    //         icon: "",
    //         to: "/signin"
    //     }

    // ]
    watch(() => props.drawerValue, value => {
        console.log(value)
        drawer.value = value
    })
</script>
<style>
    .p-menubar {
      position: fixed;
      /* float: top */
      top: 0px;

    }
</style>