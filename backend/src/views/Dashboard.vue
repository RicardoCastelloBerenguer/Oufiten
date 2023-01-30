<template>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-5">

        <div class="animate-fade-in-down bg-white flex items-center flex-col justify-center py-6 px-4 rounded-lg shadow-lg">

            <template v-if="!loading.activeClientsCount">
                <label class="font-semibold">Clientes Activos</label>
                <span class="text-3xl">{{ activeClientsCount }}</span>
            </template>
            <template v-else>
                <LoadingSpiner text='' class="h-16"/>
            </template>

        </div>

        <div class="animate-fade-in-down bg-white flex items-center flex-col justify-center py-6 px-4 rounded-lg shadow-lg" style="animation-delay: 0.1s">

            <template v-if="!loading.productsCount">
                <label class="font-semibold">Productos en el catálogo</label>
                <span class="text-3xl">{{ productsCount }}</span>
            </template>
            <template v-else>
                <LoadingSpiner text='' class="h-16"/>
            </template>

        </div>

        <div class="animate-fade-in-down bg-white flex items-center flex-col justify-center py-6 px-4 rounded-lg shadow-lg" style="animation-delay: 0.2s">

            <template v-if="!loading.ordersPaidCount">
                <label class="font-semibold">Pedidos Pagados</label>
                <span class="text-3xl">{{ ordersPaidCount }}</span>
            </template>
            <template v-else>
                <LoadingSpiner text='' class="h-16"/>
            </template>

        </div>

        <div class="animate-fade-in-down bg-white flex items-center flex-col justify-center py-6 px-4 rounded-lg shadow-lg" style="animation-delay: 0.3s">

            <template v-if="!loading.totalProfit">
                <label class="font-semibold">Beneficio total</label>
                <span class="text-3xl">{{ totalProfit }}</span>
            </template>
            <template v-else>
                <LoadingSpiner text='' class="h-16"/>
            </template>

        </div>
    </div>


    <div class="grid grid-cols-1 md:grid-flow-col grid-rows-2 md:grid-cols-3 md:grid-rows-2 gap-4">

        

        <div class="col-span-2 md:col-span-1 bg-white flex items-center flex-col justify-center py-6 px-4 rounded-lg shadow-lg">
            <template v-if="!loading.ordersByCountry">
                <label class="font-semibold mb-4">Pedidos por país</label>
                <DoughnutChart :width="140" :height="200" :data="ordersByCountry"/>
            </template>
            <template v-else>
                <LoadingSpiner text=''/>
            </template>
        </div>

        <div class="col-span-2 md:col-span-1 bg-white py-6 px-5 rounded-lg shadow-lg">
            <template v-if="!loading.ordersByCountry">

                <div class="flex mb-5">
                    <label class="font-semibold">Últimos clientes</label>
                </div>
                <router-link :to="{name: 'app.customers.view', params:{id:customer.id}}" v-for="customer of latestCustomers" class="flex mb-5" :key="customer.id">
                    <div class="w-12 h-12 flex items-center justify-center rounded-full bg-gray-200 ">
                        <UserCircleIcon class="w-5"/>
                    </div>
                    <div>
                        <h3>{{customer.first_name}} {{customer.last_name ? customer.last_name : ''}}</h3>
                        <p>{{customer.email}}</p>
                    </div>

                </router-link>
            </template>
            <template v-else>
                <LoadingSpiner text=''/>
            </template>
        </div>

    </div>
</template>

<script setup>
import { Chart as ChartJS, ArcElement, Tooltip, Legend } from 'chart.js'
import DoughnutChart from '../components/core/Charts/Doughnut.vue'
import axiosClient from "../axios.js";
import {onMounted, ref} from "vue";
import LoadingSpiner from "../components/core/loadingSpiner.vue";
import {UserCircleIcon} from "@heroicons/vue/24/outline";
import TableHead from "../components/Table/TableHead.vue";
import OrderStatus from "./Orders/OrderStatus.vue";


ChartJS.register(ArcElement, Tooltip, Legend)



const loading = ref({
    ordersByCountry : true,
    activeClientsCount : true,
    productsCount : true,
    ordersPaidCount : true,
    totalProfit : true,
    latestCustomers:true,
    latestOrders:true,
})
const ordersByCountry = ref([]);
const activeClientsCount = ref(0);
const productsCount = ref(0);
const ordersPaidCount = ref(0);
const latestCustomers = ref([]);
const totalProfit = ref(0);
const latestOrders = ref([]);



onMounted(() => {
    axiosClient.get('/dashboard/customers-count').then(({data}) => {
        activeClientsCount.value=data;
        loading.value.activeClientsCount=false;
    })
    axiosClient.get('/dashboard/products-count').then(({data}) => {
        productsCount.value=data;
        loading.value.productsCount=false;
    })
    axiosClient.get('/dashboard/orders-paid-count').then(({data}) => {
        ordersPaidCount.value=data;
        loading.value.ordersPaidCount=false;
    })
    axiosClient.get('/dashboard/total-profit').then(({data}) => {
        totalProfit.value=(new Intl.NumberFormat('de-DE', { style: 'currency', currency: 'EUR' }).format(data));
        loading.value.totalProfit=false;
    })
    axiosClient.get('/dashboard/orders-by-country').then(({data:countries}) => {
        const doughnutData = {
            labels: [],
            datasets: [{
                backgroundColor: ['#41B883', '#E46651', '#00D8FF', '#DD1B16'],
                data: []
            }]
        }

        countries.forEach(country => {
            doughnutData.labels.push(country.name);
            doughnutData.datasets[0].data.push(country.count);
        })
        ordersByCountry.value=doughnutData;
        loading.value.ordersByCountry=false;
    })
    axiosClient.get('/dashboard/latest-customers').then(({data : customers}) => {
        latestCustomers.value=customers;
        loading.value.latestCustomers=false;
    })
    axiosClient.get('/dashboard/latest-orders').then(({data : orders}) => {
        latestOrders.value=orders.data;
        loading.value.latestOrders=false;
    })
})

</script>

<style scoped>

</style>
