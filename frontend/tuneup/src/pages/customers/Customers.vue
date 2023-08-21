<template>
    <p>Hello</p>
   
      <Table :columns="columns" :data-source="dataSource" theme="forest"/>
</template>

<script setup lang="ts">
    import { onMounted } from 'vue';
    // import Card from 'primevue/card';
    // import DataTable from 'primevue/datatable';
    // import Column from 'primevue/column';
    import { useCustomerStore } from './_store/customerStore';
    import { computed } from '@vue/reactivity';
    import { ITableColumn, IconTabletLandscape, Table } from 'daisyui-vue';
    import DataTable from '../../components/DataTable.vue';
    const columns = [
      {
        title: '',
        dataIndex: 'num',
        fixed: 'left',
        width: 20,
      } as ITableColumn,
      {
        title: 'name',
        dataIndex: 'name',
      } as ITableColumn,
      {
        title: 'job',
        dataIndex: 'job',
      } as ITableColumn,
      {
        title: 'favorite color',
        dataIndex: 'favoriteColor',
      } as ITableColumn,
    ];

    const dataSource = [
      {
        num: 1,
        name: 'Cy Ganderton',
        job: 'Quality Control Specialist',
        favoriteColor: 'Blue',
      },
      {
        num: 2,
        name: 'Hart Hagerty',
        job: 'Desktop Support Technician',
        favoriteColor: 'Purple',
      },
      {
        num: 3,
        name: 'Brice Swyre',
        job: 'Tax Accountant',
        favoriteColor: 'Red',
      },
      {
        num: 4,
        name: 'Marjy Ferencz',
        job: 'Office Assistant I',
        favoriteColor: 'Crimson',
      },
    ];
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