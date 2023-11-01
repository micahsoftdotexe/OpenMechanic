<template>
    

    <div class="flex align-items-center justify-content-center">
        <form @submit.prevent="login" class="surface-card p-4 shadow-2 border-round w-full lg:w-6">
            <div class="text-center mb-5">
               
                <div class="text-900 text-3xl font-medium mb-3">Welcome Back</div>
                <span class="text-600 font-medium line-height-3">Don't have an account?</span>
                <a class="font-medium no-underline ml-2 text-blue-500 cursor-pointer">Create today!</a>
            </div>

            <div>
                <label for="email1" class="block text-900 font-medium mb-2">Email</label>
                            <InputText v-model="username" id="email1" styleClass="w-full mb-3" placeholder="Email address"/>
                            <label for="password1" class="block text-900 font-medium mb-2">Password</label>
                            <InputText v-model="password" id="password1" type="password" styleClass="w-full mb-3" placeholder="Password"/>
                <Button type="submit" value="Sign In" icon="pi pi-user" styleClass="w-full"/>
            </div>
        </form>
    </div>



    

</template>

<script lang="ts" setup>
    import { Ref, ref } from 'vue';
    import { useSignIn } from './_store/signInStore';
    import InputText from 'primevue/inputtext';
    import Button from 'primevue/button';

    const store = useSignIn()
    
    const form:Ref<Boolean> = ref(false)
    const username:Ref<string> = ref("")
    const password:Ref<string> = ref("")

    async function login(){
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

