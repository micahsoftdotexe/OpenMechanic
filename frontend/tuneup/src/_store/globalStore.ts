import { defineStore } from "pinia";


export const useGlobalStore = defineStore('global-store', {
    state: () => ({
        hasMessage: false,
        messageHeader: '',
        messageMessage: '',
        messageType: '',
        messageTimeout: 10000,

        userInfo: {},
        loggedIn: false

    }),
    actions: {
        setError(errorHeader:String, errorMessage:String) {
            this.messageHeader = errorHeader
            this.messageMessage = errorMessage
            this.messageType = 'Error'
            this.hasMessage = true
            setInterval(() => {
                this.hasMessage = false
            }, this.messageTimeout)
        },
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