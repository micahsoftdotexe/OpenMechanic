<template>
    <!-- <v-card>

    </v-card> -->
    <v-card fluid>
        <!-- <h1>Sign In</h1>
        <v-divider></v-divider> -->
        <v-form @submit.prevent="login" v-model="form">
            <v-text-field
                label="Username"
                v-model="username"
                :rules="[required]"
            ></v-text-field>
            <v-text-field
                label="Password"
                v-model="password"
                type="password"
                :rules="[required]"
            ></v-text-field>

            <v-btn
                :disabled="!form"
                block
                color="success"
                size="large"
                type="submit"
                variant="elevated"
            >Sign In</v-btn>

        </v-form>
    </v-card>
    <!-- <div>
        <div>

        </div>
        <div>
            <div class="field">
                <input class="input" v-model="username" placeholder="Username">
            </div>
            <div class="field">
                <input class="input" v-model="password" type="password" placeholder="Password">
            </div>
            <div class="field">
                <button class="button is-success" @click="login(username, password)">Login</button>
            </div>
            
            
        </div>
    </div> -->

</template>

<script lang="ts" setup>
    import { Ref, ref } from 'vue';
    import { useSignIn } from './_store/signInStore';
    const store = useSignIn()
    
    const form:Ref<Boolean> = ref(false)
    const username:Ref<String> = ref("")
    const password:Ref<String> = ref("")

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

