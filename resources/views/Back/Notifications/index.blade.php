<x-model-index-page model="notification" :collection="$notifications">
    <x-slot name="thead">
        <tr>
            <th>#</th>
            <th>@lang('back.send-to')</th>
            <th>@lang('back.form-title')</th>
            <th>@lang('back.form-body')</th>
            <th class="text-center">@lang('back.form-actions')</th>
        </tr>
    </x-slot>
    @forelse($notifications as $i => $notification)
        <tr>
            <td>{{$i+1}}</td>
            <td>
                @if($notification->notificationable_type == 'App\Models\Admin')
                    <label class="badge p-2 f-12 badge-danger">@lang('back.administration')</label>
                @else
                    <a href="{{ route(tableName($notification->notificationable_type).'.show', $notification->notificationable_id) }}">
                        {{ $notification->notificationable->username ?? trans('back.no-value') }}
                    </a>
                @endif
            </td>
            <td>{!! highlightText($notification->title) !!}</td>
            <td title="{{ $notification->body }}" data-toggle="tooltip">{!! highlightText($notification->body) !!}</td>
            <td><a data-id="{{ $notification->id }}" href="javascript:void(0);" class="btn btn-danger delete-action"><i class="fa fa-trash fa-1x"></i></a></td>
        </tr>
    @empty
        <x-table-alert-no-value></x-table-alert-no-value>
    @endforelse
</x-model-index-page>
