<!DOCTYPE html>
<html>

<head>
    <title>Test Email</title>
</head>

<body>

    <h2>Gracias {{ $order->user->name . " " . $order->user->last_name }} por su compra</h2>

    <br>

    <h3>Detalles de la Orden</h3>

    <table class="table table-hover table-head-fixed text-nowrap projects">
        <thead>
            <tr>
                <th>ORDEN ID:</th>
                <td>{{ $order->id }}</td>
            </tr>
            <tr>
                <th>Cliente:</th>
                <td>{{ $order->user->email }}</td>
            </tr>
            <tr>
                <th>Hora Entrega:</th>
                <td>{{ $order->delivery_time }}</td>
            </tr>
            <tr>
                <th>Pizza:</th>
                <td>{{$order->pizzas->pluck('name')->join(', ')}}</td>
            </tr>
            <tr>
                <th>Creada:</th>
                <td>{{$order->updated_at}}</td>
            </tr>
        </thead>
    </table>

</body>

</html>
