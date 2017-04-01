@extends('layouts.app')

@section('content')
    <div class="container">
        <a href="{{ route('admin.products.index') }}" class="btn btn-default btn-small">
            Retornar
        </a>

        <h3>Editando Produto: {{$product->name}}</h3>

        @include('errors._check')

        {!! Form::model($product, ['route' => ['admin.products.update', $product->id], 'method' => 'POST', 'files'=>true]) !!}

        @include('admin.products._form')

        <p>
            <b>Fotos:</b><br>
            @if($hasImages)
                <img src="{{ $imagesPath }}" height="500" />
                <div class="form-group">
                    {!! Form::label('Substituir foto: ') !!}
                    {!! Form::file('image',null) !!}
                </div>


                <a href='{{ route('admin.products.deleteImage', ['id' => $product->id]) }}' onclick="return confirm('A imagem será perdida. Tem certeza?')" class="deletebtn">
                    <button type="button" class="btn btn-danger">Excluir imagem</button>
                </a>
                <br>
            @else
                Não há fotos cadastradas <br>
                <div class="form-group">
                    {!! Form::label('Cadastrar fotos: ') !!}
                    {!! Form::file('image',null) !!}
                </div>
            @endif
        </p>

        <br>

        <div class="form-group">
            {!! Form::submit('Salvar', ['class'=>'btn btn-primary']) !!}
        </div>

        {!! Form::close() !!}

    </div>
@endsection