<?php

namespace App\Repository\Contracts;

interface IEloquentRepository
{
    public function index();

    public function find($id);

    public function all();

    public function paginate($pages = 10);

    public function export();

    public function restore($id);

    public function trashed();

    public function delete($id);

    public function show($id);

    public function forceDelete($id);

    public function search($request);

    public function formFields($type = 'create', $currentModel = null);
}
