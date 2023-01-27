<template>
    <div class="bg-white p-4 rounded-lg shadow animate-fade-in-down">
        <div class="flex justify-between border-b-2 pb-3">
            <div class="flex items-center">
                <span class="whitespace-nowrap mr-3">Por página</span>
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
                       placeholder="Búsqueda..."
                       class=" border-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            </div>
        </div>
        <LoadingSpiner v-if="products.loading" class="mt-8 justify-center"/>
        <template v-else>
           <table class="table-auto w-full">
                <thead>
                <tr>
                    <TableHead @orderProductsBy="sortProducts" field="id" :order="order" :sortBy="sortBy">Id</TableHead>
                    <TableHead field="" :order="order" :sortBy="sortBy">Imagen</TableHead>
                    <TableHead @orderProductsBy="sortProducts" field="title" :order="order" :sortBy="sortBy">Titulo</TableHead>
                    <TableHead @orderProductsBy="sortProducts" field="price" :order="order" :sortBy="sortBy">Precio</TableHead>
                    <TableHead :order="order" :sortBy="sortBy">Fuera de Stock</TableHead>
                    <TableHead @orderProductsBy="sortProducts" field="updated_at" :order="order" :sortBy="sortBy">Fecha de creación</TableHead>
                    <TableHead :order="order" :sortBy="sortBy" field=""> Acciones </TableHead>
                </tr>
                </thead>
                <tbody>
                <!--class="animate-fade-in-down"!-->
                <tr v-for="(product,index) of products.data"  :style="{'animation-delay': `${index*0.1}s`}">
                    <td class="border-b p-2">{{product.id}}</td>
                    <td class="border-b p-2">
                        <img class="w-24 h-24 object-cover" :src="product.image_url" :alt="product.title">
                    </td>
                    <td class="border-b p-2 max-w-[250px] whitespace-nowrap overflow-hidden text-ellipsis">{{ product.title }}</td>
                    <td class="border-b p-2">{{product.price}} €</td>
                    <td class="border-b p-2"><span class="text-white py-1 px-2 rounded " :class="product.show_catalogue ? 'bg-emerald-400' : 'bg-red-400'">{{!product.show_catalogue ? 'Retirado del catálogo' : 'Disponible'}}</span></td>
                    <td class="border-b p-2">{{product.created_at}}</td>

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
                                    class="absolute right-0 mt-2 w-40 origin-top-right divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                                >
                                    <div class="px-1 py-1">
                                        <MenuItem v-slot="{ active }">
                                            <button
                                                :class="[
                        active ? 'bg-indigo-600 text-white' : 'text-gray-900',
                        'group flex w-full items-center rounded-md px-2 py-2 text-sm',
                      ]"
                                                @click="editProduct(product)"
                                            >
                                                <PencilSquareIcon
                                                    :active="active"
                                                    class="mr-2 h-5 w-5 text-indigo-400"
                                                    aria-hidden="true"
                                                />
                                                Editar
                                            </button>
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
                                                {{product.show_catalogue ? 'Retirar' : 'Reponer'}}
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
                    Mostrando del {{ products.from }} al {{ products.to }}
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
import {ArrowDownIcon, TrashIcon , PencilSquareIcon,EllipsisVerticalIcon} from "@heroicons/vue/20/solid/index.js";
import LoadingSpiner from "../../components/core/loadingSpiner.vue";
import {computed, onMounted, ref} from "vue";
import store from "../../store/index.js";
import {PRODUCTS_PER_PAGE} from "../../constants.js";
import TableHead from "../../components/Table/TableHead.vue";
import { Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue'



const perPage = ref(PRODUCTS_PER_PAGE);
const search = ref('');
const products = computed(()=> store.state.products);
const sortBy = ref('updated_at');
const order = ref('desc');
const emit = defineEmits(['clickEdit']);

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
function deleteProduct(product)
{
    if(!confirm('Estas seguro de retirar/reponer el producto : ' + product.title)){
        return
    }
    store.dispatch('deleteProduct',product.id).then((response) => {
        getProducts();
        if(response.data.productoModificado.show_catalogue)
        store.commit('showToast',['Producto Repuesto del catálogo correctamente' , 'success'])
        else
        store.commit('showToast',['Producto Retirado del catálogo correctamente' , 'success'])
    });
}
function editProduct(product){
    emit('clickEdit',product);
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
