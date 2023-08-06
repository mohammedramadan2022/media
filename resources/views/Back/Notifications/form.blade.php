@include('Back.includes.translate', ['fields' =>[
    translatedField('title', 'text', 'form-title'),
    translatedField('body', 'textarea', 'form-body'),
]])

<div class="form-group">
    <x-form.select-input :arr="$types" name="type" slug="type"></x-form.select-input>
</div>

<div class="form-group" id="notificationable" style="display: none;">
    <label for="fcm" id="notificationable_label">Select</label>
    <select name="fcm" id="fcm" class="form-control form-data select2">
        <option value="" selected disabled>@lang('back.select-a-value')</option>
    </select>
</div>

@section('scripts')
    <script>
        $('#type').on('change', function(){
            let selected = $(this).val();
            let notificationable = $('#notificationable');
            let fcm = $('#fcm');
            let notificationable_label = $('#notificationable_label');
            let label_text = selected === 'user' ? '{{ trans('back.users.t-user') }}' : '{{ trans('back.providers.t-provider') }}';

            if(selected === 'user' || selected === 'provider')
            {
                $.ajax({
                    url: '{{ route('notifications.ajax-get-list-by-type') }}',
                    method: 'POST',
                    data: {selected},
                    success: response => {
                        notificationable.css('display', 'inline');
                        notificationable_label.text(label_text);
                        fcm.html('');

                        let Html = `<option value="" selected disabled>@lang('back.select-a-value')</option>`;

                        $.each(response.data, function(index, el){
                            Html += `<option value="${el.fcm}">${el.full_name}</option>`;
                        });

                        fcm.append(Html);
                    },
                    error: err => console.log(err),
                });
            }
            else
            {
                notificationable.hide();
            }
        });
    </script>
@stop
