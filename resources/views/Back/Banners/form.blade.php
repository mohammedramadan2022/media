<div class="form-group">
    <x-form.input-image :model="$currentModel ?? null" name="image"></x-form.input-image>
</div>

<div class="form-group">
    <x-form.select-input :arr="$types" name="type" slug="type"></x-form.select-input>
</div>

<div class="form-group form-valid" id="link-input">
    <label for="link">@lang('back.link')</label>
    <input type="text" name="type_link_id" class="form-control form-data" id="link" value="{{ optional($currentModel ?? null)->type_id }}">
</div>

<div class="form-group" id="section-id-input">
    <x-form.select-input :arr="$sections" name="section_id" slug="sections.t-section"></x-form.select-input>
</div>

<div class="form-group" id="product-id-input">
    <x-form.select-input :arr="$products" name="type_id" slug="products.t-product"></x-form.select-input>
</div>

<div class="form-group">
    <x-form.switch-input :model="$currentModel ?? null"></x-form.switch-input>
</div>

@section('scripts')
    <script>
        $(document).ready(function(){
            let link_input = $('div#link-input');
            let section_input = $('div#section-id-input');
            let product_input = $('div#product-id-input');

            @if(isset($currentModel))
                @if($currentModel->type == 'link')
                    link_input.show();
                    section_input.hide();
                    product_input.hide();
                @elseif($currentModel->type == 'section')
                    link_input.hide();
                    section_input.show();
                    product_input.hide();
                @elseif($currentModel->type == 'product')
                    link_input.hide();
                    section_input.hide();
                    product_input.show();
                @else
                    link_input.hide();
                    section_input.hide();
                    product_input.hide();
                @endif
            @else
                link_input.hide();
                section_input.hide();
                product_input.hide();
            @endif

            $('select#type').on('change', function(){
                switch ($(this).val()) {
                    case 'link':
                        link_input.fadeIn();
                        section_input.fadeOut();
                        product_input.fadeOut();
                        break;
                    case 'section':
                        link_input.fadeOut();
                        section_input.fadeIn();
                        product_input.fadeOut();
                        break;
                    case 'product':
                        link_input.fadeOut();
                        section_input.fadeOut();
                        product_input.fadeIn();
                        break;
                    default:
                        link_input.hide();
                        section_input.hide();
                        product_input.hide();
                }
            });
        });
    </script>
@stop
