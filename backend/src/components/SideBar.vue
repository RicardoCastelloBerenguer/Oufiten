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
                            <a
                                href="#"
                                class="flex items-center p-2 space-x-3 rounded-md hover:bg-black/10"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    class="w-6 h-6"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M2.25 13.5h3.86a2.25 2.25 0 012.012 1.244l.256.512a2.25 2.25 0 002.013 1.244h3.218a2.25 2.25 0 002.013-1.244l.256-.512a2.25 2.25 0 012.013-1.244h3.859m-19.5.338V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18v-4.162c0-.224-.034-.447-.1-.661L19.24 5.338a2.25 2.25 0 00-2.15-1.588H6.911a2.25 2.25 0 00-2.15 1.588L2.35 13.177a2.25 2.25 0 00-.1.661z"
                                    />
                                </svg>

                                <span>Inbox</span>
                            </a>
                        </li>
                        <li class="rounded-sm">
                            <router-link :to="{name: 'app.products'}" class="flex items-center p-2 space-x-3 rounded-md hover:bg-black/10"><CircleStackIcon class="w-6 h-6 mr-3"></CircleStackIcon>Products</router-link>
                        </li>
                        <li class="rounded-sm">
                            <router-link :to="{name: 'app.orders'}" class="flex items-center p-2 space-x-3 rounded-md hover:bg-black/10"><Bars4Icon class="w-6 h-6 mr-3"></Bars4Icon>Orders</router-link>
                        </li>
                        <li class="rounded-sm">
                            <router-link :to="{name: 'app.users'}" class="flex items-center p-2 space-x-3 rounded-md hover:bg-black/10"><UsersIcon class="w-6 h-6 mr-3"></UsersIcon>Users</router-link>
                        </li>
                        <li class="rounded-sm">
                            <a
                                href="#"
                                class="flex items-center p-2 space-x-3 rounded-md hover:bg-black/10"
                            >
                                <ChartBarIcon class="w-6 h-6" aria-hidden="true" />

                                <span>Reports</span>
                            </a>
                        </li>
                        <li class="rounded-sm">
                            <a
                                href="#"
                                class="flex items-center p-2 space-x-3 rounded-md hover:bg-black/10"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    class="w-6 h-6"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z"
                                    />
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                    />
                                </svg>

                                <span>Settings</span>
                            </a>
                        </li>
                        <li class="rounded-sm">
                            <a
                                href="#"
                                class="flex items-center p-2 space-x-3 rounded-md hover:bg-black/10"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    class="w-6 h-6"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75"
                                    />
                                </svg>
                                <span>Logout</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</template>

<script setup>
import{
    HomeIcon,Bars4Icon,UsersIcon,ChartBarIcon,CircleStackIcon
} from "@heroicons/vue/20/solid";
import NavBar from "./NavBar.vue";


</script>
