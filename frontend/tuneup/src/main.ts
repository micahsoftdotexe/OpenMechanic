import { createApp } from 'vue'
// import './style.css'
import App from './App.vue'
// import daisyui from 'daisyui-vue';
import { createPinia } from 'pinia'
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate'
import router from './pages/routes'
import { library } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { faUser as fasUser, faTrashCan } from '@fortawesome/free-solid-svg-icons'
import { faUser as farUser, faPenToSquare } from '@fortawesome/free-regular-svg-icons'
import './index.css'

library.add(fasUser, farUser, faPenToSquare, faTrashCan)
const store = createPinia()
store.use(piniaPluginPersistedstate)
const app = createApp(App).component('font-awesome-icon',FontAwesomeIcon)
app.use(router).use(store)

app.mount('#app')
