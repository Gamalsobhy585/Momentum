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

 
    public function update($model, $data)
    {
        $model->fill($data);
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

    public function forceDelete($model)
    {
        return $model->forceDelete();
    }
    public function bulkDelete($ids)
    {
        $authorizedIds = Post::whereIn('id', $ids)
            ->where('user_id', auth()->user()->id)
            ->pluck('id')
            ->toArray();
        
        $unauthorizedIds = array_diff($ids, $authorizedIds);
        
        if (empty($authorizedIds)) {
            throw new \Exception('No authorized posts found for bulk delete');
        }
        
        $deletedCount = Post::whereIn('id', $authorizedIds)->delete();
        
        return [
            'deleted_count' => $deletedCount,
            'authorized_ids' => $authorizedIds,
            'unauthorized_ids' => $unauthorizedIds
        ];
    }
    
    public function bulkRestore($ids)
    {
        $authorizedIds = Post::onlyTrashed()
            ->whereIn('id', $ids)
            ->where('user_id', auth()->user()->id)
            ->pluck('id')
            ->toArray();
        
        $unauthorizedIds = array_diff($ids, $authorizedIds);
        
        $result = Post::onlyTrashed()
            ->whereIn('id', $authorizedIds)
            ->restore();
        
        return [
            'success' => $result,
            'authorized_ids' => $authorizedIds,
            'unauthorized_ids' => $unauthorizedIds
        ];
    }
    
    public function bulkForceDelete($ids)
    {
        $query = Post::onlyTrashed()->whereIn('id', $ids);
        
        $authorizedIds = $query->where('user_id', auth()->id())
                             ->pluck('id')
                             ->toArray();
        
        $unauthorizedIds = array_diff($ids, $authorizedIds);
        
        $anyTrashedExist = Post::onlyTrashed()->whereIn('id', $ids)->exists();
        
        $result = false;
        if (!empty($authorizedIds)) {
            $result = $query->whereIn('id', $authorizedIds)->forceDelete();
        }
        
        return [
            'success' => $result,
            'authorized_ids' => $authorizedIds,
            'unauthorized_ids' => $unauthorizedIds,
            'any_trashed_exist' => $anyTrashedExist
        ];
    }




}
