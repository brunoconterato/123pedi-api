@extends('layouts.app')

@section('content')
    <div class="container">
        <a href="{{ route('admin.categories.index') }}" class="btn btn-default btn-small">
            Retornar
        </a>

        <h3>Editando Categoria: {{$category->name}}</h3>

        @include('errors._check')

        {!! Form::model($category, ['route' => ['admin.categories.update', $category->id]]) !!}

        @include('admin.categories._form')

        <div class="form-group">
            {!! Form::submit('Salvar categoria', ['class'=>'btn btn-primary']) !!}
        </div>

        {!! Form::close() !!}

    </div>
@endsection