<div class="form-group">
    {!! Form::label('Product', 'Produto:') !!}
    <select class="form-control" name="product_id">
        @foreach($products as $p)
            <option value="{{$p->id}}">
                {{$p->name}} -- {{$p->manufacturer}} -- {{$p->brand}}
            </option>
        @endforeach
    </select>
</div>

<div class="form-group">
    {!! Form::label('Quantity', 'Quantidade:') !!}
    {!! Form::number('quantity', null, ['class'=>'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('Price', 'Preço:') !!}
    {!! Form::number('price', null, ['class'=>'form-control', 'step'=>'0.01']) !!}
</div>