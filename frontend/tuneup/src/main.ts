import { createApp } from 'vue'
import './style.css'
import App from './App.vue'
import { createWebHistory } from 'vue-router'
import createRouter  from './pages/routes'
import { createPinia } from 'pinia'
//import bulma = require('@/assets/main.scss')
//import from './assets/main.scss'
//require('@/assets/bulma.css')

const router = createRouter(createWebHistory())
const store = createPinia()
const app = createApp(App)
app.use(router).use(store).mount('#app')
