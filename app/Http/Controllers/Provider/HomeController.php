<?php

namespace App\Http\Controllers\Provider;

use App\Facade\Support\Core\{Crud, Uploaded};
use App\Http\Controllers\Controller;
use App\Http\Requests\Provider\EditProviderProfileRequest;
use App\Models\{Product, Provider};

class HomeController extends Controller
{
    public function index()
    {
        $provider = (object) auth()->guard('provider')->user();

        $data['auth'] = $provider;
        $data['products_count'] = Product::storeProducts($provider->id)->count();
        $data['rental_products_count'] = Product::whereNotNull('type')->whereTypeId($provider->id)->whereNull('owner')->where('owner_id', $provider->id)->count();
        $data['orders_count'] = request()->user()->orders()->where('is_rental_accept', 1)->count();
        $data['products'] = Product::storeProducts($provider->id)->limit(10)->get();
        $data['orders'] = request()->user()->orders()->where('is_rental_accept', 1)->get();

        return view('Provider.index', $data);
    }

    public function profile()
    {
        return view('Provider.profile', ['auth' => request()->user()]);
    }

    public function profileUpdate(EditProviderProfileRequest $request)
    {
        $providerData = $request->except(['password', '_token', 'logo']);

        if ($request->password) $providerData['password'] = $request->password;

        if ($request->hasFile('logo'))
        {
            storage_unlink('demands', $request->user()->logo);

            $providerData['logo'] = Uploaded::image($request->logo,'demand');
        }

        return Crud::update(Provider::class, $providerData, $request->user());
    }
}
