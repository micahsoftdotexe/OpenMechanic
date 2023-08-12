<template>
    <div class="text-center">
        <div class="position-relative">
            <h2>Home</h2>
        </div>
    </div>
    <!-- <div class="flex justify-content-center" style="width: 100%;">
        <Card style="width: 50%" >
            <template #title>Welcome to the TuneUp Order System!</template>
            <template #content>
                <div v-if="!globalStore.isLoggedIn">
                    <p>Please log in to continue</p>
                    <RouterLink to="/sign-in">
                        <Button label="Log in"></Button>
                    </RouterLink>
                </div>
                <div v-else class="grid">
                    <div class="col">
                        <Button label="Orders"></Button>
                    </div>
                    <div class="col">
                        <RouterLink to="/customers">
                            <Button label="Customers"></Button>
                        </RouterLink>
                    </div>
                    
                </div>
            </template>
        </Card>
    </div> -->
    
    <!-- <TopNavbar/> -->
</template>

<script setup lang="ts">
import { useGlobalStore } from '../../_store/globalStore';
const globalStore = useGlobalStore()


</script>