<template>
    <div class="flex items-center justify-between mb-3 " >
        <h1 class="text-3xl font semibold">Products</h1>
        <button class="flex justify-center bg-indigo-600 hover:bg-indigo-400 text-white font-bold py-2 px-4 rounded"
        type="submit">
            Add new Product
        </button>
    </div>
    <div class="bg-white p-4 rounded-lg shadow">
        <div class="flex justify-between border-b-2 pb-3">
            <div class="flex items-center">
                <span class="whitespace-nowrap mr-3">Per Page</span>
                <select @change="getProducts(null)" v-model="perPage"
                        class="appaerance-none relative block w-24 px-3 py-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">">
                    <option selected value="5" >5</option>
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="30">30</option>
                    <option value="50">50</option>
                </select>
            </div>
            <div>
                <input v-model="search" @change="getProducts(null)"
                       placeholder="Type to Search..."
                       class=" border-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            </div>
        </div>
        <LoadingSpiner v-if="products.loading" class="mt-8 justify-center"/>
        <template v-else>
           <table class="table-auto w-full">
                <thead>
                <tr>
                    <TableHead @orderProductsBy="sortProducts" field="id" :order="order" :sortBy="sortBy">Id</TableHead>
                    <TableHead @orderProductsBy="sortProducts" field="" :order="order" :sortBy="sortBy">Image</TableHead>
                    <TableHead @orderProductsBy="sortProducts" field="title" :order="order" :sortBy="sortBy">Title</TableHead>
                    <TableHead @orderProductsBy="sortProducts" field="price" :order="order" :sortBy="sortBy">Price</TableHead>
                    <TableHead @orderProductsBy="sortProducts" field="updated_at" :order="order" :sortBy="sortBy">Updated At</TableHead>
                </tr>
                </thead>
                <tbody>
                <tr v-for="product of products.data">
                    <td class="border-b p-2">{{product.id}}</td>
                    <td class="border-b p-2">
                        <img class="w-20" :src="product.image" :alt="product.title">
                    </td>
                    <td class="border-b p-2 max-w-[250px] whitespace-nowrap overflow-hidden text-ellipsis">{{ product.title }}</td>
                    <td class="border-b p-2">{{product.price}}</td>
                    <td class="border-b p-2">{{product.updated_at}}</td>
                </tr>
                </tbody>
            </table>
            <div class="flex justify-between items-center mt-5">
                <span>
                    Showing from {{ products.from }} to {{ products.to }}
                </span>
                <nav
                    v-if="products.total > products.limit"
                    class="relative z-0 inline-flex justify-center rounded-md shadow-sm -space-x-px"
                    aria-label="Pagination"
                >

                    <a
                        v-for="(link, i) of products.links"
                        :key="i"
                        :disabled="!link.url"
                        href="#"
                        @click.prevent="getForPage($event, link)"
                        aria-current="page"
                        class="relative inline-flex items-center px-4 py-2 border text-sm font-medium whitespace-nowrap"
                        :class="[
                              link.active
                                ? 'z-10 bg-indigo-50 border-indigo-500 text-indigo-600'
                                : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50',
                              i === 0 ? 'rounded-l-md' : '',
                              i === products.links.length - 1 ? 'rounded-r-md' : '',
                              !link.url ? ' bg-gray-100 text-gray-700': ''
                        ]"
                        v-html="link.label"
                    >
                    </a>

                </nav>


            </div>
        </template>
    </div>


</template>

<script setup>
import {ArrowDownIcon} from "@heroicons/vue/20/solid/index.js";
import LoadingSpiner from "../../components/core/loadingSpiner.vue";
import {computed, onMounted, ref} from "vue";
import store from "../../store/index.js";
import {PRODUCTS_PER_PAGE} from "../../constants.js";
import TableHead from "../../components/Table/TableHead.vue";

const perPage = ref(PRODUCTS_PER_PAGE);
const search = ref('');
const products = computed(()=> store.state.products);
const sortBy = ref('updated_at');
const order = ref('desc');

onMounted(()=>{
    getProducts();
})

function getProducts(url = null)
{
    store.dispatch('getProducts' , {
        url,
        search:search.value,
        perPage:perPage.value,
        sortBy : sortBy.value,
        order : order.value
    });

}
function getForPage(event , linkPage){
    if(!linkPage.url || linkPage.active)
    {
        return
    }
    getProducts(linkPage.url);
}
function sortProducts(field)
{
    if(sortBy.value==field){
        if(order.value == 'asc'){
            order.value='desc';
        }
        else {
            order.value='asc';
        }
    }else{
        sortBy.value=field;
        order.value='asc';
    }

    getProducts();
}

</script>



<style scoped>

</style>
