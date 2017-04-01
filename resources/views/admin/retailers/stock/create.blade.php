@extends('layouts.app')

@section('content')
    <div class="container">
        <a href="{{ route('admin.petshops.stock.index', ['id'=>$petShopId]) }}" class="btn btn-default btn-small">
            Retornar
        </a>

        <h3>Novo Item de Estoque</h3>

        @include('errors._check')

        {!! Form::open(['route'=> ['retailers', 'petshopId'=>$petShopId], 'class'=>'form']) !!}

        @include('petshop.stock._form')

        <div class="form-group">
            {!! Form::submit('Criar item de estoque', ['class'=>'btn btn-primary']) !!}
        </div>

        {!! Form::close() !!}

    </div>
@endsection