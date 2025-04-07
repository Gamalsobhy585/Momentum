<?php

namespace App\Services\Interface;

interface IPostService
{
    public function getPosts($request, $limit);
    public function store($request);
    public function update($request,$model);
    public function delete($model);
    public function restore($model);
}
