@extends('layouts.app')

@section('content')
    <div class="container">
        <a href="{{ route('admin.retailers.index') }}" class="btn btn-default btn-small">
            Retornar
        </a>

        <h3>Novo Distribuidor</h3>

        @include('errors._check')

        {!! Form::open(['route'=>'admin.retailers.store', 'class'=>'form']) !!}

        @include('admin.retailers._form')

        <div class="form-group">
            {!! Form::submit('Criar Retailer', ['class'=>'btn btn-primary']) !!}
        </div>

        {!! Form::close() !!}
    </div>
@endsection