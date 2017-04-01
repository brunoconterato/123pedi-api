@extends('layouts.app')

@section('content')
    <div class="container">
        <a href="{{ route('admin.clients.index') }}" class="btn btn-default btn-small">
            Retornar
        </a>

        <h3>Novo Cliente</h3>

        @include('errors._check')

        {!! Form::open(['route'=>'admin.clients.store', 'class'=>'form']) !!}

        @include('admin.clients._form')

        <div class="form-group">
            {!! Form::submit('Criar cliente', ['class'=>'btn btn-primary']) !!}
        </div>

        {!! Form::close() !!}

    </div>
@endsection