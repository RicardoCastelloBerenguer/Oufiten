<template>

    <div class="py-14 px-4 md:px-6 2xl:px-20 2xl:container 2xl:mx-auto">
        <!--- more free and premium Tailwind CSS components at https://tailwinduikit.com/ --->

        <div class="flex justify-start item-start space-y-2 flex-col">
            <h1 class="text-3xl dark:text-white lg:text-4xl font-semibold leading-7 lg:leading-9 text-gray-800">Pedido {{order.id}}</h1>
            <p class="text-base dark:text-gray-300 font-medium leading-6 text-gray-600">{{order.created_at}}</p>
        </div>
        <div class="mt-10 flex flex-col xl:flex-row jusitfy-center items-stretch w-full xl:space-x-8 space-y-4 md:space-y-6 xl:space-y-0">
            <div class="flex flex-col justify-start items-start w-full space-y-4 md:space-y-6 xl:space-y-8">
                <div class="flex flex-col justify-start items-start dark:bg-gray-800 bg-gray-50 px-4 py-4 md:py-6 md:p-6 xl:p-8 w-full">
                    <p class="text-lg md:text-xl dark:text-white font-semibold leading-6 xl:leading-5 text-gray-800">Carrito del Pedido</p>
                    <div v-for="item of order.order_items" class="mt-4 md:mt-6 flex flex-col md:flex-row justify-start items-start md:items-center md:space-x-6 xl:space-x-8 w-full">
                        <div class="pb-4 md:pb-8 w-full md:w-40">
                            <img class="w-full hidden md:block" :src="item.product.image_url" :alt="item.product.title">
                            <img class="w-full md:hidden" :src="item.product.image_url" :alt="item.product.title" />
                        </div>
                        <div class="border-b border-gray-200 md:flex-row flex-col flex justify-between items-start w-full pb-8 space-y-4 md:space-y-0">
                            <div class="w-full flex flex-col justify-start items-start space-y-8">
                                <h3 class="text-xl dark:text-white xl:text-2xl font-semibold leading-6 text-gray-800">
                                    {{ item.product.title }}</h3>
                                <div class="flex justify-start items-start flex-col space-y-2">
                                    <p class="text-sm dark:text-white leading-none text-gray-800"><span class="dark:text-gray-400 text-gray-300">Style: </span> Italic Minimal Design</p>
                                    <p class="text-sm dark:text-white leading-none text-gray-800"><span class="dark:text-gray-400 text-gray-300">Size: </span> Small</p>
                                    <p class="text-sm dark:text-white leading-none text-gray-800"><span class="dark:text-gray-400 text-gray-300">Color: </span> Light Blue</p>
                                </div>
                            </div>
                            <div class="flex justify-between space-x-8 items-start w-full">
                                <p class="text-base dark:text-white xl:text-lg leading-6"> {{ item.product.price }} €</p>
                                <p class="text-base dark:text-white xl:text-lg leading-6 text-gray-800">x{{ item.quantity }}</p>
                                <p class="text-base dark:text-white xl:text-lg font-semibold leading-6 text-gray-800">
                                    {{ item.quantity*item.product.price }}€</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-center flex-col md:flex-row flex-col items-stretch w-full space-y-4 md:space-y-0 md:space-x-6 xl:space-x-8">
                    <div class="flex flex-col px-4 py-6 md:p-6 xl:p-8 w-full bg-gray-50 dark:bg-gray-800 space-y-6">
                        <h3 class="text-xl dark:text-white font-semibold leading-5 text-gray-800">Resumen</h3>
                        <div class="flex justify-center items-center w-full space-y-4 flex-col border-gray-200 border-b pb-4">
                            <div class="flex justify-between w-full">
                                <p class="text-base dark:text-white leading-4 text-gray-800">SubTotal</p>
                                <p class="text-base dark:text-gray-300 leading-4 text-gray-600">{{ order.total_price }}€</p>
                            </div>
                            <div class="flex justify-between items-center w-full">
                                <p class="text-base dark:text-white leading-4 text-gray-800">Descuento <span class="bg-gray-200 p-1 text-xs font-medium dark:bg-white dark:text-gray-800 leading-3 text-gray-800">ESTUDIANTE</span></p>
                                <p class="text-base dark:text-gray-300 leading-4 text-gray-600">-0.00$(0%)</p>
                            </div>
                            <div class="flex justify-between items-center w-full">
                                <p class="text-base dark:text-white leading-4 text-gray-800">Envío</p>
                                <p class="text-base dark:text-gray-300 leading-4 text-gray-600">0.00€</p>
                            </div>
                        </div>
                        <div class="flex justify-between items-center w-full">
                            <p class="text-base dark:text-white font-semibold leading-4 text-gray-800">Total</p>
                            <p class="text-base dark:text-gray-300 font-semibold leading-4 text-gray-600">{{ order.total_price }}€</p>
                        </div>
                    </div>
                    <div class="flex flex-col justify-center px-4 py-6 md:p-6 xl:p-8 w-full bg-gray-50 dark:bg-gray-800 space-y-6">
                        <h3 class="text-xl dark:text-white font-semibold leading-5 text-gray-800">ESTADO</h3>
                        <div class="flex justify-between items-start w-full">
                            <div class="flex justify-center items-center space-x-4">

                            </div>
                        </div>

                        <div class="w-full flex justify-center items-center">
                            <select v-model="order.status" @change="onStatusChange" id="countries" class="bg-gray-50 border border-indigo-200 text-gray-900 text-sm rounded-lg focus:ring-indigo-600 focus:border-indigo-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option v-for="status of orderStatus"  :value="status">{{ status == "paid" ? 'PAGADO' : status=="unpaid" ? 'POR PAGAR' : status=="cancelled" ? 'CANCELADO' : 'COMPLETADO'  }}</option>
                            </select>
                        </div>
                        <button v-if="!loadingOrder" type="submit" @click="updateOrder" class="mt-4 hover:bg-indigo-900 dark:bg-white dark:text-white rounded-lg dark:hover:bg-indigo-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-800 py-5 w-96 md:w-full bg-indigo-600 text-base font-medium leading-4 text-white">Cambiar Estado</button>
                        <loadingSpinner v-else class="mt-8 justify-center"/>


                    </div>

                </div>
            </div>
            <div v-if="order.customer" class="bg-gray-50 dark:bg-gray-800 w-full xl:w-96 flex justify-between items-center md:items-start px-4 py-6 md:p-6 xl:p-8 flex-col">
                <h3 class="text-xl dark:text-white font-semibold leading-5 text-gray-800">Cliente</h3>
                <div class="flex flex-col md:flex-row xl:flex-col justify-start items-stretch h-full w-full md:space-x-6 lg:space-x-8 xl:space-x-0">
                    <div class="flex flex-col justify-start items-start flex-shrink-0">
                        <div class="flex justify-center w-full md:justify-start items-center space-x-4 py-8 border-b border-gray-200">
                            <img src="https://i.ibb.co/5TSg7f6/Rectangle-18.png" alt="avatar" />
                            <div class="flex justify-start items-start flex-col space-y-2">
                                <p class="text-base dark:text-white font-semibold leading-4 text-left text-gray-800">{{order.customer.first_name}} {{order.customer.last_name ?? ''}}</p>
                                <!--<p class="text-sm dark:text-gray-300 leading-5 text-gray-600">10 Previous Orders</p>!-->
                            </div>
                        </div>

                        <div class="flex justify-center text-gray-800 dark:text-white md:justify-start items-center space-x-4 py-4 border-b border-gray-200 w-full">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M19 5H5C3.89543 5 3 5.89543 3 7V17C3 18.1046 3.89543 19 5 19H19C20.1046 19 21 18.1046 21 17V7C21 5.89543 20.1046 5 19 5Z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M3 7L12 13L21 7" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <p class="cursor-pointer text-sm leading-5 ">{{ order.customer.email }}</p>
                        </div>
                        <div class="flex justify-center text-gray-800 dark:text-white md:justify-start items-center space-x-4 py-4 border-b border-gray-200 w-full">
                            <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                            </svg>
                            <p class="cursor-pointer text-sm leading-5 ">{{ order.customer.phone }}</p>
                        </div>
                    </div>
                    <div class="flex justify-between xl:h-full items-stretch w-full flex-col mt-6 md:mt-0">
                        <div class="flex justify-center md:justify-start xl:flex-col flex-col md:space-x-6 lg:space-x-8 xl:space-x-0 space-y-4 xl:space-y-12 md:space-y-0 md:flex-row items-center md:items-start">
                            <div class="flex justify-center md:justify-start items-center md:items-start flex-col space-y-4 xl:mt-8">
                                <p class="text-base dark:text-white font-semibold leading-4 text-center md:text-left text-gray-800">Dirección de envío</p>
                                <p class="w-48 lg:w-full dark:text-gray-300 xl:w-48 text-center md:text-left text-sm leading-5 text-gray-600">PAÍS : {{ order.customer.shippingAddress.country_code }}</p>
                                <p class="w-48 lg:w-full dark:text-gray-300 xl:w-48 text-center md:text-left text-sm leading-5 text-gray-600">COMUNIDA A. : {{ order.customer.shippingAddress.community }}</p>
                                <p class="w-48 lg:w-full dark:text-gray-300 xl:w-48 text-center md:text-left text-sm leading-5 text-gray-600">CIUDAD : {{ order.customer.shippingAddress.city }}</p>
                                <p class="w-48 lg:w-full dark:text-gray-300 xl:w-48 text-center md:text-left text-sm leading-5 text-gray-600">DIRECCIÓN 1 : {{ order.customer.shippingAddress.address1 }}</p>
                                <p class="w-48 lg:w-full dark:text-gray-300 xl:w-48 text-center md:text-left text-sm leading-5 text-gray-600">DIRECCIÓN 2 : {{ order.customer.shippingAddress.address2 }}</p>
                            </div>
                            <div class="flex justify-center md:justify-start items-center md:items-start flex-col space-y-4 xl:mt-8">
                                <p class="text-base dark:text-white font-semibold leading-4 text-center md:text-left text-gray-800">Dirección de facturación</p>
                                <p class="w-48 lg:w-full dark:text-gray-300 xl:w-48 text-center md:text-left text-sm leading-5 text-gray-600">PAÍS : {{ order.customer.billingAddress.country_code }}</p>
                                <p class="w-48 lg:w-full dark:text-gray-300 xl:w-48 text-center md:text-left text-sm leading-5 text-gray-600">COMUNIDA A. : {{ order.customer.billingAddress.community }}</p>
                                <p class="w-48 lg:w-full dark:text-gray-300 xl:w-48 text-center md:text-left text-sm leading-5 text-gray-600">CIUDAD : {{ order.customer.billingAddress.city }}</p>
                                <p class="w-48 lg:w-full dark:text-gray-300 xl:w-48 text-center md:text-left text-sm leading-5 text-gray-600">DIRECCIÓN 1 : {{ order.customer.billingAddress.address1 }}</p>
                                <p class="w-48 lg:w-full dark:text-gray-300 xl:w-48 text-center md:text-left text-sm leading-5 text-gray-600">DIRECCIÓN 2 : {{ order.customer.billingAddress.address2 }}</p>
                            </div>
                        </div>
                        <div  class="flex w-full justify-center items-center md:justify-start md:items-start">
                            <router-link :to="{name: 'app.customers.view', params:{id:order.customer.id}}" :class="[
                                active ? 'bg-indigo-600 text-white' : 'text-gray-900',
                                'group flex w-full items-center rounded-md px-2 py-2 text-sm',
                              ]">
                                <button class="mt-6 md:mt-0 dark:border-white dark:hover:bg-gray-900 dark:bg-transparent dark:text-white py-5 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-800 border border-gray-800 font-medium w-96 2xl:w-full text-base font-medium leading-4 text-gray-800">
                                    Editar datos</button>
                            </router-link>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script setup>


