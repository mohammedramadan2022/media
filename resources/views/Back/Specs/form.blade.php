<x-form.inputs type="translation" name="spec"></x-form.inputs>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <x-form.select-input name="type" :arr="$types" slug="form-spec-type"></x-form.select-input>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <x-form.inputs type="text" name="code" slug="form-spec-code"></x-form.inputs>
        </div>
    </div>
</div>

<div class="form-group d-none" id="dropdown-input">
    <x-form.select-input name="dropdown" :arr="$dropdown" slug="form-select-type"></x-form.select-input>
</div>

<hr class="d-none" id="separator" style="padding: 20px;background-color: var(--main)">

<div class="row d-none" id="dynamic-option-name">
    <div class="col-md-12">
        <div class="form-group">
            <div class="inputs-container row">
                @if(isset($currentModel) && $currentModel->options->count() > 0 && $currentModel->type == 'select' && $currentModel->dropdown == 'color')
                    <div class="form-group col-md-2">
                        <x-form.inputs
                            type="color"
                            name="colors[0]"
                            :value="$currentModel->options->first()->value"
                            slug="form-color"></x-form.inputs>
                    </div>

                    <div class="form-group col-md-4">
                        <x-form.inputs
                            type="text" name="names_ar[0]"
                            slug="form-name-ar"
                            :value="$currentModel->options->first()->names()->first()->translate('ar')->name"
                            :model="$currentModel"></x-form.inputs>
                    </div>

                    <div class="form-group col-md-4">
                        <x-form.inputs
                            type="text"
                            name="names_en[0]"
                            slug="form-name-en"
                            :value="$currentModel->options->first()->names()->first()->translate('en')->name"
                            :model="$currentModel"
                            dir="ltr"></x-form.inputs>
                    </div>

                    <div class="col-md-2">
                        <button type="button" data-from="color" class="btn btn-primary" id="createNewNameInput" style="margin-top: 27px;">+</button>
                    </div>
                @else
                    <div class="col-md-5">
                        <x-form.inputs
                            type="text"
                            name="names_ar[0]"
                            slug="form-name-ar"
                            :value="isset($currentModel) ? ((isset($currentModel->options) && $currentModel->options->count() > 0 ? $currentModel->options->first()->names()->first()->translate('ar')->name : '')) : ''"
                            :model="$currentModel ?? null"></x-form.inputs>
                    </div>

                    <div class="col-md-5">
                        <x-form.inputs
                            type="text"
                            name="names_en[0]"
                            slug="form-name-en"
                            :value="isset($currentModel) ? ((isset($currentModel->options) && $currentModel->options->count() > 0 ? $currentModel->options->first()->names()->first()->translate('en')->name : '')) : ''"
                            :model="$currentModel ?? null" dir="ltr"></x-form.inputs>
                    </div>

                    <div class="col-md-2">
                        <button type="button" data-from="normal" class="btn btn-primary" id="createNewNameInput" style="margin-top: 27px;">+</button>
                    </div>
                @endif
            </div>
        </div>

        <div class="form-group" id="inputs-names-container">
            @if(isset($currentModel) && $currentModel->options->count() > 0)
                @if($currentModel->type == 'select' && $currentModel->dropdown == 'color')
                    @foreach($currentModel->options as $i => $_option)
                        <div class="row">
                            @foreach($_option->names()->with(['translation'])->get() as $_name)
                                @continue($i == 0)
                                <div class="form-group col-md-2">
                                    <x-form.inputs type="color" name="colors[{{$i}}]" :value="$_option->value" slug="form-color"></x-form.inputs>
                                </div>

                                <div class="form-group col-md-4">
                                    <x-form.inputs type="text" name="names_ar[{{$i}}]" :value="$_name->translate('ar')->name" slug="form-name-ar" :model="$currentModel"></x-form.inputs>
                                </div>

                                <div class="form-group col-md-4">
                                    <x-form.inputs type="text" name="names_en[{{$i}}]" :value="$_name->translate('en')->name" slug="form-name-en" :model="$currentModel" dir="ltr"></x-form.inputs>
                                </div>

                                <div class="form-group col-md-2">
                                    <button type="button" data-index="{{$i}}" data-id="{{$_option->id}}" onclick="removeColorRow(this);" class="btn btn-danger" style="font-weight: bold;margin-top: 27px;">-</button>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                @else
                    @foreach($currentModel->options as $i => $option)
                        @foreach($option->names()->with(['translation'])->get() as $name)
                            @continue($i == 0)
                            <div class="row" id="column-name-row-{{ $i }}">
                                <div class="col-md-5">
                                    <x-form.inputs
                                        type="text"
                                        name="names_ar[{{$i}}]"
                                        slug="form-name-ar"
                                        :value="$name->translate('ar')->name"
                                        :model="$currentModel ?? null"></x-form.inputs>
                                </div>

                                <div class="col-md-5">
                                    <x-form.inputs
                                        type="text"
                                        name="names_en[{{$i}}]"
                                        slug="form-name-en"
                                        :value="$name->translate('en')->name"
                                        :model="$currentModel ?? null" dir="ltr"></x-form.inputs>
                                </div>

                                <div class="form-group col-md-2">
                                    <button
                                        type="button"
                                        data-id="{{$name->id}}"
                                        data-index="{{$i}}"
                                        onclick="$(this).parent().parent().remove();"
                                        class="btn btn-danger removeNameBtn"
                                        style="font-weight: bold;margin-top: 27px;">-</button>
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                @endif
            @endif
        </div>
    </div>
