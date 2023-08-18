<template>
    <q-page class="flex justify-center items-center">
        <div>
            <h1>Welcome to the TuneUp Order System</h1>
            <div class="fit row justify-evenly items-start">
                <div>
                    <h2 class="q-mb-xs">Orders</h2>
                    <p class="text-center">Lists all orders</p>
                    <div class="row justify-center items-start">
                        <q-btn color="primary" label="Orders" to="/orders"/>
                    </div>
                </div>
                <div>
                    <h2 class="q-mb-xs">Customers</h2>
                    <p class="text-center">Lists all customers</p>
                    <div class="row justify-center items-start">
                        <q-btn color="primary" label="Customers" to="/customers"/>
                    </div>
                </div>
            </div>
            
        </div>
        
    </q-page>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { useGlobalStore } from '../../_store/globalStore';
const globalStore = useGlobalStore()
const dropdown1 = ref(false)

</script>