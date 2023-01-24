<template>
    <div class="flex items-center justify-between mb-3 " >
        <h1 class="text-3xl font semibold">Productos</h1>
        <button @click="showProductModal" class="flex justify-center bg-indigo-600 hover:bg-indigo-400 text-white font-bold py-2 px-4 rounded"
                type="submit">
            Añadir nuevo producto
        </button>
    </div>

    <ProductsModal @close="clearData" v-model="showModal" :product="productModel" />
    <ProductsTable @clickEdit="editProduct"/>


</template>

<script setup>

import ProductsTable from "./ProductsTable.vue";
import ProductsModal from "./ProductsModal.vue";
import {ref} from "vue";
import store from "../../store/index.js";

const DEFAULT_EMPTY_MODEL_PRODUCT = {
    id:'',
    title:'',
    image:'',
    price:'',
    description:'',
}

const showModal = ref(false);
const productModel = ref({...DEFAULT_EMPTY_MODEL_PRODUCT});

function showProductModal(){
    showModal.value=true;
}
function editProduct(product){
    store.dispatch('getProduct',product.id).then((productToEdit) => {
        productModel.value=productToEdit.data;
        showProductModal();
    });
}
function clearData(){
    productModel.value ={...DEFAULT_EMPTY_MODEL_PRODUCT};
}
</script>



<style scoped>

</style>
