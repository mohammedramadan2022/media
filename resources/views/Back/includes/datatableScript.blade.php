<script>
    $(document).ready( function () {
        $('#{{ plural_parts($tableName) }}-datatable').DataTable({
            language: languages,
            processing : false,
            autoWidth: false,
            searching: false,
            paging: false,
            info: false,
            columnDefs: [
                { orderable: true, width: '80px', targets: [{{$cols}}] }
            ],
            dom: 'Bfrtip',
            buttons: [
                { extend: 'print', text: '@lang('back.print')' },
                {{--{ extend: 'pdf', text: '@lang('back.pdf-file')' },--}}
                // { extend: 'copy', text: 'نسخ الجدول' },
            ],
        });
        $('.dt-buttons button').addClass('btn btn-secondary');
    });
</script>
