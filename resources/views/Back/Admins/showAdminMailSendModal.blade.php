<div id="view_show_admin_send_message" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" dir="{{direction()}}">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">@lang('back.send-a-message')</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>

            <div class="modal-body">
                <form action="{{ route('admins.send-message') }}" method="post" id="sendMessageForm">
                    @csrf
                    <input type="hidden" name="email" value="{{ $admin->email }}">
                    <div class="form-group">
                        <label for="message-title">@lang('back.form-title')</label>
                        <input type="text" name="title" id="message-title" value="{{old('title')}}" class="form-control @error('title') is-invalid @enderror"/>
                    </div>
                    <div class="form-group">
                        <label for="admin-message">@lang('back.contacts.t-contact')</label>
                        <textarea name="message" id="admin-message" rows="5" class="form-control @error('message') is-invalid @enderror" cols="4">{{old('message')}}</textarea>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">@lang('back.close')</button>
                <button type="submit" form="sendMessageForm" name="submit" class="btn btn-primary waves-effect waves-light">@lang('back.send')</button>
            </div>
        </div>
    </div>
</div>

<script>
    CKEDITOR.replace('admin-message', { height: '400px', extraPlugins: 'forms' });
</script>
