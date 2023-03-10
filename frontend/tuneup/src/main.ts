import { createApp } from 'vue'
import './style.css'
import App from './App.vue'
import { createWebHistory } from 'vue-router'
import createRouter  from './pages/routes'
import { createPinia } from 'pinia'
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate'
import router from './pages/routes'

// import Avatar from 'primevue/avatar';
import Avatar from 'primevue/avatar';
import Menubar from 'primevue/menubar';
import Card from 'primevue/card';
import Editor from 'primevue/editor';
import InputText from 'primevue/inputtext';
import Toolbar from 'primevue/toolbar';
import Button from 'primevue/button';
import Password from 'primevue/password';
import PrimeVue from 'primevue/config';

import "primevue/resources/themes/lara-light-indigo/theme.css";
import "primevue/resources/primevue.min.css";
import "primeicons/primeicons.css";


// const router = createRouter(createWebHistory())
const store = createPinia()
store.use(piniaPluginPersistedstate)
const app = createApp(App)
app.use(PrimeVue).use(router).use(store)
app.component('Avatar', Avatar)
app.component('MenuBar', Menubar)
app.component('Toolbar', Toolbar)
app.component('Button', Button)
app.component('Card', Card)
app.component('InputText', InputText)
app.component('Password', Password)
app.component('Editor', Editor)
// app.component('Chips', Chips)
//app.component('Button', Button)
// app.component('Dropdown', Dropdown)
// app.component('AutoComplete', AutoComplete)
// app.component('Tag', Tag)
// app.component('Dialog', Dialog)
// app.component('Inplace', Inplace)

app.mount('#app')
