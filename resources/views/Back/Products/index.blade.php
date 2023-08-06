<x-model-index-page model="product" :collection="$products">
    <x-slot name="filter">
        <div class="col-md-12">
            <div class="form-group">
                <div class="form-valid">
                    <label for="city_id">@lang('back.cities.t-city')</label>
                    {!! Form::select('city_id', ['' => trans('back.select-a-value')] + $cities, request()->filled('city_id') ? request('city_id') : null, ['class' => 'form-control form-data','dir' => direction(),'id' => 'city_id']) !!}
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <div class="form-valid">
                    <label for="city_id">@lang('back.sections.t-section')</label>
                    {!! Form::select('section_id', ['' => trans('back.select-a-value')] + $sections, request()->filled('section_id') ? request('section_id') : null, ['class' => 'form-control form-data','dir' => direction(),'id' => 'section_id']) !!}
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <div class="form-valid">
                    <label for="city_id">@lang('back.categories.t-category')</label>
                    {!! Form::select('category_id', ['' => trans('back.select-a-value')], request()->filled('category_id') ? request('category_id') : null, ['class' => 'form-control form-data', 'dir' => direction(), 'id' => 'category_id']) !!}
                </div>
            </div>
        </div>
    </x-slot>

    <x-slot name="thead">
        <tr>
            <th>#</th>
            <th>@lang('back.form-name')</th>
            <th>@lang('back.form-image')</th>
            <th>@lang('back.product-belongs-to')</th>
            <th>@lang('back.sections.t-section')</th>
            <th>@lang('back.categories.t-category')</th>
            <th>@lang('back.cities.t-city')</th>
            <th>@lang('back.form-price')</th>
            <th>@lang('back.accept-status')</th>
            <th>@lang('back.form-status')</th>
            <th>@lang('back.since')</th>
            <th class="text-center">@lang('back.form-actions')</th>
        </tr>
    </x-slot>

    @foreach($products as $i => $product)
        <tr>
            <td>{{$i+1}}</td>
            <td data-toggle="tooltip" title="{{$product->name}}">{!! highlightText($product->name) !!}</td>
            <td><x-image-link :imageUrl="$product->first_image_url" width="50"></x-image-link></td>
            <td>{!! $product->owner_name !!}</td>
            <td>{!! highlightText($product->section->name) !!}</td>
            <td>{!! highlightText($product->category->name) !!}</td>
            <td>{!! highlightText($product->city->name) !!}</td>
            <td>{!! highlightText(money($product->price)) !!}</td>
            <td>
                @if(is_null($product->is_accepted))
                    <a href="{{route('products.accept', $product->id)}}" class="btn btn-outline-success">@lang('back.accept')</a>
                    <a href="{{route('products.reject', $product->id)}}" class="btn btn-outline-danger">@lang('back.refuse')</a>
                @elseif($product->is_accepted)
                    <span class="badge badge-success p-2 display-block">@lang('back.accepted')</span>
                @else
                    <span class="badge badge-danger p-2 display-block">@lang('back.refused')</span>
                @endif
            </td>
            <td><x-table-switch-status :model="$product"></x-table-switch-status></td>
            <td>{{ $product->since }}</td>
            <td><x-table-actions modelName="product" :model="$product"></x-table-actions></td>
        </tr>
    @endforeach
    <x-slot name="scripts">
        <script>
            $(function () {
                let section = $('select#section_id');
                let category = $('select#category_id');

                let section_id = {{ request()->filled('section_id') ? request('section_id') : 0 }};
                let cat_id = {{ request()->filled('category_id') ? request('category_id') : 0 }};

                $.ajax({
                    method: 'POST',
                    url: '{{ route('products.getCategoriesBySectionId') }}',
                    data: {section_id},
                    success: ({data}) => {
                        let html = `<option value="">@lang('back.select-a-value')</option>`;
                        $.each(data, function (index, value) {
                            html += `<option ${parseInt(cat_id) === parseInt(index) ? 'selected' : ''} value="${index}">${value}</option>`;
                        });
                        category.html(html);
                    },
                    error: error => console.log(error)
                });

                section.on('change', function () {
                    let section_id = $(this).val();

                    $.ajax({
                        method: 'POST',
                        url: '{{ route('products.getCategoriesBySectionId') }}',
                        data: {section_id},
                        success: ({data}) => {
                            let html = `<option value="">@lang('back.select-a-value')</option>`;
                            $.each(data, function (index, value) {
                                html += `<option value="${index}">${value}</option>`;
                            });
                            category.html(html);
                        },
                        error: error => console.log(error)
                    });
                })
            });
        </script>
    </x-slot>
</x-model-index-page>
