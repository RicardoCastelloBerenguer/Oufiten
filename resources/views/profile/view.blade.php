<x-app-layout>
    <div x-data="{

        flashMessage : '{{\Illuminate\Support\Facades\Session::get('flash_message')}}',
        init(){
            if(this.flashMessage){
                setTimeout(() => this.$dispatch('notify',{message:this.flashMessage}),200)
            }
        }
    }" class="container mx-auto lg:w-2/3 p-5">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">
            <div class="bg-white p-3 shadow rounded-lg md:col-span-2 border-dark-gray border-2">
                <form action="{{route('profile.update')}}" method="post"
                    x-data="{
                        countries:{{json_encode($countries)}},
                        shippingAddress:{{json_encode([

                            'address1' => old('shipping.address1' , $shippingAddress->address1),
                            'address2' => old('shipping.address2' , $shippingAddress->address2),
                            'city' => old('shipping.city' , $shippingAddress->city),
                            'community' => old('shipping.community' , $shippingAddress->community),
                            'country_code' => old('shipping.country_code' , $shippingAddress->country_code),
                            'zipcode' => old('shipping.zipcode' , $shippingAddress->zipcode),

                        ])}},

                        billingAddress:{{json_encode([

                            'address1' => old('billing.address1' , $billingAddress->address1),
                            'address2' => old('billing.address2' , $billingAddress->address2),
                            'city' => old('billing.city' , $billingAddress->city),
                            'community' => old('billing.community' , $billingAddress->community),
                            'country_code' => old('billing.country_code' , $billingAddress->country_code),
                            'zipcode' => old('billing.zipcode' , $billingAddress->zipcode),

                        ])}},

                        get billingCountryCommunity(){
                            const country = this.countries.find(c => c.code == this.billingAddress.country_code)
                            if(country && country.community) {
                                return JSON.parse(country.community);
                            }
                            return null;
                        },
                        get shippingCountryCommunity(){
                            const country = this.countries.find(c => c.code == this.shippingAddress.country_code)
                            if(country && country.community) {
                                return JSON.parse(country.community);
                            }
                            return null;
                        }

                    }" >
                    @csrf

                    <h2 class="text-xl font-semibold">Detalles Perfil</h2>
                    <div class="grid grid-cols-2 gap-3 mb-3">


                        <x-input
                            type="text"
                            name="first_name"
                            value="{{old('first_name' , $customer->first_name)}}"
                            placeholder="Nombre"
                            class="w-full focus:border-indigo-600 focus:ring-indigo-600 border-gray-300 rounded"
                        >

                        </x-input>

                        <x-input
                            type="text"
                            name="last_name"
                            value="{{old('last_name' , $customer->last_name)}}"
                            placeholder="Apellidos"
                            class="w-full focus:border-indigo-600 focus:ring-indigo-600 border-gray-300 rounded"
                        >
                        </x-input>
                    </div>
                    <div class="mb-3">

                        <x-input
                            type="text"
                            name="email"
                            value="{{old('email' , $user->email)}}"
                            placeholder="Email"
                            class="w-full focus:border-indigo-600 focus:ring-indigo-600 border-gray-300 rounded"
                        />
                    </div>
                    <div class="mb-3">
                        <x-input
                            type="text"
                            name="phone"
                            value="{{old('phone' , $customer->phone)}}"
                            placeholder="Teléfono"
                            class="w-full focus:border-indigo-600 focus:ring-indigo-600 border-gray-300 rounded"
                        />
                    </div>

                    <h2 class="text-xl font-semibold">Dirección de Facturación</h2>
                    <div class="grid grid-cols-2 gap-3 mb-3">
                        <x-input
                            type="text"
                            name="billing[address1]"
                            x-model="billingAddress.address1"
                            placeholder="Dirección 1"
                            class="w-full focus:border-indigo-600 focus:ring-indigo-600 border-gray-300 rounded"
                        />
                        <x-input
                            type="text"
                            name="billing[address2]"
                            x-model="billingAddress.address2"
                            placeholder="Dirección 2"
                            class="w-full focus:border-indigo-600 focus:ring-indigo-600 border-gray-300 rounded"
                        />
                    </div>


                    <div class="grid grid-cols-2 gap-3 mb-3">

                        <x-input
                            type="text"
                            name="billing[city]"
                            x-model="billingAddress.city"
                            placeholder="Ciudad"
                            class="w-full focus:border-indigo-600 focus:ring-indigo-600 border-gray-300 rounded"
                        />

                        <x-input
                            type="text"
                            name="billing[zipcode]"
                            x-model="billingAddress.zipcode"
                            placeholder="C.P."
                            class="w-full focus:border-indigo-600 focus:ring-indigo-600 border-gray-300 rounded"
                        />

                    </div>
                    <div class="grid grid-cols-2 gap-3 mb-3">

                        <x-input
                            type="select"
                            name="billing[country_code]"
                            x-model="billingAddress.country_code"
                            class="w-full focus:border-indigo-600 focus:ring-indigo-600 border-gray-300 rounded"
                        >
                            <option value="">Selecciona el País</option>
                            <template x-for="country of countries" :key="country.code">
                                <option :selected="country.code == billingAddress.country_code" :value="country.code" x-text="country.name">1</option>
                            </template>

                        </x-input>

                    </div>

                    <div>
                        <template x-if="billingCountryCommunity">
                            <x-input
                                type="select"
                                name="billing[community]"
                                x-model="billingAddress.community"
                                class="w-full focus:border-indigo-600 focus:ring-indigo-600 border-gray-300 rounded"
                            >
                                <option value="">Selecciona la comunidad Autónoma</option>
                                <template x-for="[countryCode , countryCommunity] of Object.entries(billingCountryCommunity)" :key="countryCode">
                                    <option :selected="countryCode == billingAddress.community" :value="countryCode" x-text="countryCommunity"></option>
                                </template>
                            </x-input>
                        </template>
                        <template x-if="!billingCountryCommunity">
                            <x-input
                                type="text"
                                name="billing[community]"
                                x-model="billingAddress.community"
                                placeholder="Comunidad Autónoma"
                                class="w-full focus:border-indigo-600 focus:ring-indigo-600 border-gray-300 rounded"
                            />
                        </template>
                    </div>

                    <div class="flex justift-between mt-6 mb-2">
                        <h2 class="text-xl font-semibold">Dirección de Envío</h2>
                            <label for="sameAsBillingAddress" class="text-gray-700">
                                <input @change="event.target.checked ? shippingAddress = {...billingAddress} : ''" type="checkbox" id="sameAsBillingAddress" class="text-indigo-600 focus:ring-indigo-600 ml-5 mr-2">
                                Misma que la de facturación
                            </label>
                    </div>

                    <div class="grid grid-cols-2 gap-3 mb-3">
                        <x-input
                            type="text"
                            name="shipping[address1]"
                            x-model="shippingAddress.address1"
                            placeholder="Dirección 1"
                            class="w-full focus:border-indigo-600 focus:ring-indigo-600 border-gray-300 rounded"
                        />
                        <x-input
                            type="text"
                            name="shipping[address2]"
                            x-model="shippingAddress.address2"
                            placeholder="Dirección 2"
                            class="w-full focus:border-indigo-600 focus:ring-indigo-600 border-gray-300 rounded"
                        />
                    </div>
                    <div class="grid grid-cols-2 gap-3 mb-3">
                        <x-input
                            type="text"
                            name="shipping[city]"
                            x-model="shippingAddress.city"
                            placeholder="Ciudad"
                            class="w-full focus:border-indigo-600 focus:ring-indigo-600 border-gray-300 rounded"
                        />
                        <x-input
                            type="text"
                            name="shipping[zipcode]"
                            x-model="shippingAddress.zipcode"
                            placeholder="C.P"
                            class="w-full focus:border-indigo-600 focus:ring-indigo-600 border-gray-300 rounded"
                        />
                    </div>

                    <div class="grid grid-cols-2 gap-3 mb-3">

                        <x-input
                            type="select"
                            name="shipping[country_code]"
                            x-model="shippingAddress.country_code"
                            class="w-full focus:border-indigo-600 focus:ring-indigo-600 border-gray-300 rounded"
                        >
                            <option value="">Selecciona el país</option>
                            <template x-for="country of countries" :key="country.code">
                                <option :selected="country.code == shippingAddress.country_code" :value="country.code" x-text="country.name"></option>
                            </template>
                        </x-input>

                    </div>

                    <div>
                        <template x-if="shippingCountryCommunity">
                            <x-input
                                type="select"
                                name="shipping[community]"
                                x-model="shippingAddress.community"
                                class="w-full focus:border-indigo-600 focus:ring-indigo-600 border-gray-300 rounded mb-5"
                            >
                                <option value="">Selecciona la comunidad Autónoma</option>
                                <template x-for="[countryCode , countryCommunity] of Object.entries(shippingCountryCommunity)" :key="countryCode">
                                    <option :selected="countryCode == shippingAddress.community" :value="countryCode" x-text="countryCommunity"></option>
                                </template>
                            </x-input>
                        </template>
                        <template x-if="!shippingCountryCommunity">
                            <x-input
                                type="text"
                                name="shipping[community]"
                                x-model="shippingAddress.community"
                                placeholder="Comunidad Autónoma"
                                class="w-full focus:border-indigo-600 focus:ring-indigo-600 border-gray-300 mb-5"
                            />
                        </template>
                    </div>

                    <x-button class="w-full">Actualizar Perfil</x-button>
                </form>
            </div>
            <div class="bg-white p-3 shadow rounded-lg border-dark-gray border-2">
                <form action="{{route('profile.updatePassword')}}" method="post">
                    @csrf
                    <h2>Actualizar Contraseña</h2>
                    <div class="mb-3">
                        <x-input
                            type="password"
                            name="new_password"
                            placeholder="Contraseña"
                            class="w-full focus:border-indigo-600 focus:ring-indigo-600 border-gray-300 rounded"
                        />
                    </div>
                    <div class="mb-3">
                        <x-input
                            type="password"
                            name="new_password_confirmation"
                            placeholder="Repite la nueva contraseña"
                            class="w-full focus:border-indigo-600 focus:ring-indigo-600 border-gray-300 rounded"
                        />
                    </div>
                    <x-button>Actualizar contraseña</x-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
