<div id="view_message_details" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang('back.message-details')</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <h6 class="text-semibold">@lang('back.from') : {{$message->email}}</h6>
                <p>
                    @lang('back.contacts.t-contact') : {{ limit($message->message, '1400') }}
                    @if(str()->length($message->message) > 1400)
                        <a href="{{ route('contacts.show', $message->id) }}">@lang('back.show-more')</a>
                    @endif
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">@lang('back.close')</button>
            </div>
        </div>
    </div>
</div>
