import { defineStore } from "pinia";


export const useGlobalStore = defineStore('global-store', {
    state: () => ({
        userInfo: {},
        loggedIn: false

    }),
    actions: {
        
        login(userInfo) {
            this.userInfo = userInfo
            this.isLoggedIn = true
        },
        logout() {
            this.userInfo = {}
            this.loggedIn = false
        }
    },
    persist: true
})