<x-show-element-layout :title="$product->name" model="product" nameSpace="back">
    <div class="row">
        <div class="col-md-3">
            <div class="card text-center">
                <a href="{{ $product->first_image_url }}" class="image-popup-vertical-fit">
                    <img class="card-img-top img-fluid" src="{{ $product->first_image_url }}" width="100" height="50" alt="image">
                </a>
                <div class="card-body">
                    <h4 class="card-title">{{ ucwords($product->name) }}</h4>
                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-block btn-primary">@lang('back.edit')</a>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="well">
                <div class="row">
                    <div class="col-md-6">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <h4 class="text-muted">@lang('back.form-name')</h4>
                                <h5>{{ $product->name ?? trans('back.no-value')  }}</h5>
                            </li>

                            <li class="list-group-item">
                                <h4 class="text-muted">@lang('back.sections.t-section')</h4>
                                <h5>{{ $product->section->name ?? trans('back.no-value')  }}</h5>
                            </li>

                            <li class="list-group-item">
                                <h4 class="text-muted">@lang('back.categories.t-category')</h4>
                                <h5>{{ $product->category->name ?? trans('back.no-value')  }}</h5>
                            </li>

                            <li class="list-group-item">
                                <h4 class="text-muted">@lang('back.cities.t-city')</h4>
                                <a href="{{ route('cities.show', $product->city_id) }}" class="f-16">
                                    {{ $product->city->name ?? trans('back.no-value')  }}
                                </a>
                            </li>
                            <li class="list-group-item">
                                <h4 class="text-muted">@lang('back.form-product-code')</h4>
                                <h5>{{ $product->code ?? trans('back.no-value')  }}</h5>
                            </li>

                            <li class="list-group-item">
                                <h4 class="text-muted">@lang('back.form-quantity')</h4>
                                <h5>{{ $product->qty ?? trans('back.no-value') }}</h5>
                            </li>

                            <li class="list-group-item">
                                <h4 class="text-muted">@lang('back.form-has-insurance')</h4>
                                @if($product->has_insurance)
                                    <span class="badge badge-success p-2">@lang('back.yes')</span>
                                @else
                                    <span class="badge badge-danger p-2">@lang('back.not')</span>
                                @endif
                            </li>

                            @if($product->has_insurance)
                                <li class="list-group-item">
                                    <h4 class="text-muted">@lang('back.form-insurance')</h4>
                                    <h5 class="badge badge-warning text-dark p-2 f-16">{{ money($product->insurance) }}</h5>
                                </li>
                            @endif

                            <li class="list-group-item">
                                <h4 class="text-muted">@lang('back.rental-status')</h4>
                                @if($product->is_rented)
                                    <span class="badge badge-danger p-2">@lang('back.rented')</span>
                                @else
                                    <span class="badge badge-success p-2">@lang('back.not-rented')</span>
                                @endif
                            </li>

                            <li class="list-group-item">
                                <h4 class="text-muted">@lang('back.accept-status')</h4>
                                @if(is_null($product->is_accepted))
                                    <a href="{{route('products.accept', $product->id)}}" class="btn btn-outline-success">@lang('back.accept')</a>
                                    <a href="{{route('products.reject', $product->id)}}" class="btn btn-outline-danger">@lang('back.refuse')</a>
                                @elseif($product->is_accepted)
                                    <span class="badge badge-success p-2">@lang('back.accepted')</span>
                                @else
                                    <span class="badge badge-danger p-2">@lang('back.refused')</span>
                                @endif
                            </li>

                            <li class="list-group-item">
                                <h4 class="text-muted">@lang('back.form-rate')</h4>
                                <x-rate-stars-review :rate="$product->rate">{{ $product->rates_count }}</x-rate-stars-review>
                            </li>

                            @if($product->has_offer)
                                <li class="list-group-item">
                                    <h4 class="text-muted">@lang('back.form-offer-value')</h4>
                                    <h5>{{ money($product->offer_value) . ' - (' . $product->offer . '%)' ?? trans('back.no-value')  }}</h5>
                                </li>
                            @endif

                            <li class="list-group-item">
                                <h4 class="text-muted">@lang('back.form-price')</h4>
                                <h5>{{ money($product->price) ?? trans('back.no-value')  }}</h5>
                            </li>

                            <li class="list-group-item">
                                <h4 class="text-muted">@lang('back.form-status')</h4>
                                @if($product->status)
                                    <span class="badge badge-success p-2">@lang('back.active')</span>
                                @else
                                    <span class="badge badge-danger p-2">@lang('back.disactive')</span>
                                @endif
                            </li>

                            <li class="list-group-item">
                                <h4 class="text-muted">@lang('back.since')</h4>
                                <h5>{{ $product->since }}</h5>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <h4 class="text-muted">@lang('back.form-description')</h4>
                                <p>{!! $product->description ?? trans('back.no-value') !!}</p>
                            </li>

                            <li class="list-group-item">
                                <h4 class="text-muted">@lang('back.form-rental-terms')</h4>
                                <p>{!! $product->rental_terms ?? trans('back.no-value') !!}</p>
                            </li>

                            <li class="list-group-item">
                                <h4 class="text-muted">@lang('back.form-usage-instructions')</h4>
                                <p>{!! $product->usage_instructions ?? trans('back.no-value') !!}</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-show-element-layout>
