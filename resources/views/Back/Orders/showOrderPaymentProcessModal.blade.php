<div id="view_show_order_payment_process" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" dir="{{ direction() }}">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">تحويل الطلب لمدفوع</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>

            <div class="modal-body">
                <form action="{{ route('orders.set-order-to-be-paid') }}" method="POST" id="sendMessageForm">
                    @csrf
                    <input type="hidden" name="order_id" value="{{ $order_id }}">
                    <div class="form-group">
                        <label for="message-title">@lang('back.form-payment-method')</label>
                        <select name="payment_method" class="form-control">
                            <option value="cash">@lang('back.cash')</option>
                            <option value="visa">@lang('back.online-payment')</option>
                            <option value="wallet">@lang('back.pay-by-wallet')</option>
                        </select>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">@lang('back.close')</button>
                <button type="submit" form="sendMessageForm" name="submit" class="btn btn-primary waves-effect waves-light">@lang('back.pay')</button>
            </div>
        </div>
    </div>
</div>
