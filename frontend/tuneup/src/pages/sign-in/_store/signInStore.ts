import { defineStore } from "pinia";
import { postFetch } from "../../../_api/requests";
import { useGlobalStore } from "../../../_store/globalStore";
import router from "../../routes";
import axiosWrapper from "../../../helpers/axiosConfig";
export const useSignIn = defineStore('signin-store', {
    //state: () => {},
    actions: {
        async logIn(username:String, password: String) {
            const globalStore = useGlobalStore()
            // const response = await postFetch('/auth/login', {username: username, password: password}, true)
            try {
                const response = await axiosWrapper.post('/auth/login', {username: username, password: password})
                let user = response.data.user
                user.token = response.data.jwt_token
                console.log(response)
                globalStore.login(user)
                router.push('/')
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