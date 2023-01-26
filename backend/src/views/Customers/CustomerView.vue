<template>
    <!-- component -->

    <div class="mt-10 p-6 bg-gray-100 flex items-center justify-center">

        <div class="container max-w-screen-lg mx-auto">
            <div>
                <div class="bg-white rounded shadow-lg p-4 px-4 md:p-8 mb-6">
                    <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
                        <div class="text-gray-600">
                            <p class="font-medium text-lg">Detalles del cliente</p>
                        </div>
                        <LoadingSpiner v-if="loadingCustomer"></LoadingSpiner>
                        <div v-if="!loadingCustomer" class="lg:col-span-2">
                            <form v-if="!loading && !dontShowForm" @submit.prevent="onSubmit">
                            <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-6">

                                    <div class="md:col-span-3">
                                        <label for="first_name">Nombre</label>
                                        <CustomInput :required="true" class="mb-2" v-model="customer.first_name" label="Nombre"/>
                                    </div>

                                    <div class="md:col-span-3">
                                        <label for="first_name">Apellido</label>
                                        <CustomInput :required="true" class="mb-2" v-model="customer.last_name" label="Apellido"/>
                                    </div>

                                    <div class="md:col-span-6">
                                        <label for="email">Dirección Email</label>
                                        <CustomInput :required="true" class="mb-2" v-model="customer.email" label="Email"/>
                                    </div>

                                    <div class="md:col-span-2">
                                        <label for="email">Teléfono</label>
                                        <CustomInput :required="true" class="mb-2" v-model="customer.phone" label="Teléfono"/>
                                    </div>

                                    <div class="md:col-span-4">

                                    </div>

                                    <div class="md:col-span-6 grid place-items-center py-3">
                                        <p class="font-medium text-lg">Dirección de envío : </p>
                                    </div>

                                    <div class="md:col-span-4">
                                        <label for="address">Dirección / Calle</label>
                                        <CustomInput :required="true" class="mb-2" v-model="customer.shippingAddress.address1" label="Dirección 1"/>
                                    </div>

                                    <div class="md:col-span-2">
                                        <label for="city">Ciudad</label>
                                        <CustomInput :required="true" class="mb-2" v-model="customer.shippingAddress.city" label="Ciudad"/>
                                    </div>


                                    <div class="md:col-span-2">
                                        <label for="country">País / Region</label>
                                        <div class="h-10 bg-gray-50 flex border border-gray-200 rounded items-center mt-1">
                                            <select name="País"
                                                    :required="true"
                                                    v-model="customer.shippingAddress.country_code"
                                                    class="px-4 appearance-none outline-none text-gray-800 w-full bg-transparent"
                                                    @change="onChange($event.target.value)">
                                                <option v-for="option of countries" :value="option.code">{{option.name}}</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="md:col-span-2">
                                        <label for="state">Comunidad / Estado</label>
                                        <div class="h-10 flex rounded items-center mt-1">
                                            <CustomInput :required="true" class="mb-2" v-model="customer.shippingAddress.community" label="Ciudad"/>
                                        </div>
                                    </div>

                                    <div class="md:col-span-1">
                                        <label for="zipcode">C.P</label>
                                        <CustomInput :required="true" class="mb-2" v-model="customer.shippingAddress.zipcode" label="Codigo postal"/>
                                    </div>

                                    <div class="md:col-span-5">
                                        <div class="inline-flex items-center">
                                            <input type="checkbox" name="billing_same" id="billing_same" class="form-checkbox" />
                                            <label for="billing_same" class="ml-2">My billing address is different than above.</label>
                                        </div>
                                    </div>

                                    <div class="md:col-span-6 grid place-items-center py-3">
                                        <p class="font-medium text-lg">Dirección de Facturación : </p>
                                    </div>

                                    <div class="md:col-span-4">
                                        <label for="address">Dirección / Calle</label>
                                        <CustomInput :required="true" class="mb-2" v-model="customer.billingAddress.address1" label="Dirección 1"/>
                                    </div>

                                    <div class="md:col-span-2">
                                        <label for="city">Ciudad</label>
                                        <CustomInput :required="true" class="mb-2" v-model="customer.billingAddress.city" label="Ciudad"/>
                                    </div>


                                    <div class="md:col-span-2">
                                        <label for="country">País / Region</label>
                                        <div class="h-10 bg-gray-50 flex border border-gray-200 rounded items-center mt-1">
                                            <select name="País"
                                                    :required="true"
                                                    v-model="customer.billingAddress.country_code"
                                                    class="px-4 appearance-none outline-none text-gray-800 w-full bg-transparent"
                                                    @change="onChange($event.target.value)">
                                                <option v-for="option of countries" :value="option.code">{{option.name}}</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="md:col-span-2">
                                        <label for="state">Comunidad / Estado</label>
                                        <div class="h-10 flex rounded items-center mt-1">
                                            <CustomInput :required="true" class="mb-2" v-model="customer.billingAddress.community" label="Ciudad"/>
                                        </div>
                                    </div>

                                    <div class="md:col-span-1">
                                        <label for="zipcode">C.P</label>
                                        <CustomInput type="text" :maxlength="5" :required="true" class="mb-2" v-model="customer.billingAddress.zipcode" label="Codigo postal"/>
                                    </div>

                                    <div class="md:col-span-5 text-right">
                                        <div class="inline-flex items-end">
                                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Actualizar</button>
                                        </div>
                                    </div>
                            </div>
                        </form>
                            <div class="mt-50" v-else>
                                <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-6">

                                    <div class="md:col-span-6">
                                        <h2 class="text-md font-medium text-gray-900 dark:text-white">El usuario {{customer.first_name}} aún no tiene ningún dato de envío registrado para editar</h2>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script setup>
import {computed, onMounted, ref} from "vue";
import store from "../../store";
import {getCustomer} from "../../store/actions.js";
import CustomInput from "../../components/core/CustomInput.vue";
import {useRoute} from "vue-router";
import LoadingSpiner from "../../components/core/loadingSpiner.vue";

const route = useRoute();
const customer = ref({
    billingAddress: {
        country:{}
    },
    shippingAddress: {
        country:{}
    }
})
const countries = ref({})
const loadingCustomer = ref(false);
const loadingCountries = ref(false);
const dontShowForm = ref(false);


onMounted(() => {
    getCustomerCall();
    getCountries();
})

function getCustomerCall(){
    loadingCustomer.value=true;
    store.dispatch('getCustomer',route.params.id).then(response => {
        if(response.data.billingAddress && response.data.shippingAddress){
            response.data.billingAddress.country.community = JSON.parse(response.data.billingAddress.country.community);
            response.data.shippingAddress.country.community = JSON.parse(response.data.shippingAddress.country.community);
        }
        else{
            dontShowForm.value=true;
        }
        customer.value=response.data;
        loadingCustomer.value=false;
    })
}
function getCountries(){
    loadingCountries.value=true;
    store.dispatch('getCountries').then(response => {
        countries.value=response.data;
        loadingCountries.value=false;
    })
}

function onSubmit(){
    loadingCustomer.value=true;
    store.dispatch('updateCustomer',customer.value).then(resp =>{
        loadingCustomer.value=false;
        if(resp.status == 200){
            getCustomerCall();
            store.commit('showToast',['El cliente se ha actualizado correctamente','success']);
        }
    }).catch(error => {
        loadingCustomer.value=false;
        getCustomerCall();
        store.commit('showToast',['Ha habido un error al actualizar el cliente', 'error']);
        console.log(error);
    });
}
</script>

<style scoped>

</style>
