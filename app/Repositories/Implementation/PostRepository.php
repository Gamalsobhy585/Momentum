<?php

namespace App\Repositories\Implementation;

use App\Models\Post;
use App\Repositories\Interface\IPost;

class PostRepository implements IPost
{
    public function get($query, $limit, $sort_by = 'id', $sort_direction = 'asc')
    {
        $posts = Post::where('user_id', auth()->user()->id)
            ->when($query, function ($q) use ($query) {
                return $q->where(function ($q) use ($query) {
                    $q->where('title', 'like', "%{$query}%")
                      ->orWhere('content', 'like', "%{$query}%");
                });
            })
            ->orderBy($sort_by, $sort_direction)
            ->paginate($limit);

        return $posts;
    }

    public function save($model)
    {
     return  Post::create($model);
    }

    public function delete($model)
    {
     return $model->delete(); 
    }

    public function update($model)
    {
     return $model->save();
    }
    public function restore($model)
    {
     return $model->restore();
    }
    public function getById($id)
    {
        return Post::where('user_id', auth()->user()->id)->find($id);
    }

    public function getTotalPosts()
    {
     return Post::where('user_id', auth()->user()->id)->count();
    }
    public function getDeletedPosts($limit)
    {
        return Post::onlyTrashed()
            ->where('user_id', auth()->user()->id)
            ->paginate($limit);
    }

    public function getDeletedById($id)
    {
        try {
            return Post::onlyTrashed()
                ->where('id', $id)
                ->where('user_id', auth()->user()->id)
                ->first();
        } catch (\Exception $e) {
            throw $e;
        }
    }




}
