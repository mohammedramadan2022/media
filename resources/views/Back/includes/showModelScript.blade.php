<script>
    let mainClass = '{{ $class }}';

    $('.' + mainClass).on('click', function()
    {
        let modelId = '{{ $modelId }}';
        let clickedSalonAnchor = $(this);
        let ajaxUrl = clickedSalonAnchor.attr('href');
        let siteModel = $('div#site-modals');

        $.ajax({
            type: 'GET',
            url: ajaxUrl,
            success: function(response)
            {
                siteModel.html(response);

                if (response.requestStatus && response.requestStatus === false)
                {
                    siteModel.html('');
                }
                else
                {
                    $('#' + modelId).modal('show');
                }
            },
            error: x => crud_handle_server_errors(x)
        });
    });
</script>
