<template>
  <div class="flex items-center justify-between mb-3">
    <h1 class="text-3xl font-semibold">Clientes</h1>
  </div>

    <CustomersTable @clickEdit="editCustomer"/>


</template>

<script setup>
import {computed, onMounted, ref} from "vue";
import store from "../../store";
import CustomersTable from "./CustomersTable.vue";
import CustomerModal from "./CustomerModal.vue";
import {getCustomer} from "../../store/actions.js";



const costumers = computed(() => store.state.customers);


function editCustomer(c) {
    store.dispatch('getCustomer',c.id);
}
</script>

<style scoped>

</style>
