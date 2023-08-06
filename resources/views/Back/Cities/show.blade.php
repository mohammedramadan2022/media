<x-model-show-element :title="$city->name" model="city" nameSpace="back">
    <div class="col-md-12">
        <div class="card border main-border-color">
            <div class="card-header main-background-color text-white">@lang('back.cities.t-city')</div>
            <div class="card-body">
                <ul class="nav nav-tabs nav-justified">
                    <li class="nav-item">
                        <a href="#city" data-toggle="tab" aria-expanded="false" class="nav-link active">
                            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                            <span class="d-none d-sm-block">@lang('back.basic-info')</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#products" data-toggle="tab" aria-expanded="false" class="nav-link">
                            <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                            <span class="d-none d-sm-block">@lang('back.products.products') ({{ $city->cityProducts->count() }})</span>
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade show active" id="city">
                        @include('includes.flash')
                        <div class="row">
                            <div class="col-md-3">
                                <div class="card text-center">
                                    <img class="card-img-top img-fluid" src="{{ $city->image_url }}" alt="{{ $city->name }}">
                                    <div class="card-body">
                                        <a href="{{ route('cities.edit', $city->id) }}" class="btn btn-block btn-main-color">@lang('back.edit')</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="well">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                            <h4 class="text-muted">@lang('back.form-name')</h4>
                                            <h5>{{ $city->name }}</h5>
                                        </li>

                                        <li class="list-group-item">
                                            <h4 class="text-muted">@lang('back.form-status')</h4>
                                            <h5><x-table-switch-status :model="$city"></x-table-switch-status></h5>
                                        </li>

                                        <li class="list-group-item">
                                            <h4 class="text-muted">@lang('back.since')</h4>
                                            <h5>{{ $city->since }}</h5>
                                        </li>

                                        <li class="list-group-item">
                                            <h4 class="text-muted">@lang('back.updated_at')</h4>
                                            <h5>{{ $city->last_update }}</h5>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="products">
                        <table class="table text-center">
                            <thead>
                            <tr>
                                <th scope="row">#</th>
                                <th>@lang('back.form-name')</th>
                                <th>@lang('back.form-image')</th>
                                <th>@lang('back.product-belongs-to')</th>
                                <th>@lang('back.sections.t-section')</th>
                                <th>@lang('back.categories.t-category')</th>
                                <th>@lang('back.form-price')</th>
                                <th>@lang('back.accept-status')</th>
                                <th>@lang('back.since')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($city->cityProducts->sortDesc() as $i => $product)
                                <tr>
                                    <td>{{$i+1}}</td>
                                    <td data-toggle="tooltip" title="{{$product->name}}">
                                        <a href="{{ route('products.show', $product->id) }}">
                                            {!! highlightText($product->name) !!}
                                        </a>
                                    </td>
                                    <td><x-image-link :imageUrl="$product->first_image_url" width="50"></x-image-link></td>
                                    <td>{!! $product->owner_name !!}</td>
                                    <td>
                                        <a href="{{ route('sections.show', $product->section_id) }}">
                                            {!! highlightText($product->section->name) !!}
                                        </a>
                                    </td>
                                    <td>{!! highlightText($product->category->name) !!}</td>
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
                                    <td>{{ $product->since }}</td>
                                </tr>
                            @empty
                                <x-table-alert-no-value></x-table-alert-no-value>
                            @endforelse
                            </tbody>
                            <tfoot>
                            <tr>
                                <th scope="row">#</th>
                                <th>@lang('back.form-name')</th>
                                <th>@lang('back.form-image')</th>
                                <th>@lang('back.product-belongs-to')</th>
                                <th>@lang('back.sections.t-section')</th>
                                <th>@lang('back.categories.t-category')</th>
                                <th>@lang('back.form-price')</th>
                                <th>@lang('back.accept-status')</th>
                                <th>@lang('back.since')</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-model-show-element>
