@extends('layouts.app')

@section('content')
    <div class="container">
        <a href="{{ route('admin.products.index') }}" class="btn btn-default btn-small">
            Retornar
        </a>

        <h3>Novo Produto</h3>

        @include('errors._check')

        {!! Form::open(['route'=>'admin.products.store', 'class'=>'form', 'files' => true]) !!}

        @include('admin.products._form')

        <div class="form-group">
            <label for="Incluir foto:">Incluir Foto: </label>
            {!! Form::file('image', null) !!}
        </div>

        <div class="form-group">
            {!! Form::submit('Criar produto', ['class'=>'btn btn-primary']) !!}
        </div>

        {!! Form::close() !!}

    </div>
@endsection