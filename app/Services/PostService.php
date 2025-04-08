<?php

namespace App\Services;

use App\Repositories\Interface\IPost;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\PostResource;

class PostService
{
    private IPost $Postrepo;

    public function __construct(IPost $Postrepo)
    {
        $this->Postrepo = $Postrepo;
    }

    public function getPosts($request, $limit)
    {
        try {
            $query = $request->input('query');
            $sort_by = $request->input('sort_by', 'id');
            $sort_direction = $request->input('sort_direction', 'asc');

            return $this->Postrepo->get($query, $limit, $sort_by, $sort_direction);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw $e;
        }
    }

    public function getPostById($id)
    {
        try {
            return $this->Postrepo->getById($id);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw $e;
        }
    }

    public function createPost($request)
    {
        try {
            $userId = auth()->user()->id;
            $postData = [
                'title' => $request->input('title'),
                'content' => $request->input('content'),
                'user_id' => $userId,
            ];
            return $this->Postrepo->save($postData);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw $e;
        }
    }

    public function updatePost($request, $id)
    {
        try {
            $post = $this->Postrepo->getById($id);
            if (!$post) {
                return null;
            }

            $data = $request->only(['title', 'content']);
            $this->Postrepo->update($post, $data);
            return $post;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw $e;
        }
    }

    public function deletePost($id)
    {
        try {
            $post = $this->Postrepo->getById($id);
            if (!$post) {
                return null;
            }
            return $this->Postrepo->delete($post);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw $e;
        }
    }

    public function restorePost($id)
    {
        try {
            $post = $this->Postrepo->getDeletedById($id);
            
            if ($post && $post->user_id === auth()->user()->id) {
                $this->Postrepo->restore($post);
                return true;
            }
            
            return false;
        } catch (\Exception $e) {
            Log::error('Error restoring post: ' . $e->getMessage());
            throw $e;
        }
    }

    public function getDeletedPosts($limit)
    {
        try {
            return $this->Postrepo->getDeletedPosts($limit);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw $e;
        }
    }
}
