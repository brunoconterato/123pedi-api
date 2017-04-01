@extends('layouts.app')

@section('content')
    <div class="container">
        <a href="{{ route('admin.petshops.index') }}" class="btn btn-default btn-small">
            Retornar
        </a>

        <h3>Novo Pet Shop</h3>

        @include('errors._check')

        {!! Form::open(['route'=>'retailers', 'class'=>'form']) !!}

        @include('admin.retailers._form')

        <div class="form-group">
            {!! Form::submit('Criar Pet Shop', ['class'=>'btn btn-primary']) !!}
        </div>

        {!! Form::close() !!}
    </div>
@endsection