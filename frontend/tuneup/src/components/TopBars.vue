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
        <div v-if="isLoggedIn" class="p-menuitem-content">
          <a class="p-menuitem-link" tabindex="-1" aria-hidden="true" data-pc-section="action" data-pd-ripple="true">
            <span class="p-menuitem-icon pi pi-fw pi-file" data-pc-section="icon"></span>
            <span class="p-menuitem-text" data-pc-section="label">Guest</span></a></div>
      </template>
    </Menubar>
  <!-- </div> -->
  


    
</template>
<script lang="ts" setup>

  import Menubar from 'primevue/menubar';
  import { computed, ref } from 'vue';
  import { RouterLink } from 'vue-router';
    // import { Navbar, NavbarStart, NavbarEnd } from 'daisyui-vue';

  const navItems = ref([
    {
      label: 'Home',
      route: '/'

    }
  ])
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