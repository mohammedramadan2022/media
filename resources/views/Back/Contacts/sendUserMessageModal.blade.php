<div id="view_send_message" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ $message->email }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body" style="float: right;">
                <form id="submitForm" action="{{ route('contacts.users-send-email') }}" method="POST">
                    @csrf
                    <input type="hidden" name="email" value="{{$message->email}}" id="email">
                    <div class="form-group">
                        <label for="message-title">@lang('back.form-title')</label>
                        <input type="text" class="form-control" id="message-title" name="title">
                    </div>
                    <div class="form-group">
                        <label for="sendMessage">@lang('back.form-message')</label>
                        <textarea name="message" id="sendMessage" rows="4" cols="4"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">@lang('back.close')</button>
                <button type="submit" form="submitForm" class="btn btn-primary waves-effect waves-light">@lang('back.send')</button>
            </div>
        </div>
    </div>
</div>

<script>
    CKEDITOR.replace('sendMessage', { height: '400px', extraPlugins: 'forms' });
</script>
