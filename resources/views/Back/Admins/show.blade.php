<x-show-element-layout :title="$admin->name" model="admin" nameSpace="back">
    <ul class="nav nav-tabs nav-justified">
        <li class="nav-item">
            <a href="#admin" data-toggle="tab" aria-expanded="false" class="nav-link active">
                <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                <span class="d-none d-sm-block">@lang('back.basic-info')</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="#vacations" data-toggle="tab" aria-expanded="false" class="nav-link">
                <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                <span class="d-none d-sm-block">@lang('back.vacations.vacations') ({{ $admin->vacations()->count() }})</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="#advances" data-toggle="tab" aria-expanded="false" class="nav-link">
                <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                <span class="d-none d-sm-block">@lang('back.advances.advances') ({{ $admin->advances()->count() }})</span>
            </a>
        </li>
    </ul>

    <div class="tab-content">
        <div role="tabpanel" class="tab-pane fade show active" id="admin">
            <div class="row">
                <div class="col-md-3">
                    <div class="card text-center">
                        <a href="{{ $admin->image_url }}" class="image-popup-vertical-fit">
                            <img class="card-img-top img-fluid" src="{{ $admin->image_url }}" width="100" height="50" alt="image">
                        </a>
                        <div class="card-body">
                            <h4 class="card-title">{{ ucwords($admin->name) }}</h4>
                            <a href="{{ route('admins.edit', $admin->id) }}" class="btn btn-block btn-primary">@lang('back.edit')</a>
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
                                <a onclick="event.preventDefault();" class="btn btn-info send-admin-message" href="{{ route('admins.show-message', $admin->id) }}">
                                    <i class="fa fa-envelope"></i>
                                    {{ $admin->email }}
                                </a>
                            </li>

                            <li class="list-group-item">
                                <h4 class="text-muted">@lang('back.form-phone')</h4>
                                <h5>{{ $admin->phone ?? trans('back.no-value')  }}</h5>
                            </li>

                            <li class="list-group-item">
                                <h4 class="text-muted">@lang('back.roles.t-role')</h4>
                                <h5>
                                    <a href="{{ route('roles.show', $admin->role_id) }}">
                                        {{ ucwords($admin->role->name) ?? trans('back.no-value') }}
                                    </a>
                                </h5>
                            </li>

                            <li class="list-group-item">
                                <h4 class="text-muted">@lang('back.form-status')</h4>
                                <x-table-switch-status :model="$admin"></x-table-switch-status>
                            </li>

                            <li class="list-group-item">
                                <h4 class="text-muted">@lang('back.since')</h4>
                                <h5>{{ $admin->since }}</h5>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane fade" id="vacations">
            <table class="table text-center">
                <thead>
                <tr>
                    <th scope="row">#</th>
                    <th>@lang('back.vacationTypes.t-vacationType')</th>
                    <th>@lang('back.form-reason')</th>
                    <th>@lang('back.form-days')</th>
                    <th>@lang('back.form-from')</th>
                    <th>@lang('back.form-to')</th>
                    <th>@lang('back.accept-status')</th>
                    <th>@lang('back.since')</th>
                    <th>@lang('back.updated_at')</th>
                </tr>
                </thead>
                <tbody>
                @forelse($admin->vacations->sortDesc() as $i => $vacation)
                    <tr>
                        <th>{{ $i + 1 }}</th>
                        <td>{!! highlightText($vacation->vacationType->name) !!}</td>
                        <td>{!! highlightText($vacation->reason) !!}</td>
                        <td>{!! highlightText($vacation->days) !!}</td>
                        <td>{!! highlightText($vacation->from->format('Y-m-d')) !!}</td>
                        <td>{!! highlightText($vacation->to->format('Y-m-d')) !!}</td>
                        <td>
                            @if(is_null($vacation->is_accepted))
                                <a href="{{ route('vacations.accept', $vacation->id) }}" class="btn btn-outline-success">@lang('back.accept')</a>
                                <a href="{{ route('vacations.refuse', $vacation->id) }}" class="btn btn-outline-danger">@lang('back.refuse')</a>
                            @elseif($vacation->is_accepted == 1)
                                <span class="badge p-2 badge-success">@lang('back.accepted')</span>
                            @else
                                <span class="badge p-2 badge-danger">@lang('back.refused')</span>
                            @endif
                        </td>
                        <td>{{ $vacation->since }}</td>
                        <td>{{ $vacation->last_update }}</td>
                    </tr>
                @empty
                    <x-table-alert-no-value></x-table-alert-no-value>
                @endforelse
                </tbody>
                <tfoot>
                <tr>
                    <th scope="row">#</th>
                    <th>@lang('back.vacationTypes.t-vacationType')</th>
                    <th>@lang('back.form-reason')</th>
                    <th>@lang('back.form-days')</th>
                    <th>@lang('back.form-from')</th>
                    <th>@lang('back.form-to')</th>
                    <th>@lang('back.accept-status')</th>
                    <th>@lang('back.since')</th>
                    <th>@lang('back.updated_at')</th>
                </tr>
                </tfoot>
            </table>
        </div>
        <div role="tabpanel" class="tab-pane fade" id="advances">
            <table class="table text-center">
                <thead>
                <tr>
                    <th scope="row">#</th>
                    <th>@lang('back.form-amount')</th>
                    <th>@lang('back.form-reason')</th>
                    <th>@lang('back.form-installment-period')</th>
                    <th>@lang('back.form-date')</th>
                    <th>@lang('back.accept-status')</th>
                    <th>@lang('back.since')</th>
                    <th>@lang('back.updated_at')</th>
                </tr>
                </thead>
                <tbody>
                @forelse($admin->advances->sortDesc() as $i => $advance)
                    <tr>
                        <th>{{ $i + 1 }}</th>
                        <td>{{ money($advance->amount) }}</td>
                        <td>{{ ucwords($advance->reason) }}</td>
                        <td>{{ ucwords($advance->installment_period_year) }}</td>
                        <td>{{ ucwords($advance->date->format('Y-m-d')) }}</td>
                        <td>
                            @if(is_null($advance->is_accepted))
                                <a href="{{ route('advances.accept', $advance->id) }}" class="btn btn-outline-success">@lang('back.accept')</a>
                                <a href="{{ route('advances.refuse', $advance->id) }}" class="btn btn-outline-danger">@lang('back.refuse')</a>
                            @elseif($advance->is_accepted == 1)
                                <span class="badge p-2 badge-success">@lang('back.accepted')</span>
                            @else
                                <span class="badge p-2 badge-danger">@lang('back.refused')</span>
                            @endif
                        </td>
                        <td>{{ $advance->since }}</td>
                        <td>{{ $advance->last_update }}</td>
                    </tr>
                @empty
                    <x-table-alert-no-value></x-table-alert-no-value>
                @endforelse
                </tbody>
                <tfoot>
                <tr>
                    <th scope="row">#</th>
                    <th>@lang('back.form-amount')</th>
                    <th>@lang('back.form-reason')</th>
                    <th>@lang('back.form-installment-period')</th>
                    <th>@lang('back.form-date')</th>
                    <th>@lang('back.accept-status')</th>
                    <th>@lang('back.since')</th>
                    <th>@lang('back.updated_at')</th>
                </tr>
                </tfoot>
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
                    <form action="{{ route('admins.send-notification') }}" method="POST" id="send-notification-form">
                        @csrf
                        <input type="hidden" name="admin_id" value="{{ $admin->id }}">
                        <div class="form-group">
                            <label for="title">@lang('back.form-title')</label>
                            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror">
                            @error('title')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
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
        @include('Back.includes.showModelScript', ['class' => 'send-admin-message', 'modelId' => 'view_show_admin_send_message'])
    </x-slot>
</x-show-element-layout>
