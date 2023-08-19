<template id="topBar">
  <div class="navbar bg-base-300">
    <div class="flex-1">
      <RouterLink class="btn btn-ghost normal-case text-xl" to="/">TuneUp</RouterLink>
    </div>
    <div class="flex-none gap-2">
      <div class="dropdown dropdown-end">

        <button tabindex="0" class="btn btn-ghost bg-base-400 btn-circle inline-flex items-center justify-center">
          <font-awesome-icon v-if="isLoggedIn" icon="fa-solid fa-user text-primary" size="xl"/>
          <font-awesome-icon v-else icon="fa-regular fa-user text-primary" size="xl"/>
        </button>
        <ul tabindex="0" class="mt-3 z-[1] p-2 shadow menu menu-sm dropdown-content bg-base-100 rounded-box w-52">
          <div v-if="isLoggedIn">
            <li>
              <a class="justify-between">
                Profile
                <span class="badge">New</span>
              </a>
            </li>
            <li><a>Settings</a></li>
            <li><a @click="emit('logout')">Logout</a></li>
          </div>
          <li v-else><RouterLink to="/sign-in">Sign in</RouterLink></li>
          
        </ul>
      </div>
    </div>
  </div>
  <!-- </div> -->

  <!-- <div class="w-full">
    
  </div> -->
    
</template>
<script lang="ts" setup>

  import { computed } from 'vue';
  import { RouterLink } from 'vue-router';
    // import { Navbar, NavbarStart, NavbarEnd } from 'daisyui-vue';


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