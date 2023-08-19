<template>
    <div class="flex justify-center items-center h-screen">
        <form
            @submit="login"
         >
            <div class="form-control w-full max-w-xs">
                <label class="label">
                    <span class="label-text">Username</span>
                </label>
                <input v-model="username" type="text" placeholder="username" class="input input-bordered w-full max-w-xs"/>
            </div>
            <div class="form-control w-full max-w-xs">
                <label class="label">
                    <span class="label-text">Password</span>
                </label>
                <input v-model="password" placeholder="password" type="password" class="input input-bordered w-full max-w-xs"/>
            </div>
            <button type="submit" class="btn btn-active btn-primary">Submit</button>


        </form>
    </div>
    

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

