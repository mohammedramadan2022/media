<x-show-element-layout :title="$provider->name" model="provider" nameSpace="back">
    <ul class="nav nav-tabs nav-justified">
        <li class="nav-item">
            <a href="#provider" data-toggle="tab" aria-expanded="false" class="nav-link active">
                <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                <span class="d-none d-sm-block">@lang('back.basic-info')</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="#products" data-toggle="tab" aria-expanded="false" class="nav-link">
                <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                <span class="d-none d-sm-block">@lang('back.products.products') ({{ $provider->products()->count() }})</span>
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane fade show active" id="provider">
            <div class="row">
                <div class="col-md-3">
                    <div class="card text-center">
                        <a href="{{ $provider->logo_url }}" class="image-popup-vertical-fit">
                            <img class="card-img-top img-fluid" src="{{ $provider->logo_url }}" style="width: 70%;" alt="image">
                        </a>
                        <div class="card-body">
                            <h4 class="card-title">{{ ucwords($provider->name) }}</h4>
                            <a href="{{ route('providers.edit', $provider->id) }}" class="btn btn-block btn-primary">@lang('back.edit')</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="well">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <h4 class="text-muted">@lang('back.form-name')</h4>
                                <h5>{{ $provider->name ?? trans('back.no-value') }}</h5>
                            </li>

                            <li class="list-group-item">
                                <h4 class="text-muted">@lang('back.form-store-name')</h4>
                                <h5>{{ $provider->store_name ?? trans('back.no-value') }}</h5>
                            </li>

                            <li class="list-group-item">
                                <h4 class="text-muted">@lang('back.form-identity')</h4>
                                <h5>{{ $provider->identity ?? trans('back.no-value') }}</h5>
                            </li>

                            <li class="list-group-item">
                                <h4 class="text-muted">@lang('back.form-address')</h4>
                                <h5>{{ $provider->address ?? trans('back.no-value') }}</h5>
                            </li>

                            <li class="list-group-item">
                                <h4 class="text-muted">@lang('back.form-phone')</h4>
                                <h5 dir="ltr">{{ getFormattedPhone($provider->phone) ?? trans('back.no-value') }}</h5>
                            </li>

                            <li class="list-group-item">
                                <h4 class="text-muted">@lang('back.form-email')</h4>
                                <h5>{{ $provider->email ?? trans('back.no-value') }}</h5>
                            </li>

                            <li class="list-group-item">
                                <h4 class="text-muted">@lang('back.form-rate')</h4>
                                <x-rate-stars-review :rate="$provider->rate">{{ $provider->rates_count }}</x-rate-stars-review>
                            </li>

                            <li class="list-group-item">
                                <h4 class="text-muted">@lang('back.form-status')</h4>
                                <x-table-switch-status :model="$provider"></x-table-switch-status>
                            </li>

                            <li class="list-group-item">
                                <h4 class="text-muted">@lang('back.since')</h4>
                                <h5>{{ $provider->since }}</h5>
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
                    <th>@lang('back.products.t-product')</th>
                    <th>@lang('back.ownership')</th>
                    <th>@lang('back.form-image')</th>
                    <th>@lang('back.form-price')</th>
                    <th>@lang('back.form-offer-value')</th>
                    <th>@lang('back.form-quantity')</th>
                    <th>@lang('back.since')</th>
                    <th>@lang('back.updated_at')</th>
                </tr>
                </thead>
                <tbody>
                @forelse($provider->products as $i => $product)
                    <tr>
                        <th>{{ $i + 1 }}</th>
                        <td><a href="{{ route('products.show', $product->id) }}">{{ ucwords($product->name) }}</a></td>
                        <td>{!! $product->owner_name !!}</td>
                        <td><x-image-link :imageUrl="$product->first_image_url" width="50"></x-image-link></td>
                        <td>{{ money($product->price) }}</td>
                        <td>
                            @if($product->offer)
                                <span class="badge badge-warning p-2 f-12 display-block text-dark">{{ money($product->offer) }}</span>
                            @else
                                <span class="badge badge-light-dark p-2 display-block">{{ trans('back.no-value') }}</span>
                            @endif
                        </td>
                        <td>{{ $product->qty }}</td>
                        <td>{{ $product->since }}</td>
                        <td>{{ $product->last_update }}</td>
                    </tr>
                @empty
                    <x-table-alert-no-value></x-table-alert-no-value>
                @endforelse
                </tbody>
                <tfoot>
                <tr>
                    <th scope="row">#</th>
                    <th>@lang('back.products.t-product')</th>
                    <th>@lang('back.ownership')</th>
                    <th>@lang('back.form-image')</th>
                    <th>@lang('back.form-price')</th>
                    <th>@lang('back.form-offer-value')</th>
                    <th>@lang('back.form-quantity')</th>
                    <th>@lang('back.since')</th>
                    <th>@lang('back.updated_at')</th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</x-show-element-layout>
