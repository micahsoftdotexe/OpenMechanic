<template>
    <div class="flex justify-content-center" style="width: 100%;">
        <Card style="width: 50%" >
            <template #title>Welcome to the TuneUp Order System!</template>
            <template #content>
                <div v-if="!globalStore.isLoggedIn">
                    <p>Please log in to continue</p>
                    <RouterLink to="/sign-in">
                        <Button label="Log in"></Button>
                    </RouterLink>
                </div>
            </template>
        </Card>
    </div>
    
    <!-- <TopNavbar/> -->
</template>

<script setup lang="ts">
import { useGlobalStore } from '../../_store/globalStore';
import TopNavbar from '../../components/TopBars.vue';
import Card from 'primevue/card';
import Button from 'primevue/button';
const globalStore = useGlobalStore()


</script>