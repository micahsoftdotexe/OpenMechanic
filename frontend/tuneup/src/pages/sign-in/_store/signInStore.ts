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
            if (response.response.ok) {
                globalStore.login(await response.body)
                //return true
                router.push('/')
                return true
            }
            return false
        }
    }
})