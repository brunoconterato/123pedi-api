@extends('layouts.app')

@section('content')
    <div class="container">
        <a href="{{ route('admin.categories.index') }}" class="btn btn-default btn-small">
            Retornar
        </a>

        <h3>Nova Categoria</h3>

        @include('errors._check')

        {!! Form::open(['route'=>'admin.categories.store', 'class'=>'form']) !!}

        @include('admin.categories._form')

        <div class="form-group">
            {!! Form::submit('Criar categoria', ['class'=>'btn btn-primary']) !!}
        </div>

        {!! Form::close() !!}

    </div>
@endsection