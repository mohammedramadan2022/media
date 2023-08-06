<x-model-index-page model="payment" :collection="$payments">
    <x-slot name="tableState">
        <div class="col-sm-6 col-md-4 col-xl-6">
            <x-table-state color="dark" icon="tag" slug="form-total" :count="$payments->sum('amount')"></x-table-state>
        </div>
        <div class="col-sm-6 col-md-4 col-xl-6">
            <x-table-state color="warning" icon="trash" slug="deleteds" :count="getModelCount('payment', true)"></x-table-state>
        </div>
    </x-slot>

    <x-slot name="thead">
        <th>#</th>
        <th>@lang('back.users.t-user')</th>
        <th>@lang('back.type')</th>
        <th>@lang('back.form-amount')</th>
        <th>@lang('back.form-currency')</th>
        <th>@lang('back.since')</th>
        <th class="text-center">@lang('back.form-actions')</th>
    </x-slot>
    @foreach($payments as $i => $payment)
        @continue($payment->amount == 0)
        <tr>
            <td>{{ $i+1 }}</td>
            <td>
                @if(isset($payment->user))
                    <a href="{{ route('users.show', $payment->user_id) }}">
                        {!! highlightText(ucwords($payment->user->name)) !!}
                    </a>
                @else
                    <label class="f-12">{{ ucwords($payment->username) }}</label>
                @endif
            </td>
            <td>
                @if($payment->paymentable_type == 'App\Models\Order')
                    <a class="btn btn-dark" href="{{ route('orders.show', $payment->paymentable_id) }}">
                        {{ trans('back.show-var', ['var' => trans('back.orders.t-order')]) }} <i class="fa fa-eye"></i>
                    </a>
                @endif
            </td>
            <td>
                <label class="badge badge-success p-2 f-13">
                    {!! highlightText(money($payment->amount)) !!}
                </label>
            </td>
            <td>{!! highlightText(ucwords($payment->currency)) !!}</td>
            <td>{{ $payment->since }}</td>
            <td class="text-center">
                <div class="btn-group dropdown">
                    <a href="javascript: void(0);" class="table-action-btn dropdown-toggle btn btn-main-color m-1" data-toggle="dropdown" aria-expanded="false">
                        <i class="mdi mdi-wrench"></i>&nbsp;&nbsp;<span>@lang('back.more')</span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-left">
                        <a class="dropdown-item delete-action" data-id="{{$payment->id}}" href="{{ localeUrl('/admin-panel/payments/'.$payment->id) }}">
                            @lang('back.delete')
                            <i class="fa fa-trash"></i>
                        </a>
                    </div>
                </div>
            </td>
        </tr>
    @endforeach
</x-model-index-page>
