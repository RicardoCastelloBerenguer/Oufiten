<template>
    <div class="min-h-full flex">

        <SideBar :class="{'-ml-[180px]' : !sidebarOpened}" class="transition-all duration-300"></SideBar>

        <div class="flex-1">
            <header class="h-16 shadow bg-white">
                <nav-bar @toggle-sidebar="toggleSidebar"></nav-bar>
            </header>
            <main>
                <router-view></router-view>
            </main>
        </div>
    </div>

</template>

<script setup>
import SideBar from "./SideBar.vue";
import NavBar from "./NavBar.vue";
import {ref, onMounted , onUnmounted} from "vue";

const sidebarOpened = ref(true);


function toggleSidebar(){
    sidebarOpened.value=!sidebarOpened.value;
}

onMounted(() => {
    handleResize();
    window.addEventListener('resize', handleResize);
})

function handleResize(){
    sidebarOpened.value = window.outerWidth>=768;
}

</script>



<style scoped>

</style>
