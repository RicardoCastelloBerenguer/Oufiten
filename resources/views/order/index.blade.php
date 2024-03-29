<x-app-layout>

    <div class="container lg:w-2/3 xl:w-2/3 mx-auto">
        <h1 class="text-3xl font-bold mb-6">Mis pedidos</h1>
        <div class="bg-white p-3 rounded-md shadow-md">
            @if(count($orders)>0)
            <table class="table table-auto w-full">
                <thead class="border-b-2">
                <tr class="text-left">
                    <th>Pedido</th>
                    <th>Fecha</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th class="w-64">Acciones</th>
                </tr>
                </thead>
                <tbody>
                @foreach($orders as $order)
                <tr class="border-b">
                    <td>
                        <a
                            href="{{route('orders.view' , $order)}}"
                            class="text-purple-600 hover:text-purple-500"
                        >
                            #{{$order->id}}
                        </a>
                    </td>
                    <td>{{$order->created_at}}</td>
                    <td>{{$order->total_price}}</td>
                    <td>
                        <span class="{{$order->status==\App\Enums\OrderStatus::Paid->value ? 'bg-green-500' : ($order->status==\App\Enums\OrderStatus::Unpaid->value ? 'bg-gray-500' : ($order->status==\App\Enums\OrderStatus::Cancelled->value ? 'bg-red-500' : 'bg-yellow-500')) }} text-white p-1 rounded">{{$order->status}}</span>
                    </td>
                    <td class="flex gap-3">
                        <div x-data="{open: false}">
                            <button
                                @click="open = true"
                                class="btn-primary py-1 px-2 flex items-center border-2 border-dark-gray hover:border-2 bg-gray-200 text-dark-gray hover:bg-dark-gray hover:text-white hover:border-black"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5 mr-1"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="2"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                    />
                                </svg>
                                Ver Factura
                            </button>
                            <template x-teleport="body">
                                <!-- Backdrop -->
                                <div
                                    x-show="open"
                                    class="fixed flex justify-center items-center left-0 top-0 bottom-0 right-0 z-10 bg-black/80"
                                >
                                    <!-- Dialog -->
                                    <div
                                        x-show="open"
                                        x-transition
                                        @click.outside="open = false"
                                        class="bg-white rounded-lg"
                                    >
                                        <!-- Modal Title -->
                                        <div
                                            class="py-2 px-4 text-lg font-semibold bg-gray-100 rounded-t-lg flex items-center justify-between"
                                        >
                                            <button @click="open = false">
                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    class="h-6 w-6"
                                                    fill="none"
                                                    viewBox="0 0 24 24"
                                                    stroke="currentColor"
                                                    stroke-width="2"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="M6 18L18 6M6 6l12 12"
                                                    />
                                                </svg>
                                            </button>
                                        </div>
                                        <!-- Modal Body -->
                                        <div class="p-4">
                                            <div class="flex justify-center items-center bg-gray-200 text-gray-900">
                                                <div class="rounded-md relative w-72 shadow-2xl p-3 bg-white">
                                                    <div class="py-2">
                                                        <div class="text-center text-xl font-bold">PEDIDO</div>
                                                        <div class="text-center text-xs font-bold">Detalles del pedido</div>
                                                    </div>
                                                    <div class="text-center text-xs font-bold mb-1">~~~~~~~~~~~~~~~~~~~~~~~~~~~~</div>
                                                    <div class="text-xs pl-2">
                                                        <div class="text-xs mb-1">Cliente：{{$order->user->customer->first_name}}</div>
                                                        <div class="text-xs mb-1">Telefono：{{$order->user->customer->phone}}</div>
                                                        <div>OrderNumber：{{$order->id}}</div>
                                                    </div>
                                                    <div class="border-double border-t-4 border-b-4 border-l-0 border-r-0 border-gray-900 my-3">
                                                        <div class="flex text-sm pt-1 px-1">
                                                            <span class="w-2/6">Nombre</span>
                                                            <span class="w-2/6 text-right">Precio</span>
                                                            <span class="w-2/6 text-right">Cantidad</span>
                                                        </div>
                                                        <div class="border-dashed border-t border-b border-l-0 border-r-0 border-gray-900 mt-1 my-2 py-2 px-1">
                                                            @foreach($order->orderItems as $orderItem)
                                                                <div class="flex justify-between text-sm">
                                                                    <span class="w-2/6 truncate">{{$orderItem->product->title}}</span>
                                                                    <span class="w-2/6 text-right">{{$orderItem->product->price}}</span>
                                                                    <span class="w-2/6 text-right">{{$orderItem->quantity}}</span>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    <div class="text-xs">
                                                        <div class="mb-1">Descuento：€0</div>
                                                        <div class="mb-52">-----------</div>
                                                        <div class="text-right">
                                                            <div>Fecha：{{$order->created_at}}</div>
                                                            <div class="font-bold text-sm">Total：{{$order->total_price}} €</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                        @if($order->status==\App\Enums\OrderStatus::Unpaid->value)
                            <form action="{{route('payment.resumeOrderPayment' , $order)}}" method="post">
                                @csrf
                                <button class="btn-primary py-1 px-2 flex items-center border-2 border-dark-gray hover:border-2 bg-gray-200 text-dark-gray hover:bg-dark-gray hover:text-white hover:border-black">
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-6 w-6 mr-1"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="2"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"
                                        />
                                    </svg>
                                    Pagar
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
            @else
                <h2 class="text-2xl text-center mb-6">Aún no tienes pedidos registrados</h2>
            @endif
        </div>
        <div class="mt-2">
            {{$orders->links()}}
        </div>

    </div>

</x-app-layout>
