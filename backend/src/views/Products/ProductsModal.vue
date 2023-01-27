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
                                <DialogTitle>{{product.id ? `Editar producto : "${props.product.title}" ` : 'Nuevo producto'}}</DialogTitle>
                                <button @click="closeModal"><XMarkIcon class="float-right w-6"/></button>
                            </header>
                            <form v-if="!loading" @submit.prevent="onSubmit">
                                <div class="bg-white px-4 pt-5 pb-4">
                                    <CustomInput :required="true" class="mb-2" v-model="product.title" label="Título"/>
                                    <CustomInput  type="file" class="mb-2" label="Imagen " @change="file => product.image = file"/>
                                    <CustomInput :required="true" type="textarea" class="mb-2" v-model="product.description" label="Descripción"/>
                                    <CustomInput :min="0" :required="true" type="number" class="mb-2" v-model="product.price" label="Precio" prepend="$"/>
                                </div>
                                <footer class="px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                    <button type="submit"
                                            class="text-white mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm
                                                    bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500">
                                            {{product.id ? 'Editar' : 'Añadir'}}
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
import router from "../../router/index.js";

const props = defineProps({
    modelValue:Boolean,
    product:{
        required:true,
        type:Object
    }
})
const product = ref({
    id : props.product.id,
    price : props.product.price,
    image : props.product.image,
    description : props.product.description,
    title : props.product.title,
});

const loading = ref(false);
const emit = defineEmits(['update:modelValue', 'close']);

const isOpen=computed({
    get : () => props.modelValue,
    set : (value)=> emit("update:modelValue",value),
})
onUpdated(() => {
    product.value = {
        id : props.product.id,
        price : props.product.price,
        image : props.product.image,
        description : props.product.description,
        title : props.product.title,
    };
})
function onSubmit(){
    loading.value=true;
    if(product.value.id){
        store.dispatch('updateProduct',product.value).then(resp =>{
            loading.value=false;
            if(resp.status == 200){
                //TODO showNotification
                store.dispatch('getProducts');
                closeModal();
                emit('close');
            }
        }).catch(error => {
            //TODO showNotification
            console.log(error);
        });
    }
    else
    {
        store.dispatch('createProduct',product.value).then(response => {
            loading.value=false;
            if(response.status == 201){
                console.log("okey");
                //TODO showNotification
                store.dispatch('getProducts');
                closeModal();
                emit('close');
            }
        }).catch(error => {
            //TODO showNotification
            console.log(error);
        });

    }
    store.dispatch('getproducts');
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
