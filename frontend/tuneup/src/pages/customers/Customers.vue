<template>
    <p>Hello</p>
   
      <!-- <Table :columns="columns" :data-source="customers" theme="forest"/> -->
</template>

<script setup lang="ts">
  import { h, onMounted, resolveComponent } from 'vue';
  // import Card from 'primevue/card';
  // import DataTable from 'primevue/datatable';
  // import Column from 'primevue/column';
  import { useCustomerStore } from './_store/customerStore';
  import { computed } from '@vue/reactivity';
  import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
    // const columns = [
    //   {
    //     title: '',
    //     dataIndex: 'id',
    //     fixed: 'left',
    //     width: 20,
    //   } as ITableColumn,
    //   {
    //     title: 'Full Name',
    //     dataIndex: 'full_name',
    //   } as ITableColumn,
    //   {
    //     title: '',
    //     dataIndex: 'id',
    //     render: (id) => {return h('span',{},[
    //       h(resolveComponent('router-link'),{
    //         to: `/customers/edit/${id}`
    //       }, [
    //         h(resolveComponent('font-awesome-icon'), {
    //           icon: 'fa-regular fa-pen-to-square'
    //         }, '')
    //       ]),
    //       h('button',{
    //         class: 'button-link ml-2',
    //         onClick: (ev) => {
    //           remove(id)
    //         }
    //       }, [
    //         h(resolveComponent('font-awesome-icon'), {
    //           icon: 'fa-solid fa-trash-can'
    //         }, '')
    //       ]),
    //     ])}

    //   } as ITableColumn
    // ];

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
    function remove(id) {
      console.log(id)
    }
</script>
<style>
 .button-link {
  background: none!important;
  border: none;
  padding: 0!important;
  /*optional*/
  font-family: arial, sans-serif;
  /*input has OS specific font-family*/
  /* color: #069; */
  /* text-decoration: underline; */
  cursor: pointer;
 }
</style>