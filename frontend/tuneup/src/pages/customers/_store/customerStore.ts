import { defineStore } from "pinia";
import { postFetch, getFetch } from "../../../_api/requests";
import { fetchWrapper } from "../../../helpers/fetch-wrapper";

export const useCustomerStore = defineStore('customer-store', {
    state: () => ({
        customers: [],
    }),
    actions: {
        async getCustomers() {
            const response = await fetchWrapper.get('/customers')
            console.log(response)
            this.customers = response
            
        }
    }

})