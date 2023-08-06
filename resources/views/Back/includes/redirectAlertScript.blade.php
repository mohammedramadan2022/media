<script>
    let selectedClass = '{{ $class }}';

    $('.' + selectedClass).on('click', async function(e){
        e.preventDefault();

        let href = $(this).attr('href');

        let message = ($(this).data('type') === 'block') ? "@lang('back.confirm-block-account')" : "@lang('back.confirm-unblock-account')";

        let willDelete = await swal({
            title: '@lang('back.a-message')',
            text: message,
            icon: "warning",
            buttons: ['@lang('back.close')', '@lang('back.confirm')'],
            dangerMode: true
        });

        if (!willDelete) {
            await swal({ title: "@lang('back.a-message')", text: "@lang('back.operation-terminated')", icon: "success", button: "@lang('back.ok')",});
            return;
        }

        window.location.href = href;
    });
</script>
