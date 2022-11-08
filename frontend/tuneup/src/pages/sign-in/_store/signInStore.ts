import { defineStore } from "pinia";
import { postFetch } from "../../../_api/requests";
import router from "../../routes";
export const useSignIn = defineStore('signin-store', {
    //state: () => {},
    actions: {
        async logIn(username:String, password: String) {
            const response = await postFetch('/auth/login', {username: username, password: password}, true)
            if (response.status == 200) {
                //return true
                router.push('/')
            }
            return false
            // const response = await fetch(`${url}/auth/login`, {
            //     method: 'POST',
            //     //mode: 'no-cors',
            //     body: JSON.stringify({username: username, password: password}),
            //     headers: {
            //         'Content-Type': 'application/json'
            //     }
            // })
            console.log(response)
        // onsole.log('ehllo', response.body)
        }
    }
})