<template>
    <v-card>
        <v-card-title>
            <v-text-field
                v-model="search"
                append-icon="mdi-magnify"
                label="Search"
                single-line
                hide-details> 
            </v-text-field>
        </v-card-title>
        <v-data-table
            :headers="headers"
            :items="items"
            :search="search">
        </v-data-table>
    </v-card>
</template>

<script lang="ts" setup>
import { computed, ref } from 'vue';
import { useCustomerStore } from './_store/customerStore';

const customerStore = useCustomerStore()
const search = ref('')
const headers = [
    {
        text: 'Full Name',
        align: 'start',
        value: 'fullName'
    },
    {
        text: 'Actions', 
        value: 'actions', 
        sortable: false
    }
]

const items = computed(() => {
    let items = []
    for (const customer of customerStore.customers) {
        items = [...items, {fullName: `${customer.firstName} ${customer.lastName}`}]
    }
    return items
})
</script>