<template>
    <div class="bg-white p-4 rounded-lg shadow animate-fade-in-down">
        <div class="flex justify-between border-b-2 pb-3">
            <div class="flex items-center">
                <span class="whitespace-nowrap mr-3">Por página</span>
                <select @change="getCustomers(null)" v-model="perPage"
                        class="appaerance-none relative block w-24 px-3 py-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">">
                    <option selected value="5" >5</option>
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="30">30</option>
                    <option value="50">50</option>
                </select>
            </div>
            <div>
                <input v-model="search" @change="getCustomers(null)"
                       placeholder="Búsqueda..."
                       class=" border-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            </div>
        </div>
        <LoadingSpiner v-if="customers.loading" class="mt-8 justify-center"/>
        <template v-else>
            <table class="table-auto w-full">
                <thead>
                <tr>
                    <TableHead @orderProductsBy="sortCustomers" field="user_id" :order="order" :sortBy="sortBy">Id</TableHead>
                    <TableHead @orderProductsBy="sortCustomers" field="first_name" :order="order" :sortBy="sortBy">Nombre</TableHead>
                    <TableHead @orderProductsBy="sortCustomers" field="last_name" :order="order" :sortBy="sortBy">Apellido</TableHead>
                    <TableHead @orderProductsBy="sortCustomers" field="phone" :order="order" :sortBy="sortBy">Teléfono</TableHead>
                    <TableHead @orderProductsBy="sortCustomers" field="created_at" :order="order" :sortBy="sortBy">Fecha de creación</TableHead>
                    <TableHead :order="order" :sortBy="sortBy" field=""> Acción </TableHead>
                </tr>
                </thead>
                <tbody>
                <!--class="animate-fade-in-down"!-->
                <tr v-for="(customer,index) of customers.data"  :style="{'animation-delay': `${index*0.1}s`}">
                    <td class="border-b p-2">{{customer.id}}</td>
                    <td class="border-b p-2 max-w-[250px] whitespace-nowrap overflow-hidden text-ellipsis">{{ customer.first_name }}</td>
                    <td class="border-b p-2">{{customer.last_name}}</td>
                    <td class="border-b p-2">{{customer.phone}}</td>
                    <td class="border-b p-2">{{customer.created_at}}</td>
                    <td class="border-b p-2">
                        <router-link :to="{name: 'app.customers.view', params:{id:customer.id}}" :class="[
                        active ? 'bg-indigo-600 text-white' : 'text-gray-900',
                        'group flex w-full items-center rounded-md px-2 py-2 text-sm',
                      ]"><PencilSquareIcon
                            :active="active"
                            class="mr-2 h-5 w-5 text-indigo-400 transition ease-in-out delay-10 rounded-full hover:border-2 hover:border-spacing-2.5 border-indigo-400 border-solid hover:scale-110 duration-300"
                            aria-hidden="true"
                        /></router-link>
                    </td>
                </tr>
                </tbody>
            </table>
            <div class="flex justify-between items-center mt-5">
                <span>
                    Mostrando del {{ customers.from }} al {{ customers.to }}
                </span>
                <nav
                    v-if="customers.total > customers.limit"
                    class="relative z-0 inline-flex justify-center rounded-md shadow-sm -space-x-px"
                    aria-label="Pagination"
                >

                    <a
                        v-for="(link, i) of customers.links"
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
                              i === customers.links.length - 1 ? 'rounded-r-md' : '',
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
import {ArrowDownIcon, TrashIcon , PencilSquareIcon,EllipsisVerticalIcon} from "@heroicons/vue/20/solid/index.js";
import LoadingSpiner from "../../components/core/loadingSpiner.vue";
import {computed, onMounted, ref} from "vue";
import store from "../../store/index.js";
import {CUSTOMERS_PER_PAGE} from "../../constants.js";
import TableHead from "../../components/Table/TableHead.vue";
import { Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue'



const perPage = ref(CUSTOMERS_PER_PAGE);
const search = ref('');
const customers = computed(()=> store.state.customers);
const sortBy = ref('updated_at');
const order = ref('desc');
const emit = defineEmits(['clickEdit']);

onMounted(()=>{
    getCustomers();
})

function getCustomers(url = null)
{
    store.dispatch('getCustomers' , {
        url,
        search:search.value,
        perPage:perPage.value,
        sortBy : sortBy.value,
        order : order.value
    });
}
function deleteCustomer(customer)
{
    if(!confirm('You want to delete this customer')){
        return
    }
    store.dispatch('deleteCustomer',customer.id).then((response) => {
        getCustomers();
    });
}
function editCustomer(customer){
    emit('clickEdit',customer);
}
function getForPage(event , linkPage){
    if(!linkPage.url || linkPage.active)
    {
        return
    }
    getCustomers(linkPage.url);
}
function sortCustomers(field)
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

    getCustomers();
}

</script>



<style scoped>

</style>
