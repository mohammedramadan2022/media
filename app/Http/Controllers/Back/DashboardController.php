<?php

namespace App\Http\Controllers\Back;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\{Admin, Order, Product, User};
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $data['admins'] = self::cacheModel(Admin::class);
        $data['users'] = self::cacheModel(User::class);
        $data['products'] = self::cacheModel(Product::class);
        $data['orders'] = self::cacheModel(Order::class);

        return view('Back.index', self::setHomeDonutsCharts($data));
    }

    public function search(Request $request): RedirectResponse
    {
        if (!$request->search || !$request->model_name) return back();

        $params = http_build_query(['term' => $request->search, 'sorting' => 'newer-to-older']);

        return redirect()->to('/admin-panel/' . plural($request->model_name) . '/search?' . $params);
    }

    private static function setHomeDonutsCharts($data, $other = []): array
    {
        $_data = [
            'admin'           => self::getModelCount($data['admins'],'admin'),
            'user'            => self::getModelCount($data['users'],'user'),
            'product'         => self::getModelCount($data['products'],'product'),
            'latest_products' => $data['products']->take(10)->sortDesc(),
            'latest_orders'   => $data['orders']->take(11)->sortDesc(),
            'order'           => [
                'pending'    => $data['orders']->where('status', OrderStatus::PENDING),
                'accepted'   => $data['orders']->where('status', OrderStatus::ACCEPTED),
                'rejected'   => $data['orders']->where('status', OrderStatus::REJECTED),
                'canceled'   => $data['orders']->where('status', OrderStatus::CANCELED),
                'processing' => $data['orders']->where('status', OrderStatus::PROCESSING),
            ],
        ];

        return array_merge($_data, $other);
    }

    private static function cacheModel($model)
    {
        if (app($model)->translatedAttributes) return $model::withTranslation()->latest()->get();

        return $model == Admin::class ? $model::notSuperAdmin()->latest()->get() : $model::latest()->get();
    }

    private static function getModelCount($collection, $modelName): array
    {
        $model = plural($modelName);

        return [
            'active_' . $model    => $collection->where('status', 1),
            'deductive_' . $model => $collection->where('status', 0)
        ];
    }
}
