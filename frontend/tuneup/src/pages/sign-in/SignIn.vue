<template>
    <div>
        <div>
            <TopNavbar/>

        </div>
        <div>
            <div class="field">
                <input class="input" v-model="username" placeholder="Username">
            </div>
            <div class="field">
                <input class="input" v-model="password" type="password" placeholder="Password">
            </div>
            <div class="field">
                <button class="button is-success" @click="store.logIn(username, password)">Login</button>
            </div>
            <!-- <input @click="store.logIn(username, password)" type="button"> -->
            
            
        </div>
    </div>

</template>

<script lang="ts" setup>
    import { Ref, ref } from 'vue';
    import TopNavbar from '../../components/TopNavbar.vue';
    import { useSignIn } from './_store/signInStore';
    const store = useSignIn()

    const username:Ref<String> = ref("")
    const password:Ref<String> = ref("")
</script>

