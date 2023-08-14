import { createApp } from 'vue'
// import './style.css'
import App from './App.vue'
import { createWebHistory } from 'vue-router'
import createRouter  from './pages/routes'
import { createPinia } from 'pinia'
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate'
import router from './pages/routes'
// import 'mdb-vue-ui-kit/css/mdb.min.css';
// import './assets/mdb.dark.min.css'
  
const store = createPinia()
store.use(piniaPluginPersistedstate)
const app = createApp(App)
app.use(router).use(store)

app.mount('#app')
