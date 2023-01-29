
<template>

    <GuestLayout title="Inicia sesión con tu cuenta">
    <form class="mt-8 space-y-6"  method="POST" @submit.prevent="login">
        <div v-if="errorMsg" class="flex items-center justify-between py-3 px-4 bg-red-500 text-white rounded">
            {{errorMsg}}
            <span @click="unloadError" class="w-6 h-6 ml-2 mt-1 text-white flex rounded-full items-center justify-center transition-colors cursor-pointer hover:bg-black/20">
            <XMarkIcon/>
        </span>

        </div>
        <input type="hidden" name="remember" value="true" />
        <div class="-space-y-px rounded-md shadow-sm">
            <div>
                <label for="email-address" class="sr-only">Correo Electrónico</label>
                <input id="email-address" name="email" type="email" autocomplete="email" required="" v-model="user.email"
                class="relative block w-full appearance-none rounded-none rounded-t-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
                placeholder="Correo Electrónico" />
            </div>
            <div>
                <label for="password" class="sr-only">Contraseña</label>
                <input id="password" name="password" type="password" autocomplete="current-password" required="" v-model="user.password"
                class="relative block w-full appearance-none rounded-none rounded-b-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm" placeholder="Contraseña" />
            </div>
        </div>

        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <input id="remember-me" name="remember-me" type="checkbox" v-model="user.remember"
                class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />
                <label for="remember-me" class="ml-2 block text-sm text-gray-900">Recuérdame</label>
            </div>
        </div>

        <div>
            <button type="submit"
                    :disabled="loading"
                    :class="{
                        'cursor-not-allowed':loading,
                        'hover:bg-indigo-500' : loading
                        }"
                    class="group relative flex w-full justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                <svg v-if="loading" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Iniciar sesión
    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
      <LockClosedIcon class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400" aria-hidden="true" />
    </span>
        </button>
        </div>
    </form>
    </GuestLayout>

</template>

<script setup>
import { LockClosedIcon,XMarkIcon } from '@heroicons/vue/20/solid'
import GuestLayout from "../components/GuestLayout.vue";
import {ref} from "vue";
import store from "../store/index.js";
import router from "../router/index.js";


const user = {
    email : '',
    password : '',
    remember : false
}

let loading = ref(false);
let errorMsg = ref("");

function login(){
    loading.value=true;
    store.dispatch('login' , user).then(() => {
        loading.value=false;
        router.push({name:'app.dashboard'})
    })
    .catch((error)=> {
        loading.value=false;
        errorMsg= error.response.data.message;
    })
}
function unloadError()
{
    console.log(errorMsg);
    errorMsg='';
}


</script>

<style scoped>

</style>
