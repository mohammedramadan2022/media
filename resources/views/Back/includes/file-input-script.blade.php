<script>
    let additional_{{$column}}_images = $('#{{ $column }}');
    let check_{{$column}}_input = $('input[name={{ $column }}]');

    let arr1_{{ $column }}_list = [];
    let arr2_{{ $column }}_list = [];

    @if(isset($currentModel) && $currentModel->$relation->count() > 0)
        $.each(@json($currentModel->$relation->pluck('image', 'id')->toArray()), function(index, name){
            arr1_{{ $column }}_list[index] = "{{ root() }}" + url_public + "storage/uploaded/{{$folder}}/" + name;
            arr2_{{ $column }}_list[index] = {caption: name, key: index};
        });
    @endif

    $("#{{ $selector }}").fileinput(setFileInput(arr1_{{ $column }}_list, arr2_{{ $column }}_list));

    $('.btn.btn-default.btn-outline-secondary.kv-hidden.fileinput-cancel.fileinput-cancel-button > span.hidden-xs').html('حذف الكل');
    $('button.btn-close.fileinput-remove').css('display', 'none');
    $('button.btn.btn-default.btn-outline-secondary.fileinput-remove.fileinput-remove-button > span.hidden-xs').html('حذف الكل');
    // $('.file-drag-handle.drag-handle-init.text-primary').css('display', 'none');
    $('button.close.fileinput-remove').css('display', 'none');

    @if(Route::is($route.'.edit') && (isset($currentModel) && (bool)$currentModel->$column))
        additional_{{$column}}_images.fadeIn();
    @endif

    $('.kv-file-remove.btn.btn-sm.btn-kv.btn-default.btn-outline-secondary').on('click', function(e){
        e.preventDefault();

        let currentImageEl = $(this).parent().parent().parent().parent();

        let id = $(this).data('key');

        swal(setAlertDeleteObject('تنبيه', 'هل انت متأكد من حذف هذه الصورة ؟')).then(function (willDelete) {
            if (!willDelete) { swal(swalObjectTerminated); return; }

            $.ajax({
                method: 'POST',
                url: '{{ route($route.'.ajax-remove-image') }}',
                data: {id},
                success: res => {
                    swal({ title: 'رسالة', text: 'تم حذف الصورة بنجاح', icon: "success", buttons: [false, "حسنا"],});
                    currentImageEl.fadeOut();
                    location.reload();
                },
                error: err => {
                    swal('خطأ', 'خطأ في الخادم', 'warning');
                    console.log(err);
                },
            });
        });
    });

    check_{{$column}}_input.on('change', () => additional_{{$column}}_images.toggle());
</script>