</div>

<div class="form-group">
    <x-form.switch-input :model="$currentModel ?? null"></x-form.switch-input>
</div>

@section('scripts')
    <script>
        function decrementNames(title_number) {
            return title_number--;
        }

        @if(isset($currentModel))
            async function removeColorRow(btn) {
                let id = $(btn).data('id');

                let willDelete = await swal(setAlertDeleteObject('تنبيه', 'هل انت متأكد من حذف العنصر ؟'));

                if(!willDelete) { swal(swalObjectTerminated); return; }

                $.ajax({
                    url: '{{ route('specs.ajax-remove-option-by-id') }}',
                    method: 'POST',
                    data: { id },
                    success: res => {
                        $(btn).parent().parent().remove();
                        swal(res.message, {icon: "success", buttons: [false, '@lang('back.ok')']});
                    },
                    error: err => {
                        swal('Server Error', {icon: "warning", buttons: [false, '@lang('back.ok')']});
                        console.log(err);
                    },
                });
            }
        @endif

        $(document).ready(function() {
            let separator = $('#separator');
            let inputsNamesContainer = $('#inputs-names-container');
            let names_index = @if(Route::is('specs.edit') && isset($currentModel)) {{ $currentModel->options->count() }} @else 1 @endif;
            let type_el = $('select#type');
            let dropdown_in = $('#dropdown-input');
            let dropdown_el = $('select#dropdown');
            let dynamic_option_name_el = $('#dynamic-option-name');
            let inputs_container_el = $('.inputs-container');

            @isset($currentModel)
                @if($currentModel->type == 'select')
                    separator.removeClass('d-none');
                    dropdown_in.removeClass('d-none');
                    dynamic_option_name_el.removeClass('d-none');
                @endif
            @endisset

            type_el.on('change', function() {
                if($(this).val() === 'select') {
                    separator.removeClass('d-none');
                    dropdown_in.removeClass('d-none');
                    dynamic_option_name_el.removeClass('d-none');
                    inputsNamesContainer.html(``);
                    return;
                }

                separator.addClass('d-none');
                dropdown_in.addClass('d-none');
                dynamic_option_name_el.addClass('d-none');
            });

            dropdown_el.on('change', function () {
                if($(this).val() === 'color')
                {
                    inputsNamesContainer.html(``);
                    inputs_container_el.html(``);
                    inputs_container_el.html(`
                        <div class="form-group col-md-2">
                            <x-form.inputs type="color" name="colors[0]" slug="form-color"></x-form.inputs>
                        </div>

                        <div class="form-group col-md-4">
                            <x-form.inputs type="text" name="names_ar[0]" slug="form-name-ar" :model="$currentModel ?? null"></x-form.inputs>
                        </div>

                        <div class="form-group col-md-4">
                            <x-form.inputs type="text" name="names_en[0]" slug="form-name-en" :model="$currentModel ?? null" dir="ltr"></x-form.inputs>
                        </div>

                       <div class="col-md-2">
                            <button type="button" data-from="color" class="btn btn-primary" id="createNewNameInput" style="margin-top: 27px;">+</button>
                        </div>
                    `);
                }
                else
                {
                    inputsNamesContainer.html(``);
                    inputs_container_el.html(`
                        <div class="col-md-5">
                            <x-form.inputs
                                type="text"
                                name="names_ar[0]"
                                slug="form-name-ar"
                                :value="isset($currentModel) ? ((isset($currentModel->names) && $currentModel->names->count() > 0 ? $currentModel->names->first()->translate('ar')->name : '')) : ''"
                                :model="$currentModel ?? null"></x-form.inputs>
                        </div>

                        <div class="col-md-5">
                            <x-form.inputs
                                type="text"
                                name="names_en[0]"
                                slug="form-name-en"
                                :value="isset($currentModel) ? ((isset($currentModel->names) && $currentModel->names->count() > 0 ? $currentModel->names->first()->translate('en')->name : '')) : ''"
                                :model="$currentModel ?? null" dir="ltr"></x-form.inputs>
                        </div>

                       <div class="col-md-2">
                            <button type="button" data-from="normal" class="btn btn-primary" id="createNewNameInput" style="margin-top: 27px;">+</button>
                        </div>
                    `);
                }
            });

            function createNameWithColorInput(title_number)
            {
                inputsNamesContainer.append(`
                    <div class="row" id="column-color-with-name-row-${title_number}">
                        <div class="form-group col-md-2">
                            <x-form.inputs type="color" name="colors[${title_number}]" slug="form-color"></x-form.inputs>
                        </div>

                        <div class="form-group col-md-4">
                            <x-form.inputs type="text" name="names_ar[${title_number}]" slug="form-name-ar" :model="$currentModel ?? null"></x-form.inputs>
                        </div>

                        <div class="form-group col-md-4">
                            <x-form.inputs type="text" name="names_en[${title_number}]" slug="form-name-en" :model="$currentModel ?? null" dir="ltr"></x-form.inputs>
                        </div>

                        <div class="form-group col-md-2">
                            <button type="button" data-index="${title_number}" onclick="$(this).parent().parent().remove();" class="btn btn-danger" style="font-weight: bold;margin-top: 27px;">-</button>
                        </div>
                    </div>
                `);
            }

            function createTitleInput(title_number)
            {
                inputsNamesContainer.append(`
                    <div class="row" id="column-name-row-${title_number}">
                        <div class="form-group col-md-5">
                            <x-form.inputs type="text" name="names_ar[${title_number}]" slug="form-name-ar" :model="$currentModel ?? null"></x-form.inputs>
                        </div>

                        <div class="form-group col-md-5">
                            <x-form.inputs type="text" name="names_en[${title_number}]" slug="form-name-en" :model="$currentModel ?? null" dir="ltr"></x-form.inputs>
                        </div>

                        <div class="form-group col-md-2">
                            <button type="button" data-index="${title_number}" onclick="$(this).parent().parent().remove();" class="btn btn-danger removeAllRow" style="font-weight: bold;margin-top: 27px;">-</button>
                        </div>
                    </div>
                `);
            }

            $(document).on('click', '#createNewNameInput', function() {
                let type = $(this).data('from');
                type === 'color' ? createNameWithColorInput(names_index++) : createTitleInput(names_index++);
            });

            @if(isset($currentModel))
                $(document).on('click', '.removeAllRow', function() {
                    decrementNames($(this).data('index'));
                    $(this).parent().parent().remove();
                });
            @endif
        });
    </script>
@endsection
