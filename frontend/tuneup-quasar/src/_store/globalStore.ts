import { defineStore } from 'pinia';


export const useGlobalStore = defineStore('global-store', {
    state: () => ({
        userInfo: {first_name: null, last_name:null, token:null},
        isLoggedIn: false,
    }),
    actions: {
        
        login(userInfo:any) {
            this.userInfo = userInfo
            this.isLoggedIn = true
        },
        logout() {
            this.userInfo = {first_name: null, last_name:null, token:null}
            this.isLoggedIn = false
        },
        getFullName():string {
            return `${this.userInfo.first_name} ${this.userInfo.last_name}`
        },
    },
    persist: true
})