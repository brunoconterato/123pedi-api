@extends('layouts.app')

@section('content')
    <div class="container">
        <a href="{{ route('retailer.orders.index') }}" class="btn btn-default btn-small">
            Retornar
        </a>

        <br><br>

        <h3>Entrega # {{$order->id}} - R$ {{$order->total}}</h3>
        <h4>Cliente: {{$order->name}}</h4>
        <h4>Data: {{$order->created_at}}</h4>

        <p>
            <b>Entregar em:</b><br>
            {{$order->street_adress}} - {{$order->city}} - {{$order->state}}
        </p>

        <b>Produtos:</b><br>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Produto</th>
                <th>Preço</th>
                <th>Quantidade</th>
                <th>Subtotal</th>
            </tr>
            </thead>

            <tbody>
            @foreach($order->items as $item)
            <tr>
                <td>{{$item->stockItem->product->name}}</td>
                <td>{{$item->stockItem->price}}</td>
                <td>{{$item->quantity}}</td>
                <td>{{$item->price * $item->quantity}}</td>
            </tr>
            @endforeach
            </tbody>
        </table>

        {!! Form::model($order, ['route' => ['retailer.orders.update', $order->id]]) !!}

        <div class="form-group">
            {!! Form::label('Status', 'Status:') !!}
            {!! Form::select('status', $list_status , null, ['class'=>'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::submit('Salvar', ['class'=>'btn btn-primary']) !!}
        </div>

        {!! Form::close() !!}

    </div>
@endsection