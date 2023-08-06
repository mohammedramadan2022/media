<x-form.inputs type="translation" name="product"></x-form.inputs>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <x-form.inputs type="number" name="price" slug="form-price"></x-form.inputs>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <x-form.inputs type="number" name="hour_price" slug="form-hour-price"></x-form.inputs>
        </div>
    </div>
</div>

<div class="form-group">
    <x-form.select-input :arr="$cities" name="city_id" slug="cities.t-city"></x-form.select-input>
</div>

<div class="form-group">
    <x-form.select-input :arr="$sections" name="section_id" slug="sections.t-section"></x-form.select-input>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <x-form.select-input :arr="[]" name="category_id" slug="categories.t-category"></x-form.select-input>
        </div>
    </div>
    <div class="col-md-12" id="specs-container"></div>
</div>

<div class="form-group">
    <x-form.input-radio :model="$currentModel ?? null" name="has_offer" slug="form-has-offer" color="dark"></x-form.input-radio>
</div>

<div class="form-group" id="has-offer-value" style="display: none;">
    <x-form.inputs type="number" name="offer" slug="form-offer"></x-form.inputs>
</div>

<div class="form-group">
    <x-form.input-radio :model="$currentModel ?? null" name="has_insurance" slug="form-has-insurance" color="dark"></x-form.input-radio>
</div>

<div class="form-group" id="has-insurance-value" style="display: none;">
    <x-form.inputs type="number" name="insurance" slug="form-insurance"></x-form.inputs>
</div>

<div class="form-group">
    <x-form.inputs type="number" name="qty" slug="form-quantity"></x-form.inputs>
</div>

<div class="form-group">
    <x-form.inputs type="text" name="code" slug="form-product-code"></x-form.inputs>
</div>

<div class="form-group">
    <label for="images">@lang('back.form-images')</label>

    <div class="file-loading">
        <input id="images" name="images[]" type="file" multiple>
    </div>
</div>

<div class="form-group">
    <p class="text-muted mt-3 mb-2">@lang('back.product-ownership')</p>

    <div class="radio radio-dark form-check-inline">
        <input type="radio" id="no" value="store" name="ownership" {{ isset($currentModel) ? (!$currentModel->ownership ? 'checked' : '') : 'checked' }}>
        <label for="no">@lang('back.my-store')</label>
    </div>

    <div class="radio radio-dark form-check-inline">
        <input type="radio" id="yes" value="rental" name="ownership" {{ isset($currentModel) ? ($currentModel->ownership ? 'checked' : '') : '' }}>
        <label for="yes">@lang('back.rental')</label>
    </div>
</div>

