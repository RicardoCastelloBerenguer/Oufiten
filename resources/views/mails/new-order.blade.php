<h1>
    New Order
</h1>

<table>
    <tr>
        <th>ID Pedido</th>
        <h2>{{$userTo->is_admin}}</h2>
        @if($userTo->is_admin==1)
        <a href="{{env('BACKEND_URL').'/app/orders/'.$order->id}}">
            {{$order->id}}
        </a>
        @else
            <a href="{{env('FRONTEND_URL').'/orders/view/'.$order->id}}">
                {{$order->id}}
            </a>
        @endif
    </tr>
    <tr>
        <th>Estado del Pedido</th>
        <td>{{$order->status}}</td>
    </tr>
    <tr>
        <th>Precio del pedido</th>
        <td>{{$order->total_price}} €</td>
    </tr>
    <tr>
        <th>Nombre</th>
        <th>Cantidad</th>
        <th>Precio unitario</th>
        <th>Precio total</th>
    </tr>
    @foreach($order->orderItems as $orderItem)
        <tr>
            <td>{{$orderItem->product->title}}</td>
            <td>{{$orderItem->quantity}}</td>
            <td>{{$orderItem->unit_price}} €</td>
            <td>{{$orderItem->unit_price * $orderItem->quantity}} €</td>
        </tr>
    @endforeach
</table>
