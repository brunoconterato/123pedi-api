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

<div class="form-group">
    {!! Form::label('Min_selling_price', 'Preço mínimo de venda:') !!}
    {!! Form::number('min_selling_price', null, ['class'=>'form-control', 'step'=>'0.01']) !!}
</div>

<div class="form-group">
    {!! Form::label('Cost_price', 'Preço de custo:') !!}
    {!! Form::number('cost_price', null, ['class'=>'form-control', 'step'=>'0.01']) !!}
</div>

<div class="form-group">
    {{--TODO: fazer um datepicker (ver google) para selecionar data de validade--}}
    {!! Form::label('Expiration_date', 'Data de validade:') !!}
    {!! Form::date('expiration_date', null, ['class'=>'form-control']) !!}
</div>