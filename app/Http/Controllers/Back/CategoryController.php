<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\RepoController;
use App\Http\Requests\Back\{CreateCategoryRequest, EditCategoryRequest};
use App\Models\Category;
use App\Repository\Contracts\ICategoryRepository;

class CategoryController extends RepoController
{
    public function __construct(ICategoryRepository $repository)
    {
        parent::__construct($repository);
    }

    public function store(CreateCategoryRequest $request)
    {
        return self::repo()->store($request);
    }

    public function update(EditCategoryRequest $request, Category $category)
    {
        return self::repo()->update($request, $category);
    }
}