@section('scripts')
    {!! script('admin/js/piexif.min.js') !!}
    {!! script('admin/js/sortable.min.js') !!}
    {!! script('admin/js/fileinput.min.js') !!}
    {!! script('admin/js/LANG.js') !!}
    {!! script('admin/js/bootstrap.bundle.min.js') !!}

    <script>
        $(document).ready(function () {
            let offer_el = $('#has-offer-value');
            let insurance_el = $('#has-insurance-value');
            let advance_amount_el = $('#has-advance-amount-value');
            let category_id = {{ isset($currentModel) ? $currentModel->category_id : '0' }};
            let specs_el = $('#specs-container');
            let category_selector = $('select#category_id');

            let arr1 = [];
            let arr2 = [];

            CKEDITOR.replace('descriptionar', { height: '400px', extraPlugins: 'forms' });
            CKEDITOR.replace('descriptionen', { height: '400px', extraPlugins: 'forms' });
            CKEDITOR.replace('rental_termsar', { height: '400px', extraPlugins: 'forms' });
            CKEDITOR.replace('rental_termsen', { height: '400px', extraPlugins: 'forms' });
            CKEDITOR.replace('usage_instructionsar', { height: '400px', extraPlugins: 'forms' });
            CKEDITOR.replace('usage_instructionsen', { height: '400px', extraPlugins: 'forms' });

            @if(isset($currentModel))
            CKEDITOR.instances.descriptionar.setData(`{!! $currentModel->translate('ar')->description !!}`);
            CKEDITOR.instances.descriptionen.setData(`{!! $currentModel->translate('en')->description !!}`);
            CKEDITOR.instances.rental_termsar.setData(`{!! $currentModel->translate('ar')->rental_terms !!}`);
            CKEDITOR.instances.rental_termsen.setData(`{!! $currentModel->translate('en')->rental_terms !!}`);
            CKEDITOR.instances.usage_instructionsar.setData(`{!! $currentModel->translate('ar')->usage_instructions !!}`);
            CKEDITOR.instances.usage_instructionsen.setData(`{!! $currentModel->translate('en')->usage_instructions !!}`);
            @endif

            @if(isset($currentModel))
            @if($currentModel->has_offer) offer_el.fadeIn(); @endif
            @if($currentModel->has_insurance) insurance_el.fadeIn(); @endif
            @if($currentModel->has_advance_amount) advance_amount_el.fadeIn(); @endif
            getCategories('{{ $currentModel->section_id }}');
            @endif

            @if(isset($currentModel))
            let current_model_id = '{{ $currentModel->id }}';
            let current_category_id = '{{ $currentModel->category_id }}';
            $.ajax({
                method: 'POST',
                url: '{{ route('products.ajax-get-options-by-category-id') }}',
                data: {category_id: current_category_id, product_id: current_model_id},
                success: response => specs_el.html(response),
                error: err => console.log(err),
            });
            @endif

            @if(isset($currentModel) && $currentModel->images->count() > 0)
            let images = @json($currentModel->images->pluck('image', 'id')->toArray());

            $.each(images, function(index, name){
                arr1[index] = "{{ rootAsset('storage/uploaded/products/') }}/" + name;
                arr2[index] = {caption: name, key: index};
            });
            @endif

            $("#images").fileinput({
                'showUpload': false,
                initialPreview: arr1,
                maxFileCount: 10,
                validateInitialCount: true,
                initialPreviewAsData: true,
                initialPreviewConfig: arr2,
                overwriteInitial: false,
                initialCaption: "حدد الملفات ..."
            });

            $('.kv-file-remove.btn.btn-sm.btn-kv.btn-default.btn-outline-secondary').on('click', async function(e){
                e.preventDefault();

                let willDelete = await swal(setAlertDeleteObject('تنبيه', 'هل انت متأكد من حذف هذه الصورة ؟'));

                if (!willDelete) { swal(swalObjectTerminated); return; }

                $.ajax({
                    method: 'POST',
                    url: '{{ route('provider.products.ajax-remove-image-from-list') }}',
                    data: {id: $(this).data('key')},
                    success: () => {
                        swal({ title: 'رسالة', text: 'تم حذف الصورة بنجاح', icon: "success", buttons: [false, "حسنا"] });
                        $(this).parent().parent().parent().parent().fadeOut();
                    },
                    error: err => { swal('خطأ', 'خطأ في الخادم', 'warning'); console.log(err); },
                });
            });
            $('select#section_id').on('change', function(){ getCategories($(this).val()); });

            // ======================================
            $('input[name=has_offer]').on('change', function(){ $(this).val() === '0' ? offer_el.fadeOut() : offer_el.fadeIn(); });

            $('input[name=has_insurance]').on('change', function(){ $(this).val() === '0' ? insurance_el.fadeOut() : insurance_el.fadeIn(); });

            $('input[name=has_advance_amount]').on('change', function(){ $(this).val() === '0' ? advance_amount_el.fadeOut() : advance_amount_el.fadeIn() });

            category_selector.on('change', function() {
                $.ajax({
                    method: 'POST',
                    url: '{{ route('products.ajax-get-options-by-category-id') }}',
                    data: {category_id: $(this).val()},
                    success: response => specs_el.html(response),
                    error: err => console.log(err),
                });
            });

            function getCategories(section_id){
                $.ajax({
                    url: '{{route('provider.products.getCategoriesBySectionId')}}',
                    method: 'POST',
                    data: {section_id},
                    success: response => {
                        let html = '<option disabled selected value="">@lang('back.select-a-value')</option>';
                        $.each(response.data, function(index, name){
                            html += `<option ${parseInt(category_id) === parseInt(index) ? 'selected' : ''} value="${index}">${name}</option>`;
                        });
                        $('select#category_id').html(html);
                    },
                    error: err => console.log(err)
                });
            }
        });
    </script>
@stop
