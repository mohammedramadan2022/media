<script>
    let currentTable = '{{ plural($model) }}';
    let currentModel = '{{ $model }}';
    let deleteMessage = '{{ trans('back.delete-message-var', ['var' => trans('back.'.plural($model).'.t-'.lower($model))]) }}';
    let deleteMessageTitle = '{{ isset($deleteType) ? trans('back.force-delete-message-title') : trans('back.delete-message-title') }}';

    let deleteUrl = '{{ route(plural($model).'.ajax-delete-'.$model) }}';

    $('a.delete-action').on('click', function (e) {
        let id = $(this).data('id');

        e.preventDefault();

        swal({
            title: deleteMessage,
            text: deleteMessageTitle,
            icon: "warning",
            buttons: ["إلغاء", "متأكد"],
            dangerMode: true
        })
        .then((willDelete) => {
            if (willDelete) {
                let tbody = $(`table#${currentTable} tbody`);
                let count = tbody.data('count');

                $.ajax({
                    type: 'POST',
                    url: deleteUrl,
                    data: {id},
                    success: response => {
                        if (response.requestStatus) {
                            $(`#${currentModel}-row-${id}`).fadeOut();
                            count = count - 1;
                            tbody.attr('data-count', count);
                            swal(response.message, {icon: "success"});
                            return;
                        }

                        swal(response.error);
                    },
                    error: x => crud_handle_server_errors(x),
                    complete: function () {
                        if (count === 1) tbody.append(`<tr><td colspan="5"><strong>No data available in table</strong></td></tr>`);
                    }
                });

                return;
            }

            swal({
                title: "@lang('back.a-message')",
                text: "@lang('back.operation-terminated')",
                icon: "success",
                button: "@lang('back.ok')",
            });
        });
    });
</script>
