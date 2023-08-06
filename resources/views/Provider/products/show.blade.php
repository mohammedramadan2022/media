<x-show-element-layout :title="$product->name" model="product" nameSpace="provider">
    <div class="row">
        <div class="col-md-3">
            <div class="card text-center">
                <a href="{{ $product->first_image_url }}" class="image-popup-vertical-fit">
                    <img class="card-img-top img-fluid" src="{{ $product->first_image_url }}" style="width: 80%;" alt="image">
                </a>
                <div class="card-body">
                    <h4 class="card-title">{{ ucwords($product->name) }}</h4>
                    <a href="{{ route('provider.products.edit', $product->id) }}" class="btn btn-block btn-primary">@lang('back.edit')</a>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="well">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <h4 class="text-muted">@lang('back.form-name')</h4>
                        <h5>{{ $product->name ?? trans('back.no-value') }}</h5>
                    </li>

                    <li class="list-group-item">
                        <h4 class="text-muted">@lang('back.sections.t-section')</h4>
                        <h5>{{ $product->section->name ?? trans('back.no-value') }}</h5>
                    </li>

                    <li class="list-group-item">
                        <h4 class="text-muted">@lang('back.categories.t-category')</h4>
                        <h5>{{ $product->category->name ?? trans('back.no-value') }}</h5>
                    </li>

                    <li class="list-group-item">
                        <h4 class="text-muted">@lang('back.cities.t-city')</h4>
                        <h5>{{ $product->city->name ?? trans('back.no-value') }}</h5>
                    </li>

                    <li class="list-group-item">
                        <h4 class="text-muted">@lang('back.form-product-code')</h4>
                        <h5>{{ $product->code ?? trans('back.no-value') }}</h5>
                    </li>

                    <li class="list-group-item">
                        <h4 class="text-muted">@lang('back.form-quantity')</h4>
                        <span class="badge badge-info f-16">{{ $product->qty ?? trans('back.no-value') }}</span>
                    </li>

                    <li class="list-group-item">
                        <h4 class="text-muted">@lang('back.accept-status')</h4>
                        @if($product->is_accepted)
                            <label class="badge badge-success p-2 f-15">@lang('back.accepted') <i class="fa fa-check-circle"></i></label>
                        @else
                            <label class="badge badge-warning p-2 f-15">@lang('back.pending') <i class="fa fa-clock"></i></label>
                        @endif
                    </li>

                    @if($product->has_insurance)
                        <li class="list-group-item">
                            <h4 class="text-muted">@lang('back.form-insurance')</h4>
                            <h5 class="badge badge-warning p-2 f-16">{{ money($product->insurance) }}</h5>
                        </li>
                    @endif

                    <li class="list-group-item">
                        <h4 class="text-muted">@lang('back.form-rate')</h4>
                        <x-rate-stars-review :rate="$product->rate">{{ $product->rates_count }}</x-rate-stars-review>
                    </li>

                    <li class="list-group-item">
                        <h4 class="text-muted">@lang('back.form-price')</h4>
                        <h5>{{ money($product->price) ?? trans('back.no-value') }}</h5>
                    </li>

                    <li class="list-group-item">
                        <h4 class="text-muted">@lang('back.form-description')</h4>
                        <p>{!! $product->description !!}</p>
                    </li>

                    <li class="list-group-item">
                        <h4 class="text-muted">@lang('back.form-rental-terms')</h4>
                        <p>{!! $product->rental_terms !!}</p>
                    </li>

                    <li class="list-group-item">
                        <h4 class="text-muted">@lang('back.form-usage-instructions')</h4>
                        <p>{!! $product->usage_instructions !!}</p>
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
        </div>
    </div>
</x-show-element-layout>
