<template>
    <div class="flex items-center justify-between mb-3 " >
        <h1 class="text-3xl font semibold">Orders</h1>
    </div>
    <!--<ProductsModal @close="clearData" v-model="showModal" :product="productModel" />!-->
    <OrdersTable @clickView="viewOrder"/>


</template>

<script setup>

import {computed, ref} from "vue";
import store from "../../store/index.js";
import OrdersTable from "./OrdersTable.vue";

function showOrder(){

}

</script>



<style scoped>

</style>
