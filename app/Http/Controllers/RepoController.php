<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RepoController extends Controller
{
    protected mixed $repo;

    public function __construct($repository)
    {
        $this->repo = $repository;
    }

    public function export()
    {
        return $this->repo->export();
    }

    public function index()
    {
        return $this->repo->index();
    }

    public function changeStatus(Request $request)
    {
        return $this->repo->changeStatus($request);
    }

    public function show($id)
    {
        return $this->repo->show($id);
    }

    public function trashed()
    {
        return $this->repo->trashed();
    }

    public function forceDelete($id)
    {
        return $this->repo->forceDelete($id);
    }

    public function restore($id)
    {
        return $this->repo->restore($id);
    }

    public function delete(Request $request)
    {
        return $this->repo->delete($request->id);
    }

    public function search(Request $request)
    {
        return $this->repo->search($request);
    }

    public function create()
    {
        return $this->repo->create();
    }

    public function edit($id)
    {
        return $this->repo->edit($id);
    }

    protected function repo()
    {
        return $this->repo;
    }
}
