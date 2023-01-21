<template>
    <div v-if="currentUser?.id" class="flex">
        <SideBar :class="{'-ml-[180px]' : !sidebarOpened}" class="min-h-screen transition-all duration-300"></SideBar>

        <div class="flex-1">
            <header class="h-16 shadow bg-white">
                <nav-bar @toggle-sidebar="toggleSidebar"></nav-bar>
            </header>
            <main class="m-5 text-left">
                <router-view></router-view>
            </main>
        </div>
    </div>
    <div v-else class="h-screen bg-gray-100 flex items-center justify-center m-auto h-50">
        <div class="items-center justify-center" >
            <Spiner></Spiner>
        </div>
    </div>
    <Toast></Toast>
</template>

<script setup>
import SideBar from "./SideBar.vue";
import NavBar from "./NavBar.vue";
import {ref, onMounted, onUnmounted, computed} from "vue";
import store from "../store/index.js";
import Spiner from "./core/loadingSpiner.vue";
import Toast from "./core/Toast.vue";

const sidebarOpened = ref(true);
const currentUser = computed(() => store.state.user.data);

function toggleSidebar(){
    sidebarOpened.value=!sidebarOpened.value;
}
onMounted(() => {
    store.dispatch('getUser');
    handleResize();
    window.addEventListener('resize', handleResize);
})

function handleResize(){
    sidebarOpened.value = window.outerWidth>=768;
}

</script>



<style scoped>

</style>
