<template>
  <div class="flex items-center justify-between mb-3">
    <h1 class="text-3xl font-semibold">Usuarios</h1>
    <button type="button"
            @click="showAddNewModal()"
            class="py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
    >
      Añadir nuevo usuario
    </button>
  </div>

    <UsersTable @clickEdit="editUser"/>

    <UsersModal v-model="showUserModal" :user="userModel" @close="onModalClose"/>


</template>

<script setup>
import {computed, onMounted, ref} from "vue";
import store from "../../store";
import UsersModal from "./UserModal.vue";
import UsersTable from "./UsersTable.vue";

const DEFAULT_USER = {
    id : '',
    name : '',
    email : '',
}

const users = computed(() => store.state.users);

const userModel = ref({...DEFAULT_USER})
const showUserModal = ref(false);

function showAddNewModal() {
  showUserModal.value = true
}

function editUser(u) {
    userModel.value = u;
    showAddNewModal();
}

function onModalClose() {
  userModel.value = {...DEFAULT_USER}
}

function clearData(){
    productModel.value ={...DEFAULT_EMPTY_MODEL_PRODUCT};
}
</script>

<style scoped>

</style>
