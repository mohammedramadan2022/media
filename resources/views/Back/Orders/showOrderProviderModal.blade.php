<div id="view_show_order_provider" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" dir="{{ direction() }}">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">اختيار مندوب التوصيل للطلب</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>

            <div class="modal-body">
                <form action="{{ route('orders.set-order-provider') }}" method="POST" id="sendMessageForm">
                    @csrf
                    <input type="hidden" name="order_id" value="{{ $order_id }}">
                    <div class="form-group">
                        <label for="message-title">@lang('back.delivery-man')</label>
                        <select name="provider_id" class="form-control select2">
                            <option value="" disabled selected>@lang('back.choose-a-value')</option>
                            @foreach($providers as $id => $provider)
                                <option value="{{ $id }}">{{ str($provider)->title() }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">@lang('back.close')</button>
                <button type="submit" form="sendMessageForm" name="submit" class="btn btn-primary waves-effect waves-light">@lang('back.choose')</button>
            </div>
        </div>
    </div>
</div>
