@extends('layouts.app')

@section('content')

    <div class="container">
        <a href="{{ route('retailer.stock.index') }}" class="btn btn-default btn-small">
            Retornar
        </a>

        <h3>Editando Item de Estoque: {{$stockItem->product->name}}</h3>

        @include('errors._check')

        {!! Form::model($stockItem, ['route' => ['retailer.stock.update', $stockItem->id]]) !!}

        @include('retailer.stock._form')

        <div class="form-group">
            {!! Form::submit('Salvar', ['class'=>'btn btn-primary']) !!}
        </div>

        {!! Form::close() !!}

    </div>
@endsection