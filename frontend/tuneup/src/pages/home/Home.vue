<template>
    <!-- <div class="flex justify-center items-center h-screen">
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
    </div> -->

    <div class="grid grid-nogutter surface-section text-800">
        <div class="col-12 md:col-6 p-6 text-center md:text-left flex align-items-center ">
            <section>
                <span class="block text-6xl font-bold mb-1">Create the screens your</span>
                <div class="text-6xl text-primary font-bold mb-3">visitors deserve to see</div>
                <p class="mt-0 mb-4 text-700 line-height-3">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                
                <Button label="Learn More" type="button" class="mr-3 p-button-raised"></Button>
                <Button label="Live Demo" type="button" class="p-button-outlined"></Button>
                <p>Hellp</p>
                <p>Hellp</p>
                <p>Hellp</p>
                <p>Hellp</p>
                <p>Hellp</p>
                <p>Hellp</p>
                <p>Hellp</p>
                <p>Hellp</p>
                <p>Hellp</p>
                <p>Hellp</p>
                <p>Hellp</p>
                <p>Hellp</p>
                <p>Hellp</p>
                <p>Hellp</p>
                <p>Hellp</p>
                <p>Hellp</p>
                <p>Hellp</p>
                <p>Hellp</p>
                <p>Hellp</p>
                <p>Hellp</p>
                <p>Hellp</p>
                <p>Hellp</p>
            </section>
        </div>
        <div class="col-12 md:col-6 overflow-hidden">
            <img src="images/blocks/hero/hero-1.png" alt="Image" class="md:ml-auto block md:h-full" style="clip-path: polygon(8% 0, 100% 0%, 100% 100%, 0 100%)">
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { useGlobalStore } from '../../_store/globalStore';
import Button from 'primevue/button';
const globalStore = useGlobalStore()
const dropdown1 = ref(false)

</script>