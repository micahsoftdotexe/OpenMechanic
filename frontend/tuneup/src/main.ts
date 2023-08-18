import { createApp } from 'vue'
// import './style.css'
import App from './App.vue'
import { createWebHistory } from 'vue-router'
import createRouter  from './pages/routes'
import { createPinia } from 'pinia'
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate'
import router from './pages/routes'
import {Quasar} from 'quasar'
// import 'mdb-vue-ui-kit/css/mdb.min.css';
// import './assets/mdb.dark.min.css'
import 'quasar/src/css/index.sass'
import '@quasar/extras/material-icons/material-icons.css'
import '@quasar/extras/fontawesome-v6/fontawesome-v6.css'

  
const store = createPinia()
store.use(piniaPluginPersistedstate)
const app = createApp(App)
app.use(Quasar, {
    plugins: {}
})
app.use(router).use(store)

app.mount('#app')