import {onMounted, ref} from "vue";
import store from "../../store/index.js";
import {useRoute} from "vue-router";
import {orderStatus} from "../../constants"
import loadingSpinner from "../../components/core/loadingSpiner.vue"
import router from "../../router/index.js";
import {data} from "autoprefixer";
import state from "../../store/state.js";

const route = useRoute();
const order = ref({});
const loadingOrder = ref(false);

onMounted(() => {
    getOrder();
})

function getOrder(){
    loadingOrder.value=true;
    store.dispatch('getOrder',route.params.id).then(response => {
        order.value = response.data
        loadingOrder.value=false;
    });
}

function onStatusChange(){

}

function updateOrder(){
    console.log(loadingOrder.value);
    loadingOrder.value=true;
    console.log(loadingOrder.value);
    store.dispatch('updateOrder',order.value).then(response => {
        if(response.status <= 300 && response.status>=200){
            //TODO showNotification
            store.dispatch('getOrder' , order.value.id);
            store.commit('showToast',['El estado del pedido se ha actualizado correctamente','success']);
            loadingOrder.value=false;
        }
    }).catch($error => {
        loadingOrder.value=false;
        store.commit('showToast',['No se ha podido actualizar el estado del pedido','error']);
        console.log($error);
    });

}
</script>

<style scoped>

</style>
