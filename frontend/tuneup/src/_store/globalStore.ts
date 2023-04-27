import { defineStore } from "pinia";


export const useGlobalStore = defineStore('global-store', {
    state: () => ({
        userInfo: {first_name: null, last_name:null},
        isLoggedIn: false,
        cardTitle:''

    }),
    actions: {
        
        login(userInfo) {
            //console.log(userInfo, "userInfo")
            this.userInfo = userInfo
            this.isLoggedIn = true
        },
        logout() {
            this.userInfo = {}
            this.isLoggedIn = false
        },
        setCardTitle(title:string) {
            this.cardTitle = title
        }
    },
    persist: true
})