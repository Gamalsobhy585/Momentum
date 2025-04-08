<?php

namespace App\Repositories\Implementation;

use App\Models\Post;
use App\Repositories\Interface\IPost;

class PostRepository implements IPost
{
    public function get($query, $limit, $sort_by = null, $sort_direction = 'desc')
    {
     return Post::where('user_id', auth()->user()->id)->paginate($limit);
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
     return Post::find($id);
    }
    public function getTotalPosts()
    {
     return Post::where('user_id', auth()->user()->id)->count();
    }



}
