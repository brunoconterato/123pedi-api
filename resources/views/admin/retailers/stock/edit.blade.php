@extends('layouts.app')

@section('content')

    <div class="container">
        <a href="{{ route('admin.retailers.stock.index', ['retailerId'=>$stockItem->retailer_id]) }}" class="btn btn-default btn-small">
            Retornar
        </a>

        <h3>Editando Item de Estoque: {{$stockItem->product->name}}</h3>

        @include('errors._check')

        {!! Form::model($stockItem, ['route' => ['admin.retailers.stock.update', $stockItem->id]]) !!}

        @include('admin.retailers.stock._form')

        <div class="form-group">
            {!! Form::submit('Salvar', ['class'=>'btn btn-primary']) !!}
        </div>

        {!! Form::close() !!}

    </div>
@endsection