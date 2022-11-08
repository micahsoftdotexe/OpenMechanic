import {createRouter} from 'vue-router'
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
    }
]

export default function (history:any) {
    return createRouter({
        history,
        routes
    })
}