<template>
    <div class="text-center">
        <div class="position-relative">
            <h2>Home</h2>
            <!-- <div class="grid">
                <div class="g-column-6">
                    <h3>Orders</h3>
                    <p>Get a list of orders and edit them.</p>
                </div>
                <div class="g-column-6">
                    <h3>Customers</h3>
                    <p>Get a list of customers and edit them.</p>
                </div>
            </div> -->
            <MDBRow class="mt-5">
                <MDBCol>
                    <h3>Orders</h3>
                    <p>Get a list of orders and edit them.</p>
                    <MDBBtn color="primary" to="/orders">Orders</MDBBtn>
                </MDBCol>
                <MDBCol>
                    <h3>Customers</h3>
                    <p>Get a list of customers and edit them.</p>
                    <MDBBtn color="primary" to="/customers">Customers</MDBBtn>
                </MDBCol>
            </MDBRow>
            <!-- <MDBDropdown v-model="dropdown1">
                <MDBDropdownToggle @click="dropdown1 = !dropdown1">
                Dropdown button
                </MDBDropdownToggle>
                <MDBDropdownMenu aria-labelledby="dropdownMenuButton">
                    <MDBDropdownItem href="#">Action</MDBDropdownItem>
                    <MDBDropdownItem href="#">Another Action</MDBDropdownItem>
                    <MDBDropdownItem href="#">Something else here</MDBDropdownItem>
                </MDBDropdownMenu>
            </MDBDropdown> -->
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
import { ref } from 'vue';
import { useGlobalStore } from '../../_store/globalStore';
import {
    MDBDropdown,
    MDBRow,
    MDBBtn,
    MDBCol,
} from "mdb-vue-ui-kit"
const globalStore = useGlobalStore()
const dropdown1 = ref(false)

</script>