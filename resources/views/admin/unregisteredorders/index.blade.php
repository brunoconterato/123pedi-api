@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Pedidos</h3>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Total</th>
                <th>Data</th>
                <th>Itens</th>
                <th>Status</th>
                <th>Entregador</th>
                <th>Ação</th>
            </tr>
            </thead>


            <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>#{{$order->id}}</td>
                    <td>{{$order->total}}</td>
                    <td>{{$order->created_at}}</td>
                    <td>
                        <ul>
                            @foreach($order->items as $orderItem)
                                <li>{{$orderItem->stockItem->product->name}}</li>
                            @endforeach
                        </ul>
                    {{--</td>--}}
                    {{--<td>{{$order->status}}</td>--}}
                    {{--<td>--}}
                        {{--@if($order->retailer)--}}
                            {{--{{$order->retailer->user->name}}--}}
                        {{--@else--}}
                            {{------}}
                        {{--@endif--}}
                    {{--</td>--}}

                    {{--<td>--}}
                        {{--<a href="{{route('admin.unregisteredorders.edit', ['id'=>$order->id])}}" class="btn btn-warning btn-small">--}}
                            {{--<i class = "glyphicon glyphicon-eye-open"></i>--}}
                        {{--</a>--}}
                    {{--</td>--}}
                {{--</tr>--}}
            @endforeach
            </tbody>

        </table>

        {{ $orders->render() }}

    </div>
@endsection