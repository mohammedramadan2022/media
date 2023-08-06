<div id="view_show_users_send_notification" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">@lang('back.send-notification')</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{route('users.send-users-notification')}}" method="POST" id="send-users-notification-form">
                    @csrf
                    <div class="form-group">
                        <label for="type">@lang('back.type')</label>
                        <select name="type" id="type" class="form-control @error('title') is-invalid @enderror">
                            <option value="" disabled selected>@lang('back.select-a-value')</option>
                            <option {{ old('type') == 'all' ? 'selected' : '' }} value="all">@lang('back.all')</option>
                            <option {{ old('type') == 'users' ? 'selected' : '' }} value="users">@lang('back.users.users')</option>
                            <option {{ old('type') == 'trainers' ? 'selected' : '' }} value="providers">@lang('back.trainers.trainers')</option>
                        </select>
                        @error('type')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="title_ar">@lang('back.form-title') - @lang('back.ar')</label>
                        <input type="text" name="title_ar" id="title_ar" class="form-control @error('title_ar') is-invalid @enderror" />
                        @error('title_ar')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="title_en">@lang('back.form-title') - @lang('back.en')</label>
                        <input type="text" name="title_en" id="title_en" class="form-control @error('title_en') is-invalid @enderror" />
                        @error('title_en')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="body_ar">@lang('back.form-body') - @lang('back.ar')</label>
                        <textarea name="body_ar" rows="5" id="body_ar" class="form-control @error('body_ar') is-invalid @enderror"></textarea>
                        @error('body_ar')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="body_en">@lang('back.form-body') - @lang('back.en')</label>
                        <textarea name="body_en" rows="5" id="body_en" class="form-control @error('body_en') is-invalid @enderror"></textarea>
                        @error('body_en')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">@lang('back.close')</button>
                <button type="submit" form="send-users-notification-form" class="btn btn-main-color waves-effect waves-light">@lang('back.send')</button>
            </div>
        </div>
    </div>
</div>
