<?php

namespace App\Services\Interface;

interface IPostService
{
    public function getPosts($request, $limit);
    public function createPost($request);
    public function updatePost($request, $id);
    public function deletePost($id);
    public function restorePost($id);
    public function getDeletedPosts($limit);
    public function forceDelete($id);
    public function bulkDelete($ids);
    public function bulkRestore($ids);
    public function bulkForceDelete($ids);





}
