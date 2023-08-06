@extends('Back.layouts.master')

@section('title', trans('back.contacts.contacts'))

@section('styles')
    {!! style('admin/libs/summernote/summernote-bs4.css') !!}
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin-panel') }}">@lang('back.dashboard')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('back.contacts.contacts')</li>
                    </ol>
                </div>

                <div class="page-title">
                    <button type="button" class="btn btn-main-color waves-effect waves-info" data-toggle="modal" data-target="#filter-modal">
                        <i class="fa fa-filter"></i>&nbsp;تصفية النتائج
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="row no-gutters">
        <div class="col-sm-6 col-md-4 col-xl-4">
            <x-table-state color="primary" icon="tag" slug="form-total" :count="$contacts->count()"></x-table-state>
        </div>

        <div class="col-sm-6 col-md-4 col-xl-4">
            <x-table-state color="success" icon="check-circle" slug="watched" :count="$contacts->where('is_seen', 1)->count()"></x-table-state>
        </div>

        <div class="col-sm-6 col-md-4 col-xl-4">
            <x-table-state color="danger" icon="clock" slug="new-messages" :count="$contacts->where('is_seen', 0)->count()"></x-table-state>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                @include('includes.flash')
                <div class="card-body">
                    <h4 class="header-title">عرض {{ trans('back.contacts.contacts') }}</h4>
                    <div class="mb-1 mt-1">
                        <a href="{{ route('contacts.export') }}" data-toggle="tooltip" title="@lang('back.export-csv')" class="btn btn-success @if($contacts->count() == 0) disabled @endif"><i class="fa fa-file-excel"></i></a>
                    </div>
                    <br>
                    <table class="table table-bordered dt-responsive nowrap no-footer dtr-inline f-16" id="contacts">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>@lang('back.form-name')</th>
                            <th>@lang('back.form-subject')</th>
                            <th>@lang('back.form-email')</th>
                            <th>@lang('back.type')</th>
                            <th>@lang('back.since')</th>
                            <th>@lang('back.updated_at')</th>
                            <th class="text-center">@lang('back.form-actions')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($contacts as $key => $contact)
                            <tr id="contact-row-{{ $contact->id }}">
                                <td>{{ $key+1 }}</td>

                                <td>{!! highlightText($contact->name) !!}</td>

                                <td>{!! highlightText($contact->subject->name) !!}</td>

                                <td>{!! highlightText($contact->email) !!}</td>

                                <td id="contact-{{$contact->id}}-type">
                                    @if($contact->is_seen)
                                        <label class="badge badge-dark p-1 display-block f-12">@lang('back.old')</label>
                                    @else
                                        <label class="badge badge-danger p-1 display-block f-12">@lang('back.new')</label>
                                    @endif
                                </td>

                                <td>{{ $contact->since }}</td>

                                <td>{{ $contact->last_update }}</td>

                                <td class="text-center">
                                    <div class="btn-group dropdown">
                                        <a href="javascript: void(0);" class="table-action-btn dropdown-toggle btn btn-main-color m-1" data-toggle="dropdown" aria-expanded="false">
                                            <i class="mdi mdi-wrench"></i>&nbsp;&nbsp;<span>@lang('back.more')</span>
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-left">
                                            <a class="dropdown-item message-details-btn" data-id="{{$contact->id}}" href="{{ route('contacts.message-details', $contact->id) }}">
                                                @lang('back.show')
                                                <i class="fa fa-eye"></i>
                                            </a>

                                            <a class="dropdown-item send-user-message-btn" href="{{ route('contacts.send-user-message', $contact->id) }}">
                                                @lang('back.replay')
                                                <i class="fa fa-envelope"></i>
                                            </a>

                                            <a class="dropdown-item delete-action" data-id="{{$contact->id}}" href="{{ localeUrl('/admin-panel/contacts/'.$contact->id) }}">
                                                @lang('back.delete')
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <x-table-alert-no-value></x-table-alert-no-value>
                        @endforelse
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>#</th>
                            <th>@lang('back.form-name')</th>
                            <th>@lang('back.form-subject')</th>
                            <th>@lang('back.form-email')</th>
                            <th>@lang('back.type')</th>
                            <th>@lang('back.since')</th>
                            <th>@lang('back.updated_at')</th>
                            <th class="text-center">@lang('back.form-actions')</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <div style="margin-right: auto;margin-left: auto;">
            {!! $contacts->withQueryString()->links() !!}
        </div>
    </div>

    <div id="filter-modal" class="modal fade show" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-main-color">
                        <i class="fa fa-filter"></i>&nbsp;تصفية نتائج&nbsp;<span>(@lang('back.contacts.contacts'))</span>
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <form id="form-contacts-search" action="{{ route('contacts.search') }}" method="GET">
                    <div class="modal-body">
                        <div class="row align-items-center">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" name="term" value="{{ request('term') ?? ''  }}" class="form-control" placeholder="البحث">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="radio radio-main-color form-check-inline">
                                    <input type="radio" id="newer-to-older" value="newer-to-older" name="sorting" {{ request()->has('sorting') ? (request('sorting') == 'newer-to-older' ? 'checked' : '') : 'checked' }}>
                                    <label for="newer-to-older">من الأحدث للأقدم</label>
                                </div>
                                <div class="radio radio-main-color form-check-inline">
                                    <input type="radio" id="older-to-newer" value="older-to-newer" name="sorting" {{ request()->has('sorting') ? (request('sorting') == 'older-to-newer' ? 'checked' : '') : '' }}>
                                    <label for="older-to-newer">من الأقدم للأحدث</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" form="form-contacts-search" class="btn btn-main-color waves-effect waves-light">تصفية النتائج</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    @include('Back.includes.deleteActionScript', ['model' => 'contact', 'deleteType' => 'force'])

    <script>
        let contacts_table = $('table#contacts');

        contacts_table.on('click', 'a.message-details-btn', function () {
            let clickedMessageAnchor = $(this);
            let ajaxUrl = clickedMessageAnchor.attr('href');
            let siteModel = $('div#site-modals');
            let contactIdType = $('#contact-' + clickedMessageAnchor.data('id') + '-type');
            $.ajax({
                type: 'GET',
                url: ajaxUrl,
                success: response => {
                    siteModel.html(response);

                    contactIdType.html(`<label class="badge badge-dark p-1 display-block f-12">@lang('back.old')</label>`);

                    if (response.requestStatus && response.requestStatus === false) siteModel.html('');

                    else $('#view_message_details').modal('show');
                },
                error: x => crud_handle_server_errors(x)
            });
            return false;
        });

        contacts_table.on('click', 'a.send-user-message-btn', function () {
            let clickedMessageAnchor = $(this);
            let ajaxUrl = clickedMessageAnchor.attr('href');
            let siteModel = $('div#site-modals');
            $.ajax({
                type: 'GET',
                url: ajaxUrl,
                success: response => {
                    siteModel.html(response);

                    if (response.requestStatus && response.requestStatus === false) siteModel.html('');

                    else $('#view_send_message').modal('show');
                },
                error: (x) => crud_handle_server_errors(x)
            });
            return false;
        });
    </script>
@stop
