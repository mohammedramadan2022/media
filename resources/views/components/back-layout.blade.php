@props(['model', 'collection'])

@extends(checkUrlHas('provider-panel') ? 'Provider.layouts.master' : 'Back.layouts.master')

@section('title', trans('back.'.plural_parts($model).'.'.plural_parts($model)))

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
    {{ $slot }}
@stop

@section('scripts')
    {!! script('admin/libs/datatables/jquery.dataTables.min.js') !!}
    {!! script('admin/libs/datatables/dataTables.bootstrap4.js') !!}
    {!! script('admin/libs/datatables/dataTables.responsive.min.js') !!}
    {!! script('admin/libs/datatables/dataTables.buttons.min.js') !!}
    {!! script('admin/libs/datatables/buttons.print.min.js') !!}
    {!! script('admin/libs/magnific-popup/jquery.magnific-popup.min.js') !!}
    {!! script('admin/js/pages/lightbox.init.js') !!}

    @includeWhen(!dataTableNotIn($model), 'Back.includes.datatableScript', ['tableName' => plural_parts($model), 'cols' => $collection->first()->cols ?? 5])

    @includeWhen(!changeStatusNotIn($model), 'Back.includes.isChecked', ['model' => $model])

    {!! script('admin/libs/select2/select2.min.js') !!}

    <script>
        $(document).ready(function() {
            $(document).on("click", ".delete-action", async function(e) {
                e.preventDefault();
                let clickedBtn = $(this);
                let datatable = clickedBtn.parents('table').dataTable();
                let id = clickedBtn.data('id');
                let deleteMessage = '{{ trans('back.delete-message-var', ['var' => trans('back.'.plural_parts($model).'.t-'.$model)]) }}';

                let model = '{{ $model }}';
                let force = '{{ trans('back.force-delete-message-title') }}';
                let soft = '{{ trans('back.delete-message-title') }}';

                let deleteMessageTitle = (model === 'notification' || model === 'demand') ? force : soft;

                let ajaxUrl = '{{ route(plural_parts($model).'.ajax-delete-'.plural_parts($model)->singular()) }}';

                let willDelete = await swal(setAlertDeleteObject(deleteMessage, deleteMessageTitle));

                if(!willDelete) { await swal(swalObjectTerminated); return; }

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
    </script>

    {{ $scripts ?? '' }}
@stop
