@extends('layouts.app')

@section('content')
    <div class="container">
        <a href="{{ route('retailer.stock.index') }}" class="btn btn-default btn-small">
            Retornar
        </a>

        <h3>Novo Item de Estoque</h3>

        @include('errors._check')

        {!! Form::open(['route'=>'retailer.stock.store', 'class'=>'form']) !!}

        @include('retailer.stock._form')

        <div class="form-group">
            {!! Form::submit('Criar item de estoque', ['class'=>'btn btn-primary']) !!}
        </div>

        {!! Form::close() !!}

    </div>
@endsection