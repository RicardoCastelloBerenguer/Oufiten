<x-app-layout>

    <div class="container lg:w-2/3 xl:w-2/3 mx-auto">
        <h1 class="text-3xl font-bold mb-6">Tus productos</h1>

        <div
            x-data="{
             cartItems : {{
                    json_encode(
                        $products->map(fn($product) => [
                'id' => $product->id,
                'slug' => $product->slug,
                'image' => $product->image,
                'title' => $product->title,
                'price' => $product->price,
                'quantity' => $cartItems[$product->id]['quantity'],
                'href' => route('product.view',$product->slug),
                'removeUrl' => route('cart.remove' , $product),
                'updateQuantityUrl' => route('cart.update-quantity',$product)
                 ])
             )
             }} ,
             get cartTotal() {
                 return this.cartItems.reduce((accum,next) => accum + next.price * next.quantity,0).toFixed(2)
             }
             }" class="bg-white p-4 rounded-lg shadow border-2 border-dark-gray" >


            <template x-if="cartItems.length">
                <div>
                    <!-- Product Item -->
                    <template x-for="product of cartItems" :key="product.id">
                        <div x-data="productItem(product)">
                            <div
                                class="w-full flex flex-col sm:flex-row items-center gap-4 flex-1">
                                <a :href="product.href"
                                   class="w-36 h-32 flex items-center justify-center overflow-hidden">
                                    <img :src="product.image" class="object-cover" alt=""/>
                                </a>
                                <div class="flex flex-col justify-between flex-1">
                                    <div class="flex justify-between mb-3">
                                        <h3 x-text="product.title"></h3>
                                        <span class="text-lg font-semibold">
                                            <span x-text="product.price"></span>€
                                        </span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <div class="flex items-center">
                                            Cantidad:
                                            <input
                                                type="number"
                                                min="1"
                                                x-model="product.quantity"
                                                @change="changeCartQuantity()"
                                                class="ml-3 py-1 border-gray-200 focus:border-purple-600 focus:ring-purple-600 w-16"
                                            />
                                        </div>
                                        <a
                                            href="#"
                                            @click.prevent="removeItemFromCart()"
                                            class="text-dark.gray hover:text-dark-beige hover:underline"
                                        >Quitar</a
                                        >
                                    </div>
                                </div>
                            </div>
                            <!--/ Product Item -->
                            <hr class="my-5 text-dark-gray"/>
                        </div>
                    </template>
                    <!-- Product Item -->

                    <div class="border-t border-gray-300 pt-4">
                        <div class="flex justify-between">
                            <span class="font-semibold">Subtotal</span>
                            <span id="cartTotal" class="text-xl" x-text="`${cartTotal}€`"></span>
                        </div>
                        <p class="text-gray-500 mb-6">
                            Envío y impuestos ya calculados en el pago.
                        </p>
                        <form action="{{route('cart.payment')}}" method="post">
                            @csrf
                            @if(!$disabled)
                            <button if type="submit" class="btn-primary w-full py-3 text-lg btn-primary border-2 border-dark-gray hover:border-2 bg-gray-200 text-dark-gray hover:bg-dark-gray hover:text-white hover:border-black">
                                Proceder al pago
                            </button>
                            @else
                                <div class="py-3 text-lg flex justify-center">
                                    <a
                                        href="{{route('profile')}}"
                                        class="text-center btn-primary w-full py-3 text-lg btn-primary border-2 border-dark-gray hover:border-2 bg-gray-200 text-dark-gray hover:bg-dark-gray hover:text-white hover:border-black">
                                        Debes rellenar tus datos de envío antes de proceder al pago
                                    </a>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
                <!--/ Product Items -->
            </template>
            <template x-if="!cartItems.length">
                <div class="text-center py-8 text-gray">
                    No tienes ningún producto en el carrito
                </div>
            </template>

        </div>
    </div>

</x-app-layout>
