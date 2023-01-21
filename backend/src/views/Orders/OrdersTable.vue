<template>
    <div class="bg-white p-4 rounded-lg shadow animate-fade-in-down">
        <div class="flex justify-between border-b-2 pb-3">
            <div class="flex items-center">
                <span class="whitespace-nowrap mr-3">Per Page</span>
                <select @change="getOrders(null)" v-model="perPage"
                        class="appaerance-none relative block w-24 px-3 py-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">">
                    <option selected value="5" >5</option>
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="30">30</option>
                    <option value="50">50</option>
                </select>
            </div>
            <div>
                <input v-model="search" @change="getOrders(null)"
                       placeholder="Type to Search..."
                       class=" border-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            </div>
        </div>
        <LoadingSpiner v-if="orders.loading" class="mt-8 justify-center"/>
        <template v-else>
            <table class="table-auto w-full">
                <thead>
                <tr>
                    <TableHead @orderProductsBy="sortProducts" field="id" :order="order" :sortBy="sortBy">Id</TableHead>
                    <TableHead @orderProductsBy="sortProducts" field="total_price" :order="order" :sortBy="sortBy">Precio Total</TableHead>
                    <TableHead @orderProductsBy="sortProducts" field="created_at" :order="order" :sortBy="sortBy">Hora del Pedido</TableHead>
                    <TableHead :order="order" :sortBy="sortBy">Estado</TableHead>
                    <TableHead :order="order" :sortBy="sortBy">Cliente</TableHead>
                    <TableHead :order="order" :sortBy="sortBy" field=""> Acciones </TableHead>
                </tr>
                </thead>
                <tbody>
                <!--class="animate-fade-in-down"!-->
                <tr v-for="(order,index) of orders.data"  :style="{'animation-delay': `${index*0.1}s`}">
                    <td class="border-b p-2">{{order.id}}</td>
                    <td class="border-b p-2">{{order.total_price}}</td>
                    <td class="border-b p-2">{{order.updated_at}}</td>
                    <td class="border-b p-2" ><span :class="order.status == 'paid' ? 'bg-green-300' : 'bg-gray-300'">{{order.status}}</span></td>
                    <td class="border-b p-2" >{{order.user.name}}</td>
                    <td class="border-b p-2">
                        <Menu as="div" class="relative inline-block text-left">
                            <div>
                                <div>
                                    <MenuButton
                                        class="inline-flex items-center justify-center w-full justify-center rounded-full w-10 h-10 bg-black bg-opacity-0 text-sm font-medium text-white hover:bg-opacity-5 focus:bg-opacity-5 focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-opacity-75"
                                    >
                                        <EllipsisVerticalIcon
                                            class="h-5 w-5 text-indigo-500"
                                            aria-hidden="true"/>
                                    </MenuButton>
                                </div>
                            </div>

                            <transition
                                enter-active-class="transition duration-100 ease-out"
                                enter-from-class="transform scale-95 opacity-0"
                                enter-to-class="transform scale-100 opacity-100"
                                leave-active-class="transition duration-75 ease-in"
                                leave-from-class="transform scale-100 opacity-100"
                                leave-to-class="transform scale-95 opacity-0"
                            >
                                <MenuItems
                                    class="absolute right-0 mt-2 w-32 origin-top-right divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                                >
                                    <div class="px-1 py-1">
                                        <MenuItem v-slot="{ active }">

                                            <router-link :to="{name: 'app.orders.view', params:{id:order.id}}" :class="[
                        active ? 'bg-indigo-600 text-white' : 'text-gray-900',
                        'group flex w-full items-center rounded-md px-2 py-2 text-sm',
                      ]"><EyeIcon
                                                :active="active"
                                                class="mr-2 h-5 w-5 text-indigo-400"
                                                aria-hidden="true"
                                            />
                                                Ver Detalles</router-link>
                                        </MenuItem>
                                        <MenuItem v-slot="{ active }">
                                            <button
                                                :class="[
                        active ? 'bg-indigo-600 text-white' : 'text-gray-900',
                        'group flex w-full items-center rounded-md px-2 py-2 text-sm',
                      ]"
                                                @click="deleteProduct(product)"
                                            >
                                                <TrashIcon
                                                    :active="active"
                                                    class="mr-2 h-5 w-5 text-indigo-400"
                                                    aria-hidden="true"
                                                />
                                                Delete
                                            </button>
                                        </MenuItem>
                                    </div>
                                </MenuItems>
                            </transition>
                        </Menu>
                    </td>
                </tr>
                </tbody>
            </table>
            <div class="flex justify-between items-center mt-5">
                <span>
                    Showing from {{ orders.from }} to {{ orders.to }}
                </span>
                <nav
                    v-if="orders.total > orders.limit"
                    class="relative z-0 inline-flex justify-center rounded-md shadow-sm -space-x-px"
                    aria-label="Pagination"
                >

                    <a
                        v-for="(link, i) of orders.links"
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
                              i === orders.links.length - 1 ? 'rounded-r-md' : '',
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
import {ArrowDownIcon, TrashIcon , PencilSquareIcon,EllipsisVerticalIcon,EyeIcon} from "@heroicons/vue/20/solid/index.js";
import LoadingSpiner from "../../components/core/loadingSpiner.vue";
import {computed, onMounted, ref} from "vue";
import store from "../../store/index.js";
import {PRODUCTS_PER_PAGE} from "../../constants.js";
import TableHead from "../../components/Table/TableHead.vue";
import { Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue'



const perPage = ref(PRODUCTS_PER_PAGE);
const search = ref('');
const orders = computed(()=> store.state.orders);
const sortBy = ref('updated_at');
const order = ref('desc');
const emit = defineEmits(['clickEdit']);

onMounted(()=>{
    getOrders();
})

function getOrders(url = null)
{
    store.dispatch('getOrders' , {
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
    getOrders(linkPage.url);
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

    getOrders();
}


</script>



<style scoped>

</style>
