<?php

namespace App\Repositories\Interface;

interface IPost
{
    public function get($query, $limit, $sort_by = null, $sort_direction = 'desc');
    public function save($model);
    public function delete($model);
    public function update($model, $data);
    public function restore($model);
    public function getById($id);
    public function getTotalPosts();
    public function getDeletedPosts($limit);
    public function getDeletedById($id);
    public function forceDelete($model);
    public function bulkDelete($ids);
    public function bulkRestore($ids);
    public function bulkForceDelete($ids);





}
