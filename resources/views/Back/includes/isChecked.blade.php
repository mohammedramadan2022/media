<script>
    $(document).ready(function(){

        let ajaxUrl = '{{ route(plural_parts($model).'.ajax-change-'.plural_parts($model).'-status') }}';

        window.isChecked =(value, id) => {
            if (value === 'checked')
            {
                let checkBoox = $('#checkbox-'+id);

                checkBoox.html('');

                checkBoox.html(getSwitchRender('true', id));

                $('#active-id-' + id).attr('onclick', 'isChecked("null", "' + id + '")');
            }
            else
            {
                let checkBoox = $('#checkbox-'+id);

                checkBoox.html('');

                checkBoox.html(getSwitchRender('false', id));

                $('#active-id-' + id).attr('onclick', 'isChecked("checked", "' + id + '")');
            }

            $.ajax({
                type: 'POST',
                url: ajaxUrl,
                data: {id, value},
                success: res => $.NotificationApp.send("رسالة", res.message, "top-left", "#5ba035", "success"),
                error: (x) => crud_handle_server_errors(x),
            });
        }
    });
</script>
