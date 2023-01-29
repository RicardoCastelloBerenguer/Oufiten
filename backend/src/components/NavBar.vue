<template>
    <Disclosure as="nav" class="bg-white" v-slot="{ open }">
        <div class="mr-0  px-2 sm:px-6 lg:pl-2 lg:px-2 ">
            <div class="relative flex h-16 items-center justify-between">

                <div class="flex-1 items-center justify-center sm:items-stretch sm:justify-start">
                        <div class="flex flex-shrink-0 items-center">
                            <button @click="emit('toggleSidebar')" class="flex items-center justify-center h-14 pl-4 w-16 p-4 hover:bg-black/10">
                                <Bars3Icon class="block h-6 w-6" aria-hidden="true" />
                            </button>


                            <div class="hidden sm:ml-6 sm:block">
                                <div class="flex space-x-4">
                                    <!--
                                    <a v-for="item in navigation" :key="item.name" :href="item.href" :class="[item.current ? 'bg-gray-900 text-white' : 'text-black hover:bg-gray-700 hover:text-white', 'px-3 py-2 rounded-md text-sm font-medium']" :aria-current="item.current ? 'page' : undefined">{{ item.name }}</a>
                                    !-->
                                </div>
                        </div>
                </div>
            </div>
            <div class="px-4">
                <!--<button type="button" class="rounded-full bg-gray-800 p-1 text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
                    <span class="sr-only">View notifications</span>
                     <BellIcon class="h-6 w-6" aria-hidden="true" />
                </button>!-->

                <!-- Profile dropdown -->
                <Menu as="div" class="relative inline-block text-right">
                    <div>
                        <MenuButton class="flex items-center">
                            <span class="sr-only">Open user menu</span>
                            <UserCircleIcon class="w-10 mt-1"/>
                            <small class="font-bold ml-5">{{currentUser.name}}</small>
                            <ChevronDownIcon class="ml-2 -mr-1 w-5 text-black hover:text-indigo-900"/>
                        </MenuButton>
                    </div>
                    <transition enter-active-class="transition ease-out duration-100"
                                enter-from-class="transform opacity-0 scale-95"
                                enter-to-class="transform opacity-100 scale-100"
                                leave-active-class="transition ease-in duration-75"
                                leave-from-class="transform opacity-100 scale-100"
                                leave-to-class="transform opacity-0 scale-95">
                        <MenuItems class="absolute right-0 mt-2 w-40 origin-top-right divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                            <div class="px-1 py-1">
                                <!--<MenuItem v-slot="{ active }">
                                    <button :class="[active ? 'bg-indigo-600 text-white' : 'text-gray-900','group flex w-full items-center rounded-md px-2 py-2 text-sm',]"><UserIcon class="w-5 mr-5"/>Profile</button>
                                </MenuItem>
                                <MenuItem v-slot="{ active }">
                                    <button :class="[active ? 'bg-indigo-600 text-white' : 'text-gray-900','group flex w-full items-center rounded-md px-2 py-2 text-sm',]"><Cog6ToothIcon class="w-5 mr-5"/>Settings</button>
                                </MenuItem>!-->
                                <MenuItem v-slot="{ active }">
                                    <button @click="logout" :class="[active ? 'bg-indigo-600 text-white' : 'text-gray-900','group flex w-full items-center rounded-md px-2 py-2 text-sm',]"><ArrowLeftOnRectangleIcon class="w-5 mr-5"/>Cerrar Sesión</button>
                                </MenuItem>
                            </div>
                        </MenuItems>
                    </transition>
                </Menu>
                </div>
            </div>
        </div>

        <DisclosurePanel class="sm:hidden">
            <div class="space-y-1 px-2 pt-2 pb-3">
                <DisclosureButton v-for="item in navigation" :key="item.name" as="a" :href="item.href" :class="[item.current ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white', 'block px-3 py-2 rounded-md text-base font-medium']" :aria-current="item.current ? 'page' : undefined">{{ item.name }}</DisclosureButton>
            </div>
        </DisclosurePanel>
    </Disclosure>
</template>

<script setup>
import {Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import {UserCircleIcon, Bars3Icon, BellIcon, XMarkIcon,ChevronDownIcon,UserIcon,ArrowLeftOnRectangleIcon,Cog6ToothIcon } from '@heroicons/vue/24/outline'
import store from "../store/index.js";
import router from "../router/index.js";
import {computed} from "vue";

const emit = defineEmits(['toggleSidebar']);

const navigation = [
    { name: 'Dashboard', href: '#', current: true },
    { name: 'Team', href: '#', current: false },
    { name: 'Projects', href: '#', current: false },
    { name: 'Calendar', href: '#', current: false },
]

const currentUser = computed(() => store.state.user.data);

function logout()
{
    store.dispatch('logout').then(() => {
        router.push({name:'login'})
    });
}

</script>
