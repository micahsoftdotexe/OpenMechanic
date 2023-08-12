<template>
    <div class="flex justify-content-center" style="width: 100%;">
        <Card style="width: 50%">
            <template #header>
                <h3>Sign In</h3>
            </template>
            <template #content>
                <div class="flex justify-content-center">
                    <form v-focustrap @submit.prevent="login()">
                        <div class="field">
                            <div class="p-float-label">
                                <InputText id="username" v-model="username" type="text" placeholder="Username" autofocus />
                                <label for="username">Username</label>
                            </div>
                        </div>
                        <div class="field">
                            <div class="p-float-label">
                                <Password v-model="password" :feedback="false">
                                    <template #header>
                                        <h6>Enter Password</h6>
                                    </template>
                                </Password>
                                <label for="password">Password</label>
                            </div>
                        </div>
                        <Button type="submit" label="Submit" class="mt-2"/>
                    </form>
                </div>
            </template>
        </Card>
    </div>
   
    <!-- <v-card>

    </v-card> -->
    <!-- <v-card fluid>
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
    </v-card> -->
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
    import InputText from 'primevue/inputtext';
    import Password from 'primevue/password';
    import Button from 'primevue/button';
    import Card from 'primevue/card';
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

