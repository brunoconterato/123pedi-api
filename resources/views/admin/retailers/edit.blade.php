@extends('layouts.app')

@section('content')
    <div class="container">
        <a href="{{ route('retailers') }}" class="btn btn-default btn-small">
            Retornar
        </a>

        <h3>Editando Pet Shop: {{$petShop->user->name}}</h3>

        @include('errors._check')

        {!! Form::model($petShop, ['route' => ['retailers', $petShop->id]]) !!}

        @include('admin.retailers._form')

        <div class="form-group">
            {!! Form::submit('Salvar', ['class'=>'btn btn-primary']) !!}
        </div>

        {!! Form::close() !!}

    </div>
@endsection