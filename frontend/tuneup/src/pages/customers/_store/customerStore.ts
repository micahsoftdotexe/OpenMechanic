import { defineStore } from "pinia";
import { postFetch, getFetch } from "../../../_api/requests";
import { fetchWrapper } from "../../../helpers/fetch-wrapper";
import axiosWrapper from "../../../helpers/axiosConfig";

export const useCustomerStore = defineStore('customer-store', {
    state: () => ({
        customers: [],
    }),
    actions: {
        async getCustomers() {
            try {
                const response = await axiosWrapper.get('/customers')
                console.log(response)
                this.customers = response

            } catch(error) {
                console.log(error)
            }
            
            
        }
    }

})