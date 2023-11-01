<template id="topBar">
  <!-- <div class="card relative z-0"> -->
    <Menubar :model="navItems" class="z-2">
      <template #item="{ label, item, props, root, hasSubmenu }">
        <router-link v-if="item.route" v-slot="routerProps" :to="item.route" custom>
          <a :href="routerProps.href" v-bind="props.action">
              <span v-bind="props.icon"> </span>
              <span v-bind="props.label">{{ label }}</span>
          </a>
        </router-link>
        <a v-else :href="item.url" :target="item.target" v-bind="props.action">
          <span v-bind="props.icon"></span>
          <span v-bind="props.label">{{ label }}</span>
          <span :class="[hasSubmenu && (root ? 'pi pi-fw pi-angle-down' : 'pi pi-fw pi-angle-right')]" v-bind="props.submenuicon"></span>
        </a>
      </template>
      <template #end>
        <button @click="toggle" class="w-full p-link flex align-items-center p-2 pl-3 text-color hover:surface-200 border-noround">
                      <div class="flex flex-column align">
                          <span class="font-bold">{{accountLabel}}</span>
                      </div>
        </button>
        <div>
          <Menu ref="loginMenu" :model="userItems" :popup="true">
              <template #start>
                  
              </template>
              <template #item="{ item, label, props }">
                  <a class="flex" v-bind="props.action">
                      <span v-bind="props.icon" />
                      <span v-bind="props.label">{{ label }}</span>
                  </a>
              </template>
          </Menu>
        </div>
      </template>
    </Menubar>
  <!-- </div> -->
  


    
</template>
<script lang="ts" setup>

  import Menubar from 'primevue/menubar';
  import Menu from 'primevue/menu';
  import { computed, ref } from 'vue';
  import { RouterLink, createRouter, useRouter } from 'vue-router';
    // import { Navbar, NavbarStart, NavbarEnd } from 'daisyui-vue';
  const loginMenu = ref()
  const navItems = ref([
    {
      label: 'Home',
      route: '/'

    },
  ])
  const newUserItems = ref([
  { 
    label: "Login",
    to: "/sign-in"
  }
  ])
  const userItems = computed(() => {
    if (props.isLoggedIn) {
      return [
        { separator: true },
        { separator: true },
        { 
          label: "Logout",
          command: emit('logout')
        }
      ]
    } else {
      return [
        { 
          label: "Login",
          command: login
        }
      ]
    }
  })
  const router = useRouter()

  const toggle = (event) => {
    loginMenu.value.toggle(event);
  };
  function login() {
    console.log("Here")
    router.push('/sign-in')
  }
  const props = defineProps({
      'isLoggedIn': {
          required: true,
          type: Boolean,
      },
      'userInfo': {
          required: true,
          type: Object
      }
  })
  const emit = defineEmits([
      'logout'
  ])
  const accountLabel = computed(() => {
    return props.isLoggedIn ? `${props.userInfo.first_name} ${props.userInfo.last_name}` : 'Guest'
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