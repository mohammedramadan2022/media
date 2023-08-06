@props(['type' => 'text', 'name' => 'name', 'slug' => 'form-name', 'arr' => [], 'cols' => 12, 'value' => '', 'dir' => 'rtl'])

@switch($type)
    @case('password_confirmation')
        @include('Back.includes.inputs', get_input_attributes('password_confirmation', 'password', 'form-password-confirm', $cols, $dir))
        @break
    @case('image')
        @include('Back.includes.inputs', get_input_attributes('image', $name, $slug, $value, 6, $dir))
        @break
    @case('file')
        @include('Back.includes.inputs', get_input_attributes('file', $name, $slug, $value, $cols, $dir))
        @break
    @case('date')
        @include('Back.includes.inputs', get_input_attributes('date', $name, $slug, $value, $cols, $dir))
        @break
    @case('checkbox')
        @include('Back.includes.inputs', get_input_attributes('checkbox', $name, $slug, $value, $cols, $dir))
        @break
    @case('translation')
        @include('Back.includes.translate', ['model' => '\App\Models\\'.ucwords($name)])
        @break
    @case('ckeditor')
        <label for="editorfullar">{{ trans('back.'.$slug) }}</label>
        <textarea class="form-data editorfull" name="{{$name}}" id="editorfullar" rows="4" cols="4"></textarea>
        @break
    @default
        @include('Back.includes.inputs', get_input_attributes($type, $name, $slug, $value, $cols, $dir))
        @break
@endswitch
