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
<!-- <template>
    <MDBContainer>
        <h2>Log in</h2>
        <MDBInput
            type="email"
            label="Username"
            id="usernameForm"
            v-model="username"
            wrapper-class="mb-4"
        />
        <MDBInput
            type="password"
            label="Password"
            id="passwordForm"
            v-model="password"
            wrapper-class="mb-4"
        />
        <MDBBtn color="primary" block class="mb-4" @click="login">Sign in</MDBBtn>

    </MDBContainer>

</template> -->

<script lang="ts" setup>
    import { Ref, ref } from 'vue';
    import { useSignIn } from './_store/signInStore';
    const store = useSignIn()
    
    const username:Ref<string> = ref('')
    const password:Ref<string> = ref('')

    async function login() {
    //console.log(store.logIn(username, password))
        const loginVal = await store.logIn(username.value, password.value)
        if (!loginVal) {
            username.value = ''
            password.value = ''
        }
    }
    // function required(v) {
    //     return !!v || 'Field is required'
    // }
</script>

