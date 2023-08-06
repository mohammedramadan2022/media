<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\RepoController;
use App\Http\Requests\Back\{CreateProductRequest, EditProductRequest};
use App\Models\Product;
use App\Repository\Contracts\IProductRepository;
use Illuminate\Http\Request;

class ProductController extends RepoController
{
    public function __construct(IProductRepository $repository)
    {
        parent::__construct($repository);
    }

    public function store(CreateProductRequest $request)
    {
        return self::repo()->store($request);
    }

    public function update(EditProductRequest $request, Product $product)
    {
        return self::repo()->update($request, $product);
    }

    public function accept(Product $product)
    {
        return self::repo()->accept($product);
    }

    public function reject(Product $product)
    {
        return self::repo()->reject($product);
    }

    public function getCategoriesBySectionId(Request $request)
    {
        return self::repo()->getCategoriesBySectionId($request);
    }

    public function getOptionsByCategoryId(Request $request)
    {
        return self::repo()->getOptionsByCategoryId($request);
    }
}
