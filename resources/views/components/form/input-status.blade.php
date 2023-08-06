<div class="checkbox checkbox-switchery switchery-lg">
    <label>
        @if(isset($model)) @php $status = $model->{$col} == 1 ? true : false; @endphp

        @else @php $status = true; @endphp

        @endif

        {!! Form::checkbox($col,1, $status,['class'=>'form-control switchery form-data','id' => $col]) !!}

        @lang($trans)
    </label>
</div>
