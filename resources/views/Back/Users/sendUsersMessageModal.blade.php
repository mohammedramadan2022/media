<div id="view_show_users_send_message" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">@lang('back.send-a-message')</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{route('users.send-users-message')}}" method="POST" id="send-mail-form">
                    @csrf
                    <div class="form-group">
                        <label for="type">@lang('back.type')</label>
                        <select name="type" id="type" class="form-control @error('title') is-invalid @enderror">
                            <option value="" disabled selected>@lang('back.select-a-value')</option>
                            <option {{ old('type') == 'all' ? 'selected' : '' }} value="all">@lang('back.all')</option>
                            <option {{ old('type') == 'users' ? 'selected' : '' }} value="users">@lang('back.users.users')</option>
                            <option {{ old('type') == 'providers' ? 'selected' : '' }} value="providers">@lang('back.providers.providers')</option>
                        </select>
                        @error('type')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="message-title">@lang('back.form-title')</label>
                        <input type="text" name="title" id="message-title" value="{{old('title')}}" class="form-control"/>
                    </div>
                    <div class="form-group">
                        <label for="editorfullar">@lang('back.form-body')</label>
                        <textarea name="message" id="editorfullar" rows="4" cols="4"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">@lang('back.close')</button>
                <button type="submit" form="send-mail-form" name="submit" class="btn btn-main-color waves-effect waves-light">@lang('back.send')</button>
            </div>
        </div>
    </div>
</div>
<script>
    CKEDITOR.replace('editorfullar', { height: '400px', extraPlugins: 'forms' });
</script>
