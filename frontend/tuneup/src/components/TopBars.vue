<template id="topBar">
    
    <q-toolbar>
        <q-toolbar-title>
          <q-avatar>
            <img src="https://cdn.quasar.dev/logo-v2/svg/logo-mono-white.svg">
          </q-avatar>
          Tuneup
        </q-toolbar-title>
        <q-space/>
      <q-btn-dropdown
        :label="accountLabel">
        <div class="row no-wrap q-pa-md">
          <div class="column">
            <div class="text-h6 q-mb-md">Settings</div>
            <p>Account Settings</p>
          </div>

          <q-separator vertical inset class="q-mx-lg" />

          <div class="column items-center">
            <!-- <q-avatar size="72px">
              <img src="https://cdn.quasar.dev/img/boy-avatar.png">
            </q-avatar> -->

            <div class="text-subtitle1 q-mt-md q-mb-xs">{{accountLabel}}</div>

            <q-btn
              v-if="isLoggedIn"
              color="primary"
              label="Logout"
              push
              size="sm"
              @click="emit('logout')"
              v-close-popup
            />
            <q-btn
              v-else
              color="primary"
              label="Sign In"
              push
              size="sm"
              to="/sign-in"
              v-close-popup
            />
          </div>
        </div>
      </q-btn-dropdown>
    </q-toolbar>
    
</template>
<script lang="ts" setup>

    import { computed } from 'vue';


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