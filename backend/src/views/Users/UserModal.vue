<template>
    <TransitionRoot appear :show="isOpen" as="template">
        <Dialog as="div" @close="closeModal" class="relative z-10">
            <TransitionChild
                as="template"
                enter="duration-300 ease-out"
                enter-from="opacity-0"
                enter-to="opacity-100"
                leave="duration-200 ease-in"
                leave-from="opacity-100"
                leave-to="opacity-0"
            >
                <div class="fixed inset-0 bg-black bg-opacity-25" />
            </TransitionChild>

            <div class="fixed inset-0 overflow-y-auto">
                <div
                    class="flex min-h-full items-center justify-center p-4 text-center"
                >
                    <TransitionChild
                        as="template"
                        enter="duration-300 ease-out"
                        enter-from="opacity-0 scale-95"
                        enter-to="opacity-100 scale-100"
                        leave="duration-200 ease-in"
                        leave-from="opacity-100 scale-100"
                        leave-to="opacity-0 scale-95"
                    >
                        <DialogPanel
                            class="w-full max-w-md transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all"
                        >
                            <LoadingSpiner v-if="loading" class="mt-8 justify-center"/>
                            <header v-if="!loading" class="py-3 px-4 flex justify-between items-center">
                                <DialogTitle>{{user.id ? `Actualizar usuario : "${props.user.name}" ` : 'Nuevo usuario'}}</DialogTitle>
                                <button @click="closeModal"><XMarkIcon class="float-right w-6"/></button>
                            </header>
                            <div>
                                <p class="bg-red-600" v-for="error in errors">{{errormsg}}</p>
                            </div>

                            <form v-if="!loading" @submit.prevent="onSubmit">
                                <div class="bg-white px-4 pt-5 pb-4">
                                    <CustomInput :required="true" class="mb-2" v-model="user.name" label="Nombre"/>
                                    <CustomInput :required="true" type="email" class="mb-2" v-model="user.email" label="Email"/>
                                    <CustomInput :minlength="8" type="password" class="mb-2" v-model="user.password" label="Contraseña"/>
                                </div>
                                <footer class="px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                    <button type="submit"
                                            class="text-white mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm
                                                    bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500">
                                        {{ user.id ? 'Editar' : 'Añadir' }}
                                    </button>
                                    <button type="button"
                                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                                            @click="closeModal" ref="cancelButtonRef">
                                        Cancelar
                                    </button>
                                </footer>
                            </form>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<script setup>
import {computed, onUpdated, ref} from 'vue'
import {
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogPanel,
    DialogTitle,
} from '@headlessui/vue'

import {XMarkIcon} from "@heroicons/vue/20/solid";
import LoadingSpiner from "../../components/core/loadingSpiner.vue";
import store from "../../store/index.js";
import CustomInput from "../../components/core/CustomInput.vue";


const order = ref('desc');
const errors = ref([]);
import router from "../../router/index.js";

const props = defineProps({
    modelValue:Boolean,
    user:{
        required:true,
        type:Object
    }
})
const user = ref({
    id : props.user.id,
    name : props.user.name,
    email : props.user.email,
});

const loading = ref(false);
const emit = defineEmits(['update:modelValue', 'close']);

const isOpen=computed({
    get : () => props.modelValue,
    set : (value)=> emit("update:modelValue",value),
})
onUpdated(() => {
    user.value = {
        id : props.user.id,
        name : props.user.name,
        email : props.user.email,
    };
})
function onSubmit(){
    loading.value=true;
    if(user.value.id){
        store.dispatch('updateUser',user.value).then(resp =>{
            if(resp.status == 200){
                store.commit('showToast',['El usuario ha sido editado correctamente' , 'success'])
                store.dispatch('getUsers');
                loading.value=false;
                closeModal();
                emit('close');
            }
        }).catch(error => {
            console.log(error);
            store.commit('showToast',['A ocurrido un error al actualizar el cliente con id : ' + user.value.id,'error']);
            store.dispatch('getUsers');
            loading.value=false;
            closeModal();
            emit('close');
        });
    }
    else
    {
        store.dispatch('createUser',user.value).then(response => {
            if(response.status >= 200 && response.status <= 300){
                loading.value=false;
                store.commit('showToast',['El usuario ha sido creado correctamente' , 'success'])
                store.dispatch('getUsers');
                closeModal();
                emit('close');
            }
        }).catch(error => {
            //TODO
            console.log(error.response.data.errors);
            store.commit('showToast',['Ha ocurrido un error al crear el cliente ','error']);
            store.dispatch('getUsers');
            loading.value=false;
            console.log(error);
        });
    }
}

function closeModal() {
    isOpen.value = false
    emit('close');
}
function check()
{
    console.log(isOpen.value);
}
function openModal() {
    isOpen.value = true
}
</script>
