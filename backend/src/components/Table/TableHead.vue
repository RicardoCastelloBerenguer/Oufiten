<template>
    <th @click="emit('orderProductsBy',field)" class="float align-items-center border-b-2 p-2 text-left cursor-pointer bg-gray-100"
        :class="field == sortBy ? 'bg-indigo-600 text-white' : ''">
        <slot></slot>
        <div v-if="sortBy == field" class="ml-2">
            <ArrowUpIcon v-if="order=='asc'" class="float-right h-6 w-6"/>
            <ArrowDownIcon v-else class="float-right h-6 w-6"/>
        </div>
    </th>
</template>

<script setup>

import {ArrowDownIcon,ArrowUpIcon} from "@heroicons/vue/20/solid/index.js";


const {field,sortBy,order} = defineProps({
    field:String,
    sortBy:String,
    order:String,
})
const emit = defineEmits(['orderProductsBy']);

</script>


<style scoped>



</style>
