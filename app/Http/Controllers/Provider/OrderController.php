<?php

namespace App\Http\Controllers\Provider;

use App\Facade\Support\Tools\CrudMessage;
use App\Http\Controllers\Controller;
use App\Models\{Order, OrderProvider};
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = request()->user()->orders()->where('is_rental_accept', 1)->with('providers')->paginate(10);

        return view('Provider.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = OrderProvider::where('order_id', $id)->where('provider_id', request()->user()->id)->first();

        return view('Provider.orders.show', compact('order'));
    }

    public function accept(Order $order): RedirectResponse
    {
        $provider_order = OrderProvider::query()->where('order_id', $order->id)->where('provider_id', request()->user()->id)->first();

        if (! $provider_order) return CrudMessage::error('عفوا هذا الطلب غير موجود');

        $provider_order->update(['is_accepted' => 1]);

        return CrudMessage::success();
    }

    public function reject(Order $order): RedirectResponse
    {
        $provider_order = OrderProvider::query()->where('order_id', $order->id)->where('provider_id', request()->user()->id)->first();

        if (! $provider_order) return CrudMessage::error('عفوا هذا الطلب غير موجود');

        $provider_order->update(['is_accepted' => 2]);

        return CrudMessage::success();
    }

    public function search(Request $request)
    {
        $sorting = $request->sorting == 'newer-to-older' ? 'DESC' : 'ASC';

        $query = Order::query();

        $que = ($request->has('term') && ! is_null($request->term)) ? $query->search($request->term) : $query;

        $collection = $que->orderBy('id', $sorting)->paginate(10);

        return view('Provider.orders.index', ['orders' => $collection]);
    }
}
