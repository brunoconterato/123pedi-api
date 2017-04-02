@extends('layouts.app')

@section('content')
    <div class="container">
        <a href="{{ route('admin.retailers') }}" class="btn btn-default btn-small">
            Retornar
        </a>

        <h3>Editando Distribuidor: {{$retailer->user->name}}</h3>

        @include('errors._check')

        {!! Form::model($retailer, ['route' => ['admin.retailers.update', $retailer->id], 'method' => 'POST']) !!}

        @include('admin.retailers._form')

        <div class="form-group">
            {!! Form::submit('Salvar', ['class'=>'btn btn-primary']) !!}
        </div>

        {!! Form::close() !!}

    </div>
@endsection