<template>
    <div class="flex justify-center items-center h-screen">
        <div>
            <p class="text-7xl text-primary">Welcome to the TuneUp Order System</p>
            <div class="flex row justify-evenly items-start mt-8">
                <div>
                    <p class="text-5xl mb-1">Orders</p>
                    <p class="text-center mb-2">Lists all orders</p>
                    <div class="flex row justify-center items-start">
                        <RouterLink class="btn btn-primary" to="/orders">Orders</RouterLink>
                    </div>
                </div>
                <div>
                    <p class="text-5xl mb-1">Customers</p>
                    <p class="text-center mb-2">Lists all customers</p>
                    <div class="flex row justify-center items-start">
                        <RouterLink class="btn btn-primary" to="/customers">Customers</RouterLink>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { useGlobalStore } from '../../_store/globalStore';
const globalStore = useGlobalStore()
const dropdown1 = ref(false)

</script>