<?php

namespace App\Repositories\Interface;

interface IPost
{
    public function get($query, $limit, $sort_by = null, $sort_direction = 'desc');
    public function save($model);
    public function delete($model);
    public function update($model);
    public function restore($model);
    public function getById($id);
    public function getTotalPosts();
    public function getDeletedPosts($limit);
    public function getDeletedById($id);

}
