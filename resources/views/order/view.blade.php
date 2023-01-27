<x-app-layout>

    <!-- component -->
    <div class="py-14 px-4 md:px-6 2xl:px-20 2xl:container 2xl:mx-auto">
        <!--- more free and premium Tailwind CSS components at https://tailwinduikit.com/ --->

        <div class="flex justify-start item-start space-y-2 flex-col">
            <h1 class="text-3xl dark:text-white lg:text-4xl font-semibold leading-7 lg:leading-9 text-gray-800">Pedido #{{$order->id}}</h1>
            <p class="text-base dark:text-gray-300 font-medium leading-6 text-gray-600">{{$order->created_at}}</p>
        </div>
        <div class="mt-10 flex flex-col xl:flex-row jusitfy-center items-stretch w-full xl:space-x-8 space-y-4 md:space-y-6 xl:space-y-0">
            <div class="flex flex-col justify-start items-start w-full space-y-4 md:space-y-6 xl:space-y-8">
                <div class="flex flex-col justify-start items-start dark:bg-gray-800 bg-gray-50 px-4 py-4 md:py-6 md:p-6 xl:p-8 w-full">
                    @foreach($order->orderItems as $OrderItem)
                    <div class="mt-4 md:mt-6 flex flex-col md:flex-row justify-start items-start md:items-center md:space-x-6 xl:space-x-8 w-full">
                        <div class="pb-4 md:pb-8 w-full md:w-40">
                            <a href="{{route('product.view',$OrderItem->product)}}">
                                <img class="w-full hidden md:block" src="{{$OrderItem->product->image}}" alt="dress" />
                            </a>
                        </div>
                        <div class="border-b border-gray-200 md:flex-row flex-col flex justify-between items-start w-full pb-8 space-y-4 md:space-y-0">
                            <div class="w-full flex flex-col justify-start items-start space-y-8">
                                <h3 class="text-xl dark:text-white xl:text-2xl font-semibold leading-6 text-gray-800">{{$OrderItem->product->title}}</h3>
                                <div class="flex justify-start items-start flex-col space-y-2">
                                    <p class="text-sm dark:text-white leading-none text-gray-800"><span class="dark:text-gray-400 text-gray-300"></span></p>
                                    <p class="text-sm dark:text-white leading-none text-gray-800"><span class="dark:text-gray-400 text-gray-300"></span>-</p>
                                    <p class="text-sm dark:text-white leading-none text-gray-800"><span class="dark:text-gray-400 text-gray-300"></span></p>
                                </div>
                            </div>
                            <div class="flex justify-between space-x-8 items-start w-full">
                                <p class="text-base dark:text-white xl:text-lg leading-6">{{$OrderItem->product->price}}€ <span class="text-red-300 line-through"></span></p>
                                <p class="text-base dark:text-white xl:text-lg leading-6 text-gray-800">Cantidad : {{$OrderItem->quantity}}</p>
                                <p class="text-base dark:text-white xl:text-lg font-semibold leading-6 text-gray-800">- {{$OrderItem->product->price*$OrderItem->quantity}}€</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="flex justify-center flex-col md:flex-row flex-col items-stretch w-full space-y-4 md:space-y-0 md:space-x-6 xl:space-x-8">
                    <div class="flex flex-col px-4 py-6 md:p-6 xl:p-8 w-full bg-gray-50 dark:bg-gray-800 space-y-6">
                        <h3 class="text-xl dark:text-white font-semibold leading-5 text-gray-800">Resumen</h3>
                        <div class="flex justify-center items-center w-full space-y-4 flex-col border-gray-200 border-b pb-4">
                            <div class="flex justify-between w-full">
                                <p class="text-base dark:text-white leading-4 text-gray-800">Total</p>
                                <p class="text-base dark:text-gray-300 leading-4 text-gray-600">{{$order->total_price}} €</p>
                            </div>
                            <div class="flex justify-between items-center w-full">
                                <p class="text-base dark:text-white leading-4 text-gray-800">Descuento <span class="bg-gray-200 p-1 text-xs font-medium dark:bg-white dark:text-gray-800 leading-3 text-gray-800">ESTUDIANTE</span></p>
                                <p class="text-base dark:text-gray-300 leading-4 text-gray-600">-$0.00 (0%)</p>
                            </div>
                            <div class="flex justify-between items-center w-full">
                                <p class="text-base dark:text-white leading-4 text-gray-800">Envío</p>
                                <p class="text-base dark:text-gray-300 leading-4 text-gray-600">$0.00</p>
                            </div>
                        </div>
                        <div class="flex justify-between items-center w-full">
                            <p class="text-base dark:text-white font-semibold leading-4 text-gray-800">Total</p>
                            <p class="text-base dark:text-gray-300 font-semibold leading-4 text-gray-600">{{$order->total_price}} €</p>
                        </div>
                    </div>
                    <div class="flex flex-col justify-center px-4 py-6 md:p-6 xl:p-8 w-full bg-gray-50 dark:bg-gray-800 space-y-6">
                        <h3 class="text-xl dark:text-white font-semibold leading-5 text-gray-800">ESTADO</h3>
                        <div class="flex justify-between items-start w-full">
                            <div class="flex justify-center items-center space-x-4">
                                <div class="w-8 h-8">
                                    <img class="w-full h-full" alt="logo" src="https://i.ibb.co/L8KSdNQ/image-3.png" />
                                </div>
                                <div class="flex flex-col justify-start items-center">
                                    <p class="text-lg leading-6 dark:text-white font-semibold text-gray-800">{{$order->status == \App\Enums\OrderStatus::Paid->value ? 'PAGADO' : ($order->status == \App\Enums\OrderStatus::Unpaid->value ? 'POR PAGAR' : ($order->status == \App\Enums\OrderStatus::Cancelled->value ? 'CANCELADO' : 'COMPLETADO'))}}</p>
                                </div>
                            </div>
                        </div>
                        @if($order->status == \App\Enums\OrderStatus::Unpaid->value)

                            <form action="{{route('payment.resumeOrderPayment' , $order)}}" method="post">
                                @csrf
                                <div class="w-full flex justify-center items-center">
                                <button class="hover:bg-black dark:bg-white dark:text-gray-800 dark:hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-800 py-5 w-96 md:w-full bg-gray-800 text-base font-medium leading-4 text-white">Pagar pedido</button>
                                </div>
                            </form>
                        @elseif($order->status == \App\Enums\OrderStatus::Paid->value || $order->status == \App\Enums\OrderStatus::Completed->value)
                            <p class="text-lg leading-6 dark:text-white font-semibold text-gray-800">Gracias por efectuar su compra con nosotros!</p>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>

</x-app-layout>
