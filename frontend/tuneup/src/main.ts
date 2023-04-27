import { createApp } from 'vue'
import './style.css'
import App from './App.vue'
import { createWebHistory } from 'vue-router'
import createRouter  from './pages/routes'
import { createPinia } from 'pinia'
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate'
import router from './pages/routes'
import PrimeVue from 'primevue/config';
import 'primevue/resources/primevue.min.css'
import "primevue/resources/themes/lara-dark-indigo/theme.css";
import 'primeicons/primeicons.css'
import '/node_modules/primeflex/primeflex.css'  
// import 'vuetify/styles'
// import { createVuetify } from 'vuetify'
// import * as components from 'vuetify/components'
// import * as directives from 'vuetify/directives'

// const vuetify = createVuetify({
//     components,
//     directives,
//   })
  
const store = createPinia()
store.use(piniaPluginPersistedstate)
const app = createApp(App)
app.use(router).use(store).use(PrimeVue)
// app.component('Avatar', Avatar)
// app.component('MenuBar', Menubar)
// app.component('Toolbar', Toolbar)
// app.component('Button', Button)
// app.component('Card', Card)
// app.component('InputText', InputText)
// app.component('Password', Password)
// app.component('Editor', Editor)
// app.component('Chips', Chips)
//app.component('Button', Button)
// app.component('Dropdown', Dropdown)
// app.component('AutoComplete', AutoComplete)
// app.component('Tag', Tag)
// app.component('Dialog', Dialog)
// app.component('Inplace', Inplace)

app.mount('#app')
