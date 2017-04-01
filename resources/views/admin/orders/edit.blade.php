@extends('layouts.app')

@section('content')
    <div class="container">
        <a href="{{ route('admin.orders.index') }}" class="btn btn-default btn-small">
            Retornar
        </a>

        <h3>Pedido # {{$order->id}} - R$ {{$order->total}}</h3>
        <h4>Cliente: {{$order->client->user->name}}</h4>
        <h4>Data: {{$order->created_at}}</h4>
        <p>
            <b>Entregar em:</b><br>
            {{$order->client->address}} - {{$order->client->city}} - {{$order->client->state}}
        </p>

        {!! Form::model($order, ['route' => ['admin.orders.update', $order->id], 'method' => 'POST', 'files'=>true]) !!}

        <div class="form-group">
            {!! Form::label('Status', 'Status:') !!}
            {!! Form::select('status', $list_status , null, ['class'=>'form-control']) !!}
        </div>

        <div class="form-group">
            <p>Entregador:</p>
            <select class="form-control" name="petshop_id">
                @foreach($retailers as $retailer)
                    <option value="{{$retailer->id}}">
                        {{$retailer->user->name}}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            {!! Form::submit('Salvar', ['class'=>'btn btn-primary']) !!}
        </div>

        {!! Form::close() !!}
    </div>
@endsection