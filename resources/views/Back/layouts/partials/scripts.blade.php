{!! script('admin/js/vendor.min.js') !!}
{!! script('admin/libs/jquery-knob/jquery.knob.min.js') !!}
{!! script('admin/js/app.min.js') !!}
{!! script('assets/js/sweetalert.min.js') !!}

{!! script('assets/js/crud.js') !!}
{!! script('assets/js/jquery.form.js') !!}
{!! script('assets/js/scripts.js') !!}
{!! script('assets/js/lang.min.js') !!}
{!! script('admin/libs/select2/select2.min.js') !!}

{!! script('admin/libs/jquery-nice-select/jquery.nice-select.min.js') !!}
{!! script('admin/libs/switchery/switchery.min.js') !!}
{!! script('admin/libs/select2/select2.min.js') !!}
{!! script('admin/libs/bootstrap-select/bootstrap-select.min.js') !!}
{!! script('admin/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js') !!}
{!! script('admin/libs/bootstrap-maxlength/bootstrap-maxlength.min.js') !!}
{!! script('admin/libs/jquery-toast/jquery.toast.min.js') !!}
{!! script('admin/libs/magnific-popup/jquery.magnific-popup.min.js') !!}
{!! script('admin/js/pages/toastr.init.js') !!}
{!! script('admin/libs/morris-js/morris.min.js') !!}c
{!! script('admin/libs/raphael/raphael.min.js') !!}

{!! script('admin/js/pages/form-advanced.init.js') !!}
{!! script('admin/libs/dropify/dropify.min.js') !!}
{!! script('admin/js/pages/form-fileupload.init.js') !!}

{!! script('assets/js/jquery.print.js') !!}
{!! script('assets/js/HoldOn.min.js') !!}

<script src="https://cdn.socket.io/4.5.4/socket.io.min.js"></script>

<script>
    $(document).ready(function() {
        window.url_public = '{{ app()->isProduction() ? '/public/' : '/' }}';

        window.rootPath = '{{ root() }}/' + '{{ getLocale() }}/admin-panel';

        window.languages = {
            "paginate": {
                "previous": "@lang('pagination.previous')",
                "next": "@lang('pagination.next')",
                "first": "@lang('datatables.first')",
                "last": "@lang('datatables.last')",
            },
            "search": "@lang('datatables.search') : ",
            "infoEmpty": "@lang('datatables.emptyshowing')",
            "info": "@lang('datatables.showResult')",
            "emptyTable": "@lang('datatables.no-data-available')",
            "infoFiltered": "@lang('datatables.infoFiltered')",
            "zeroRecords": "@lang('datatables.zeroRecords')",
            "loadingRecords": "&nbsp;",
            "processing"	: "<i class='fa fa-3x fa-asterisk fa-spin'></i>"
        };

        $('.select2').select2();

        $('.btn.btn-default.btn-outline-secondary.kv-hidden.fileinput-cancel.fileinput-cancel-button > span.hidden-xs').html('حذف الكل');
        $('button.btn-close.fileinput-remove').css('display', 'none');
        $('button.btn.btn-default.btn-outline-secondary.fileinput-remove.fileinput-remove-button > span.hidden-xs').html('حذف الكل');
        // $('.file-drag-handle.drag-handle-init.text-primary').css('display', 'none');
        $('button.close.fileinput-remove').remove();
        $('.file-drop-zone-title').html('اسحب وافلت الملفات هنا ...');
        $('.input-group-btn.input-group-append > .btn.btn-primary.btn-file span').html('إختر الملفات');
        $('.dropify-message p').html('اسحب وافلت الملفات هنا');
        $('.dropify-wrapper .dropify-message p.dropify-error').html('حدث خطأ ما');

        window.wordInString = (s, word) => new RegExp('\\b' + word + '\\b', 'i').test(s);

        window.setFileInput = function(arr1, arr2){
            return {
                'showUpload': false,
                initialPreview: arr1,
                maxFileCount: 10,
                validateInitialCount: true,
                initialPreviewAsData: true,
                initialPreviewConfig: arr2,
                overwriteInitial: false,
                initialCaption: "حدد الملفات ..."
            };
        }

        let iformat = (icon) => $('<span><i class="{{ config('icons.class') }} ' + $(icon.element).data('icon') + '"></i> ' + icon.text + '</span>');

        $('.icons_select2').select2({ width: "100%", templateSelection: iformat, templateResult: iformat, allowHtml: true });

        window.swalObjectTerminated = {title: "@lang('back.a-message')", text: "@lang('back.operation-terminated')", icon: "success", button: "@lang('back.ok')"};
    });
</script>
