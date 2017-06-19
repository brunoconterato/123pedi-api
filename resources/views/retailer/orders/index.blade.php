@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Minhas Entregas</h3>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Total</th>
                <th>Status</th>
                <th>Ação</th>
            </tr>
            </thead>

            <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>{{$order->id}}</td>
                    <td>{{$order->total}}</td>
                    <td>{{$order->status}}</td>
                    <td>
                        <a href="{{route('retailer.orders.vieworder', ['id'=>$order->id])}}" class="btn btn-warning btn-small">
                            <i class = "glyphicon glyphicon-eye-open"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {!! $orders->render() !!}
    </div>
@endsection