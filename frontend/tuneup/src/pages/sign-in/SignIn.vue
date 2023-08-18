<template>
    <q-page>
        <q-form
            @submit="login"
            class="q-gutter-md"
        >
            <q-input
                filled
                v-model="username"
                label="username"
                lazy-rules
                :rules="[ val => val && val.length > 0 || 'Please type something']"
            />
            <q-input
                filled
                v-model="password"
                label="password"
                type="password"
                lazy-rules
                :rules="[ val => val && val.length > 0 || 'Please type something']"
            />
            <q-btn label="Sign In" type="submit" color="primary"/>


        </q-form>
    </q-page>

</template>

<script lang="ts" setup>
    import { Ref, ref } from 'vue';
    import { useSignIn } from './_store/signInStore';
    const store = useSignIn()
    
    const form:Ref<Boolean> = ref(false)
    const username:Ref<string> = ref("")
    const password:Ref<string> = ref("")

    async function login(){
    //console.log(store.logIn(username, password))
    const loginVal = await store.logIn(username.value, password.value)
        if (!loginVal) {
            username.value = ''
            password.value = ''
        }
    }
    function required(v) {
        return !!v || 'Field is required'
    }
</script>

