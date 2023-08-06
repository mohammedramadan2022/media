<x-show-element-layout :title="$user->full_name" model="user" nameSpace="back">
    <ul class="nav nav-tabs nav-justified">
        <li class="nav-item">
            <a href="#user" data-toggle="tab" aria-expanded="false" class="nav-link active">
                <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                <span class="d-none d-sm-block">@lang('back.basic-info')</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="#notifications" data-toggle="tab" aria-expanded="false" class="nav-link">
                <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                <span class="d-none d-sm-block">@lang('back.notifications.notifications') ({{ $user->notifications()->count() }})</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="#orders" data-toggle="tab" aria-expanded="false" class="nav-link">
                <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                <span class="d-none d-sm-block">@lang('back.orders.orders') ({{ $user->orders()->count() }})</span>
            </a>
        </li>
    </ul>

    <div class="tab-content">
        <div role="tabpanel" class="tab-pane fade show active" id="user">
            <div class="row">
                <div class="col-md-3">
                    <div class="card text-center">
                        <img class="card-img-top img-fluid" src="{{ $user->image_url }}" alt="{{ $user->full_name }}">
                        <div class="card-body">
                            <h4 class="card-title">{{ ucwords($user->full_name) }}</h4>

                            <p class="card-text">
                                <span class="text-muted">{{ $user->email ?? trans('back.no-value') }}</span>
                            </p>

                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-block btn-main-color">@lang('back.edit')</a>

                            @if($user->is_blocked)
                                <a href="{{ route('users.unblock', $user->id) }}" data-type="unblock" class="btn btn-block btn-primary blockUser">
                                    <i class="fa fa-ban fa-1x"></i> @lang('back.unblock')
                                </a>
                            @else
                                <a href="{{ route('users.block', $user->id) }}" data-type="block" class="btn btn-block btn-dark blockUser">
                                    <i class="fa fa-ban fa-1x"></i> @lang('back.block')
                                </a>
                            @endif
                            <button class="btn btn-success btn-block" data-toggle="modal" data-target="#view_show_user_send_notification">
                                <i class="fa fa-bell fa-1x"></i> @lang('back.send-notification')
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="well">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <h4 class="text-muted">@lang('back.form-email')</h4>
                                <a onclick="event.preventDefault();" class="btn btn-info send-user-message" href="{{ route('users.show-message', $user->id) }}">
                                    <i class="fa fa-envelope"></i>
                                    {{ $user->email }}
                                </a>
                            </li>

                            <li class="list-group-item">
                                <h4 class="text-muted">@lang('back.form-name')</h4>
                                <h5>{{ $user->full_name ?? trans('back.no-value') }}</h5>
                            </li>

                            <li class="list-group-item">
                                <h4 class="text-muted">@lang('back.form-phone')</h4>
                                <h5 dir="ltr">{{ getFormattedPhone($user->phone) ?? trans('back.no-value') }}</h5>
                            </li>

                            @if($user->whatsapp)
                                <li class="list-group-item">
                                    <h4 class="text-muted">@lang('back.form-whatsapp')</h4>
                                    <h5 dir="ltr">{{ getFormattedPhone($user->whatsapp) ?? trans('back.no-value') }}</h5>
                                </li>
                            @endif

                            <li class="list-group-item">
                                <h4 class="text-muted">@lang('back.block-status')</h4>
                                <h5>
                                    @if($user->is_blocked)
                                        <label class="badge badge-danger" style="font-size: 15px; padding: 10px;">@lang('back.blocked')</label>
                                    @else
                                        <label class="badge badge-success" style="font-size: 15px; padding: 10px;">@lang('back.not-blocked')</label>
                                    @endif
                                </h5>
                            </li>

                            <li class="list-group-item">
                                <h4 class="text-muted">@lang('back.form-status')</h4>
                                <h5><x-table-switch-status :model="$user"></x-table-switch-status></h5>
                            </li>

                            <li class="list-group-item">
                                <h4 class="text-muted">@lang('back.since')</h4>
                                <h5>{{ $user->since }}</h5>
                            </li>

                            <li class="list-group-item">
                                <h4 class="text-muted">@lang('back.updated_at')</h4>
                                <h5>{{ $user->last_update }}</h5>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane fade" id="orders">
            <table class="table text-center">
                <thead>
                <tr>
                    <th scope="row">#</th>
                    <th>@lang('back.form-order-no')</th>
                    <th>@lang('back.form-total-without-tax')</th>
                    <th>@lang('back.form-tax')</th>
                    <th>@lang('back.form-subtotal')</th>
                    <th>@lang('back.discount')</th>
                    <th>@lang('back.form-order-total')</th>
                    <th>@lang('back.form-status')</th>
                    <th>@lang('back.since')</th>
                    <th>@lang('back.updated_at')</th>
                </tr>
                </thead>
                <tbody>
                @forelse($user->orders->sortDesc() as $i => $order)
                    <tr>
                        <th>{{ $i + 1 }}</th>
                        <td><a href="{{ route('orders.show', $order->id) }}">{{ $order->order_no }}</a></td>
                        <td>{{ money($order->price) }}</td>
                        <td>{{ money($order->tax) }}</td>
                        <td>{{ money($order->subtotal) }}</td>
                        <td>{{ money($order->discount) }}</td>
                        <td>{{ money($order->total) }}</td>
                        <td><x-order-status :order="$order"></x-order-status></td>
                        <td>{{ $order->since }}</td>
                        <td>{{ $order->last_update }}</td>
                    </tr>
                @empty
                    <x-table-alert-no-value></x-table-alert-no-value>
                @endforelse
                </tbody>
            </table>
        </div>
        <div role="tabpanel" class="tab-pane fade" id="notifications">
            <table class="table text-center">
                <thead>
                <tr>
                    <th scope="row">#</th>
                    <th>@lang('back.form-title')</th>
                    <th>@lang('back.form-body')</th>
                    <th>@lang('back.since')</th>
                    <th>@lang('back.updated_at')</th>
                </tr>
                </thead>
                <tbody>
                @forelse($user->notifications->sortDesc() as $i => $notification)
                    <tr>
                        <th>{{ $i + 1 }}</th>
                        <td>{{ ucwords($notification->title) }}</td>
                        <td>{{ ucwords($notification->body) }}</td>
                        <td>{{ $notification->since }}</td>
                        <td>{{ $notification->last_update }}</td>
                    </tr>
                @empty
                    <x-table-alert-no-value></x-table-alert-no-value>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div id="view_show_user_send_notification" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">@lang('back.send-notification')</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('users.send-notification') }}" method="POST" id="send-notification-form">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                        <div class="form-group">
                            <label for="title">@lang('back.form-title')</label>
                            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror">
                            @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="body">@lang('back.form-body')</label>
                            <textarea name="body" id="body" rows="5" class="form-control @error('body') is-invalid @enderror"></textarea>
                            @error('body')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">@lang('back.close')</button>
                    <button type="submit" form="send-notification-form" name="submit" class="btn btn-main-color waves-effect waves-light">@lang('back.send')</button>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
        @include('Back.includes.showModelScript', ['class' => 'send-user-message', 'modelId' => 'view_show_user_send_message'])
        @include('Back.includes.redirectAlertScript', ['class' => 'blockUser'])
    </x-slot>
</x-show-element-layout>
