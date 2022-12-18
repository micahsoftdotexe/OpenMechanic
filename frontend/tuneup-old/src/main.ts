import { createApp } from 'vue'
import './style.css'
import App from './App.vue'
import { createWebHistory } from 'vue-router'
import createRouter  from './pages/routes'
import { createPinia } from 'pinia'
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate'
import router from './pages/routes'
import vuetify from "./plugins/vuetify";
import '@mdi/font/css/materialdesignicons.css'
//import bulma = require('@/assets/main.scss')
//import from './assets/main.scss'
//require('@/assets/bulma.css')

// const router = createRouter(createWebHistory())
const store = createPinia()
store.use(piniaPluginPersistedstate)
const app = createApp(App)
app.use(vuetify).use(router).use(store).mount('#app')
