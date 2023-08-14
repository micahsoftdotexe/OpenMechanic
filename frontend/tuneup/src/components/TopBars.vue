<template id="topBar">
    <MDBNavbar expland="xxl" dark bg="dark" container class="flex-start">
        <MDBNavbarNav class="flex-row">
            <MDBNavbarItem to="/" class="me-3">Home</MDBNavbarItem>
        </MDBNavbarNav>
        <MDBNavbarNav right>
            <MDBDropdown v-model="userDropdown" class="nav-item">
                <MDBDropdownToggle tag="a" class="nav-link" @click="userDropdown = !userDropdown">
                    <!-- < v-if="globalStore.isLoggedIn" class="fa-regular fa-user"></i> -->
                    <!-- <MDBIcon  icon="fa-solid fa-user"></MDBIcon> -->
                    <i v-if="globalStore.isLoggedIn" class="fas fa-user"></i>
                    <!-- <MDBIcon v-else icon-style="far" icon="fa-user"></MDBIcon> -->
                    <i v-else class="far fa-user"></i>
                </MDBDropdownToggle>
                <MDBDropdownMenu>
                    <MDBDropdownItem v-if="!globalStore.isLoggedIn" to="/sign-in">Sign In</MDBDropdownItem>
                    <MDBDropdownItem to="#" v-else @click="globalStore.logout()">Sign Out</MDBDropdownItem>
                </MDBDropdownMenu>
            </MDBDropdown>
        </MDBNavbarNav>
    </MDBNavbar>
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

import { ref, watch, computed } from 'vue';
import {
    MDBNavbar,
    MDBNavbarBrand,
    MDBNavbarNav,
    MDBNavbarItem,
    // MDBContainer,
    MDBIcon,
    MDBDropdown,
    MDBDropdownToggle,
    MDBDropdownItem,
    MDBDropdownMenu
} from "mdb-vue-ui-kit";
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
    const userDropdown = ref(false)
    const items = computed(() => {
        if (globalStore.isLoggedIn) {
            return [
                {
                    label: "Home",
                    icon: "pi pi-home",
                    to: "/"
                },
                {
                    label: globalStore.userInfo.first_name,
                    icon: "pi pi-user",
                    // to: "/signin",
                    style: "position: absolute; right: 4px;",
                    items: [
                        {
                            label: 'logout',
                            icon: 'pi pi-fw pi-sign-out',
                            command: () => globalStore.logout()

                        }
                    ]
                }
            ]
        }
        return [
            {
                label: "Home",
                icon: "pi pi-home",
                to: "/"
            },
            {
                label: "Sign In",
                icon: "pi pi-user",
                to: "/sign-in",
                style: "position: absolute; right: 4px;"
            }
        ]
    })
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
      /* align-self: flex-start; */
      top: 0px;
      width: 100%;
      right: 0px;

    }
    
</style>