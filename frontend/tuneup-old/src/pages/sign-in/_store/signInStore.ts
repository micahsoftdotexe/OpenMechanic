import { defineStore } from "pinia";
import { postFetch } from "../../../_api/requests";
import { useGlobalStore } from "../../../_store/globalStore";
import router from "../../routes";
export const useSignIn = defineStore('signin-store', {
    //state: () => {},
    actions: {
        async logIn(username:String, password: String) {
            const globalStore = useGlobalStore()
            const response = await postFetch('/auth/login', {username: username, password: password}, true)
            if (response.response.status === 200) {
                globalStore.login(await response.body.user)
                router.push('/')
                return true
            }
            return false
        }
    }
})