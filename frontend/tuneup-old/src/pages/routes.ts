import {createRouter, createWebHashHistory} from 'vue-router'
import CustomerList from './customer/CustomerList.vue';
import Home from './home/Home.vue';
import SignIn from './sign-in/SignIn.vue';

const routes = [
    {
        path: '/',
        component: Home
    },

    {
        path: '/sign-in',
        component: SignIn
    },

    {
        path:'/customers',
        component: CustomerList
    }
]

// export default function (history:any) {
//     return createRouter({
//         history,
//         routes
//     })
// }
const router = createRouter({
    history: createWebHashHistory(),
    routes,
})
export default router