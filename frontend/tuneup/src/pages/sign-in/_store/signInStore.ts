import { defineStore } from "pinia";

const url = "http://localhost:8080"
export const useSignIn = defineStore('signin-store', {
    //state: () => {},
    actions: {
        async logIn(username:String, password: String) {
            const response = await fetch(`${url}/auth/login`, {
                method: 'POST',
                //mode: 'no-cors',
                body: JSON.stringify({username: username, password: password}),
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            console.log(await response.json())
        // onsole.log('ehllo', response.body)
        }
    }
})