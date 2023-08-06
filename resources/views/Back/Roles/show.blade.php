<x-show-element-layout :title="$role->name" model="role" nameSpace="back">
    <ul class="nav nav-tabs nav-justified">
        <li class="nav-item">
            <a href="#role" data-toggle="tab" aria-expanded="false" class="nav-link active">
                <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                <span class="d-none d-sm-block">@lang('back.roles.t-role')</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="#admins" data-toggle="tab" aria-expanded="false" class="nav-link">
                <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                <span class="d-none d-sm-block">@lang('back.admins.admins') ({{ $role->admins->count() }})</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="#permissions" data-toggle="tab" aria-expanded="false" class="nav-link">
                <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                <span class="d-none d-sm-block">@lang('back.permissions.permissions') ({{ $role->permissions->count() }})</span>
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane fade show active" id="role">
            @include('includes.flash')
            <div class="row">
                <div class="col-md-12">
                    <div class="well">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <h4 class="text-muted">@lang('back.form-name')</h4>
                                <h5>{{ $role->name ?? trans('back.no-value')  }}</h5>
                            </li>

                            <li class="list-group-item">
                                <h4 class="text-muted">@lang('back.form-status')</h4>
                                <h5><x-table-switch-status :model="$role"></x-table-switch-status></h5>
                            </li>

                            <li class="list-group-item">
                                <h4 class="text-muted">@lang('back.since')</h4>
                                <h5>{{ $role->since }}</h5>
                            </li>

                            <li class="list-group-item">
                                <h4 class="text-muted">@lang('back.updated_at')</h4>
                                <h5>{{ $role->last_update }}</h5>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane fade" id="admins">
            <table class="table text-center">
                <thead>
                <tr>
                    <th scope="row">#</th>
                    <th>@lang('back.form-name')</th>
                    <th>@lang('back.form-status')</th>
                    <th>@lang('back.since')</th>
                    <th>@lang('back.updated_at')</th>
                </tr>
                </thead>
                <tbody>
                @forelse($role->admins as $i => $admin)
                    <tr>
                        <th>{{ $i + 1 }}</th>
                        <td><a href="{{ route('admins.show', $admin->id) }}">{{ ucwords($admin->name) }}</a></td>
                        <td><x-model-current-status :model="$admin"></x-model-current-status></td>
                        <td>{{ $admin->since }}</td>
                        <td>{{ $admin->last_update }}</td>
                    </tr>
                @empty
                    <x-table-alert-no-value></x-table-alert-no-value>
                @endforelse
                </tbody>
            </table>
        </div>
        <div role="tabpanel" class="tab-pane fade" id="permissions">
            <div class="card border main-border-color">
                <div class="card-body text-secondary">
                    <h5 class="card-title text-secondary">@lang('back.permissions.permissions')</h5>
                    <div class="well row">
                        @foreach($role->permissions->pluck('permission')->chunk(20)->toArray() as $i => $chunk)
                            <ul class="list-group list-group-flush {{ set_permissions_rows($role->permissions->count()) }}">
                                @foreach($chunk as $index => $route)
                                    <li class="list-group-item">
                                        <h5>{{ trans('crud.' . $route) }}</h5>
                                    </li>
                                @endforeach
                            </ul>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-show-element-layout>
