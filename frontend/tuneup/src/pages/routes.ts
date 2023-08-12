import {createRouter, createWebHashHistory} from 'vue-router'
import Home from './home/Home.vue';
// import SignIn from './sign-in/SignIn.vue.old';
// import Customers from './customers/Customers.vue.old'

const routes = [
    {
        path: '/',
        component: Home
    },

    // {
    //     path: '/sign-in',
    //     component: SignIn
    // },

    // {
    //     path: "/customers",
    //     component: Customers
    // }
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