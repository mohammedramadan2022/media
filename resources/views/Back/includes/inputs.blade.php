@if($type == 'password_confirmation')

    <div class="col-xs-{{ $col ?? 12 }}">
        <div class="form-valid floating">
            <label for="password_confirmation">{{ isset($slug) ? ucwords($slug) : '' }}</label>
            {!!
                Form::password('password_confirmation', [
                    'class' => 'form-control form-data',
                    'dir'   => direction(),
                    'id'    =>'password_confirmation'
                ])
            !!}
        </div>
    </div>

@elseif($type == 'password')

    <div class="col-xs-{{ $col ?? 12 }}">
        <div class="form-valid floating">
            <label for="password">{{ isset($slug) ? ucwords($slug) : '' }}</label>
            {!! Form::password('password', ['class' => 'form-control form-data', 'dir' => direction(), 'id' => 'password']) !!}
        </div>
    </div>

@elseif($type == 'select')

    <div class="col-xs-{{ $col ?? 12 }}">
        <div class="form-valid floating">
            <label for="{{ $name }}">{{ isset($slug) ? ucwords($slug) : '' }}</label>
            {!! Form::select($name, $list, $selected, ['class' => 'form-control select2 form-data','dir' => direction(), 'style' => 'width: 100%;','id' => $name]) !!}
        </div>
    </div>

@elseif($type == 'multi-select')

    <div class="col-xs-{{ $col ?? 12 }}">
        <div class="form-valid floating">
            <label for="{{ head(explode('[]', $name)) }}">{{ isset($slug) ? ucwords($slug) : '' }}</label>
            {!! Form::select($name.'[]', $list, null, getMultiSelectForm($name)) !!}
        </div>
    </div>

@elseif($type == 'file')
    <div class="col-xs-9">
        <div class="form-valid">
            <label for="{{$name}}">{{ isset($slug) ? ucwords($slug) : '' }}</label><br>
            <input
                type="file"
                accept="application/pdf"
                data-show-errors="true"
                data-errors-position="outside"
                class="dropify form-data {{ $style }}"
                id="{{$name}}"
                name="{{$name}}"
                data-height="300" />
        </div>
    </div>

    @if(str(request()->path())->contains('edit'))
        <div class="col-xs-3">
            <i class="fa fa-file-pdf fa-5x" style="margin: 142px;"></i>
        </div>
    @endif

@elseif($type == 'image')

    <div class="col-xs-{{ $col ?? 12 }}">
        <div class="form-valid">
            <label for="image">{{ isset($slug) ? ucwords($slug) : '' }}</label><br>
            <input type="file" class="file-styled {{ $style }}" id="image" accept="image/*" name="{{$name}}">
        </div>
    </div>

@elseif($type == 'textarea')

    <div class="col-xs-{{ $col ?? 12 }}">
        <div class="form-valid floating">
            <label for="{{ $name }}">{{ isset($slug) ? ucwords($slug) : '' }}</label>
            {!! Form::textarea($name, null, ['class' => $style, 'rows' => 10, 'style' => 'resize: vertical;', 'dir' => $dir, 'id' => $name]) !!}
        </div>
    </div>

@elseif($type == 'text')

    <div class="col-xs-{{ $col ?? 12 }}">
        <div class="form-valid floating">
            <label for="{{ $name }}">{{ isset($slug) ? ucwords($slug) : '' }}</label>
            {!! Form::text($name, $value != '' ? $value : null, ['class'=>$style,'dir'=>$dir,'id' => $name, 'autocomplete' => "off", 'maxlength' =>  $attr ?? '']) !!}
        </div>
    </div>

@elseif($type == 'multi-date')

    <div class="col-xs-{{ $col ?? 12 }}">
        <div class="form-valid floating">
            <label for="{{ $name }}">{{ isset($slug) ? ucwords($slug) : '' }}</label>
            {!! Form::text($name, null, ['class' => $style, 'placeholder' => 'mm/dd/yyyy','dir' => direction(),'id' => 'datepicker-multiple-date']) !!}
        </div>
    </div>

@elseif($type == 'url')

    <div class="col-xs-{{ $col ?? 12 }}">
        <div class="form-valid floating">
            <label for="{{ $name }}">{{ isset($slug) ? ucwords($slug) : '' }}</label>
            {!! Form::text($name, null, ['class' => $style,'dir' => 'ltr','id' => $name]) !!}
        </div>
    </div>

@elseif($type == 'checkbox')

    <p class="text-muted mt-3 mb-2">{{ isset($slug) ? ucwords($slug) : '' }}</p>

    <div class="radio radio-info form-check-inline">
        <input type="radio" id="inlineRadio1" value="1" name="{{ $name }}" checked>
        <label for="{{ $name }}">@lang('back.yes')</label>
    </div>

    <div class="radio form-check-inline">
        <input type="radio" id="inlineRadio2" value="0" name="{{ $name }}">
        <label for="{{ $name }}">@lang('back.not')</label>
    </div>

@elseif($type == 'date')

    <div class="col-xs-{{ $col ?? 12 }}">
        <div class="form-valid floating">
            <label for="{{ $name }}">{{ isset($slug) ? ucwords($slug) : '' }}</label>
            {!! Form::date($name, $value ?? null, ['class' => $style, 'dir' => direction(), 'id' => $name]) !!}
        </div>
    </div>

@elseif($type == 'number' || $type == 'tel')

    <div class="col-xs-{{ $col ?? 12 }}">
        <div class="form-valid floating">
            <label for="{{ $name }}">{{ isset($slug) ? ucwords($slug) : '' }}</label>
            {!! Form::{$type}($name, null, ['class' => $style, 'maxlength' => '12', 'dir' => direction(), 'id' => $name, 'min' => 1]) !!}
        </div>
    </div>

@else

    <div class="col-xs-{{ $col ?? 12 }}">
        <div class="form-valid floating">
            <label for="{{ $name }}">{{ isset($slug) ? ucwords($slug) : '' }}</label>
            {!! Form::{$type}($name, $value ?? null, ['class' => $style, 'id' => $name]) !!}
        </div>
    </div>

@endif
