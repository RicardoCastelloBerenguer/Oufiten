<template>
    <div class="flex">
        <div class="transition-all flex flex-col p-3 bg-indigo-600 shadow w-[180px]">
            <div class="space-y-3 text-white">
                <div class="flex-1 ">
                    <ul class="pt-2 pb-4 space-y-1 text-sm">
                        <li class="rounded-sm">
                            <router-link :to="{name: 'app.dashboard'}" class="flex items-center p-2 space-x-3 rounded-md hover:bg-black/10"><HomeIcon class="w-6 h-6 mr-3"></HomeIcon> Dashboard</router-link>
                        </li>
                        <li class="rounded-sm">
                            <router-link :to="{name: 'app.products'}" class="flex items-center p-2 space-x-3 rounded-md hover:bg-black/10"><CircleStackIcon class="w-6 h-6 mr-3"></CircleStackIcon>Productos</router-link>
                        </li>
                        <li class="rounded-sm">
                            <router-link :to="{name: 'app.orders'}" class="flex items-center p-2 space-x-3 rounded-md hover:bg-black/10"><Bars4Icon class="w-6 h-6 mr-3"></Bars4Icon>Pedidos</router-link>
                        </li>
                        <li class="rounded-sm">
                            <router-link :to="{name: 'app.users'}" class="flex items-center p-2 space-x-3 rounded-md hover:bg-black/10"><UsersIcon class="w-6 h-6 mr-3"></UsersIcon>Usuarios</router-link>
                        </li>
                        <li class="rounded-sm">
                            <router-link :to="{name: 'app.customers'}" class="flex items-center p-2 space-x-3 rounded-md hover:bg-black/10"><UserGroupIcon class="w-6 h-6 mr-3"></UserGroupIcon>Clientes</router-link>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</template>

<script setup>
import{
    HomeIcon,Bars4Icon,UsersIcon,ChartBarIcon,CircleStackIcon,UserGroupIcon
} from "@heroicons/vue/24/outline";
import NavBar from "./NavBar.vue";


</script>
