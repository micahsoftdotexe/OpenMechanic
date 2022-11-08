import { defineStore } from "pinia";


export const useMessageStore = defineStore('message-store', {
    state: () => ({
        hasMessage: false,
        messageHeader: '',
        messageMessage: '',
        messageType: '',
        messageTimeout: 10000,
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
    }
})