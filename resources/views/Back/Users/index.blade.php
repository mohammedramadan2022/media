<x-model-index-page model="user" :collection="$users">
    <x-slot name="thead">
        <tr>
            <th>#</th>
            <th>@lang('back.form-name')</th>
            <th>@lang('back.form-phone')</th>
            <th>@lang('back.form-email')</th>
            <th>@lang('back.form-status')</th>
            <th>@lang('back.since')</th>
            <th>@lang('back.updated_at')</th>
            <th class="text-center">@lang('back.form-actions')</th>
        </tr>
    </x-slot>
    @foreach($users as $i => $user)
        <tr>
            <td>{{$i+1}}</td>
            <td>
                <a class="text-center" href="{{ route('users.show', $user->id) }}">
                    {!! highlightText($user->full_name) !!}
                    @if($user->created_at->isToday()) <span class="badge text-center badge-danger">@lang('back.new')</span> @endif
                </a>
            </td>
            <td dir="ltr">{!! highlightText(getFormattedPhone($user->phone)) !!}</td>
            <td>{!! highlightText($user->email) !!}</td>
            <td><x-table-switch-status :model="$user"></x-table-switch-status></td>
            <td>{{ $user->since }}</td>
            <td>{{ $user->last_update }}</td>
            <td><x-table-actions modelName="user" :model="$user"></x-table-actions></td>
        </tr>
    @endforeach
    <x-slot name="scripts">
        <script>
            $(document).on('click', '.send-users-notification', function() {
                let modelId = 'view_show_users_send_notification';
                let clickedSalonAnchor = $(this);
                let ajaxUrl = clickedSalonAnchor.attr('href');

                let siteModel = $('div#site-modals');

                $.ajax({
                    type: 'GET',
                    url: ajaxUrl,
                    success: res => {
                        siteModel.html(res);

                        if (res.requestStatus && res.requestStatus === false) {
                            siteModel.html('');
                        } else {
                            $('#' + modelId).modal('show');
                        }
                    },
                    error: x => crud_handle_server_errors(x)
                });
            });

            $(document).on('click', '.send-users-message', function() {
                let modelId = 'view_show_users_send_message';
                let clickedSalonAnchor = $(this);
                let ajaxUrl = clickedSalonAnchor.attr('href');

                let siteModel = $('div#site-modals');

                $.ajax({
                    type: 'GET',
                    url: ajaxUrl,
                    success: res => {
                        siteModel.html(res);

                        if (res.requestStatus && res.requestStatus === false) {
                            siteModel.html('');
                        } else {
                            $('#' + modelId).modal('show');
                        }
                    },
                    error: x => crud_handle_server_errors(x)
                });
            });
        </script>
    </x-slot>
</x-model-index-page>
