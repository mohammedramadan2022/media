@extends('Back.layouts.master')

@section('title', trans('back.trashed'))

@section('styles')
    {!! style('admin/libs/datatables/dataTables.bootstrap4.css') !!}
    {!! style('admin/libs/datatables/responsive.bootstrap4.css') !!}
    {!! style('admin/libs/jquery-toast/jquery.toast.min.css') !!}
    {!! style('admin/libs/sweetalert2/sweetalert2.min.css') !!}
    {!! style('admin/libs/magnific-popup/magnific-popup.css') !!}
    {!! style('admin/libs/select2/select2.min.css') !!}
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin-panel') }}">@lang('back.dashboard')</a></li>
                        <li class="breadcrumb-item"><a href="{{ route(plural_parts($model).'.index') }}">@lang('back.'.plural_parts($model).'.'.plural_parts($model))</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('back.trashed')</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="card-box table-responsive m-2" dir="{{ direction() }}">
        @include('includes.flash')

        <div class="card-body">
            <table class="table table-bordered dt-responsive nowrap no-footer dtr-inline f-16" id="{{ plural_parts($model) }}">
                <thead>
                    {{ $thead ?? '' }}
                </thead>
                <tbody>
                    {{ $slot ?? '' }}
                </tbody>
                <tfoot>
                    {{ $thead ?? '' }}
                </tfoot>
            </table>
        </div>
    </div>
@stop

@section('scripts')
    {!! script('admin/libs/datatables/jquery.dataTables.min.js') !!}
    {!! script('admin/libs/datatables/dataTables.bootstrap4.js') !!}
    {!! script('admin/libs/datatables/dataTables.responsive.min.js') !!}
    {!! script('admin/libs/datatables/dataTables.buttons.min.js') !!}
    {!! script('admin/libs/datatables/buttons.print.min.js') !!}
    {!! script('admin/libs/magnific-popup/jquery.magnific-popup.min.js') !!}
    {!! script('admin/js/pages/lightbox.init.js') !!}
    <script>
        $(document).ready(function(){
            $(document).on('click', '.force-delete-btn', async function(e){
                e.preventDefault();

                let clickedBtn = $(this);
                let deleteMessage = '{{ trans('back.delete-message-var', ['var' => trans('back.'.plural_parts($model).'.t-'.plural_parts($model)->singular())]) }}';
                let deleteMessageTitle = '{{ trans('back.force-delete-message-title') }}';
                let href = clickedBtn.attr('href');

                let willDelete = await swal(setAlertDeleteObject(deleteMessage, deleteMessageTitle));

                if(!willDelete) {
                    swal(swalObjectTerminated);
                    return;
                }

                window.location.href = href
            });
        });
    </script>
    {{ $scripts ?? '' }}
@stop
