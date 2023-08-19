<template>
    <p>Hello</p>
    <DataTable
    :columns="['id', 'name']"
    :data="[{id: 0, name:'Micah'}, {id: 1, name: 'Shirley'}]"
    ></DataTable>
</template>

<script setup lang="ts">
    import { onMounted } from 'vue';
    // import Card from 'primevue/card';
    // import DataTable from 'primevue/datatable';
    // import Column from 'primevue/column';
    import { useCustomerStore } from './_store/customerStore';
import { computed } from '@vue/reactivity';
import DataTable from '../../components/DataTable.vue';
    const store = useCustomerStore()
    onMounted(async () => {
        await store.getCustomers()
    })
    const customers = computed(() => {
        return store.customers.map((el) => {
            return {id: el.id, full_name: `${el.first_name} ${el.last_name}` }
        })
        // const returnVal = []
        // for(const customer of store?.customers) {
        //     returnVal.push({id: customer.id, full_name: `${customer.first_name} ${customer.last_name}`})
        // }
        // return returnVal
    })
</script>