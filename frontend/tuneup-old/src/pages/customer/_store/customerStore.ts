import { defineStore } from "pinia";
import { getFetch } from "../../../_api/requests";

export const useCustomerStore = defineStore('customer-store', {
    state: () => ({
        customers: []
    }),
    actions: {
        async initialize() {
            this.customers = []
            const customerResponse = await getFetch('customer/list', true)
            if (customerResponse.response.status == 200) {
                this.customers = customerResponse.body
            }
        }
    }
})