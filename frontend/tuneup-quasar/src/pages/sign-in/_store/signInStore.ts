import { defineStore } from "pinia";
import { useGlobalStore } from "src/_store/globalStore";
import { fetchWrapper } from "src/helpers/fetch-wrapper";
// import { useRouter } from "vue-router";
import router from '@/router'

export const useSignIn = defineStore('signin-store', {
    //state: () => {},
    actions: {
        async logIn(username:string, password: string) {
            const globalStore = useGlobalStore()
            // const response = await postFetch('/auth/login', {username: username, password: password}, true)
            try {
                const router = useRouter()
                const response = await fetchWrapper.post('/auth/login', {username: username, password: password})
                const user = response.user
                user.token = response.jwt_token
                console.log(response)
                globalStore.login(user)
                console.log("here")
                router.push({
                    name:'home'
                })
                return true
            } catch(error) {
                console.log(error)
            }
            // console.log(response)
            // if (response.response.status === 200) {
            //     globalStore.login(await response.body.user)
            //     router.push('/')
            //     return true
            // }
            // return false
        }
    }
})