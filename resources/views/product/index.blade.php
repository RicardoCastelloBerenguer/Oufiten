<x-app-layout>
    <?php if ($products->count() === 0): ?>
    <div class="text-center text-white py-16 text-xl">
        There are no products published
    </div>
    <?php else: ?>
    <div class="grid gap-8 grig-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 p-5">
        @foreach($products as $product)
            @if($product->show_catalogue)
                <!-- Product Item -->
                <div
                    x-data="productItem({{ json_encode([
                        'id' => $product->id,
                        'slug' => $product->slug,
                        'image' => $product->image,
                        'title' => $product->title,
                        'price' => $product->price,
                        'addToCartUrl' => route('cart.add', $product)
            ]) }})"
                    class="border border-1 border-dark-beige rounded-md hover:border-dark-gray transition-colors bg-dark-gray text-white">

                    <a href="{{route('product.view', $product)}}" class="block overflow-hidden">
                        <img
                            src={{$product->image}}
                    alt=""
                            class="rounded-lg hover:scale-105 hover:rotate-1 transition-transform"
                        />
                    </a>
                    <div class="p-4">
                        <h3 class="text-lg">
                            <a href="{{route('product.view', $product)}}">
                                {{$product->title}}
                            </a>
                        </h3>
                        <h5 class="font-bold">{{$product->price}}€</h5>
                    </div>
                    <div class="flex justify-between py-3 px-4">
                        <button class="btn-primary border-2 hover:border-2 bg-gray-200 text-dark-gray hover:bg-dark-gray hover:text-white hover:border-gray-200" @click="addToCart()">
                            Añadir
                        </button>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
    {{$products->links()}}
    @endif
</x-app-layout>
