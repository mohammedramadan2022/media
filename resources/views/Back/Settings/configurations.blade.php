@extends('Back.layouts.master')

@section('title', trans('back.settings.settings'))

@section('styles')
    {!! style('admin/libs/datatables/dataTables.bootstrap4.css') !!}
    {!! style('admin/libs/datatables/responsive.bootstrap4.css') !!}
    {!! style('admin/libs/jquery-toast/jquery.toast.min.css') !!}
    {!! style('admin/libs/sweetalert2/sweetalert2.min.css') !!}
    {!! style('admin/libs/magnific-popup/magnific-popup.css') !!}
    {!! style('admin/libs/select2/select2.min.css') !!}
    {{ $styles ?? '' }}
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin-panel') }}">@lang('back.dashboard')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('back.settings.settings')</li>
                    </ol>
                </div>

                <div class="page-title">
                    <button type="button" class="btn btn-info waves-effect waves-info" data-toggle="modal" data-target="#filter-modal">
                        <i class="fa fa-filter"></i>&nbsp;تصفية النتائج
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="row no-gutters">
        @if($settings)
            <div class="col-sm-6 col-md-4 col-xl-3">
                <x-table-state color="primary" icon="tag" slug="form-total" :count="(int)$settings->count() + (int)getModelCount('setting', true)"></x-table-state>
            </div>
        @endif

        @if($settings && !no_status_collections('setting'))
            <div class="col-sm-6 col-md-4 col-xl-3">
                <x-table-state color="success" icon="check-circle" slug="actives" :count="$settings->where('status', 1)->count()"></x-table-state>
            </div>
            <div class="col-sm-6 col-md-4 col-xl-3">
                <x-table-state color="danger" icon="clock" slug="deductives" :count="$settings->where('status', 0)->count()"></x-table-state>
            </div>
        @endif

        @if(checkIfTableSoftDeleted('setting'))
            <div class="col-sm-6 col-md-4 col-xl-3">
                <x-table-state color="warning" icon="trash-2" slug="deleteds" :count="getModelCount('setting', true)"></x-table-state>
            </div>
        @endif
    </div>

    <div class="row">
        @include('includes.flash')
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">عرض {{ trans('back.settings.settings') }}</h4>

                    <table id="settings-datatable" class="table table-hover dt-responsive nowrap">
                        <thead>
                            <tr>
                                <th>@lang('back.form-key')</th>
                                <th>@lang('back.form-status')</th>
                                <th class="text-center">@lang('back.form-actions')</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($settings as $i => $setting)
                            <tr>
                                <td>
                                    <a href="{{ route('settings.configurations.show', $setting->id) }}" data-toggle="tooltip" title="{{ $setting->name }}">
                                        {!! highlightText($setting->name) !!}
                                    </a>
                                </td>
                                <td><x-table-switch-status :model="$setting"></x-table-switch-status></td>
                                <td><x-table-action-delete modelName="setting" :model="$setting"></x-table-action-delete></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @if($settings instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div style="margin-right: auto;margin-left: auto;">
                {!! $settings->withQueryString()->links() !!}
            </div>
        @endif
    </div>
@stop

@section('scripts')
    @includeWhen(!dataTableNotIn('setting'), 'Back.includes.datatableScript', ['tableName' => 'settings', 'cols' => 3])

    @includeWhen(!changeStatusNotIn('setting'), 'Back.includes.isChecked', ['model' => 'setting'])

    <script>
        $(document).ready(function(){
            $(document).on("click", ".delete-action", function(e) {
                e.preventDefault();
                let clickedBtn = $(this);
                let datatable = clickedBtn.parents('table').dataTable();
                let id = clickedBtn.data('id');
                let deleteMessage = '{{ trans('back.delete-message-var', ['var' => trans('back.settings.t-setting')]) }}';

                let model = 'setting';
                let force = '{{ trans('back.force-delete-message-title') }}';
                let soft = '{{ trans('back.delete-message-title') }}';

                let deleteMessageTitle = (model === 'notification' || model === 'demand') ? force : soft;

                let ajaxUrl = '{{ route('settings.ajax-delete-setting') }}';

                swal(setAlertDeleteObject(deleteMessage, deleteMessageTitle))
                    .then(function (willDelete) {
                        if (!willDelete) { swal(swalObjectTerminated); return; }

                        $.ajax({
                            type: 'POST',
                            url: ajaxUrl,
                            data: { id },
                            success: response => {
                                if (response.requestStatus) {
                                    clickedBtn.parents('tr').fadeOut('slow', () => datatable.fnDeleteRow($(this)));
                                    swal(response.message, {icon: "success", buttons: [false, '@lang('back.ok')']});
                                }
                            },
                            error: x => crud_handle_server_errors(x)
                        });
                    });
            });
        });
    </script>
@stop
