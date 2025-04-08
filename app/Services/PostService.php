<?php

namespace App\Services;

use App\Repositories\Interface\IPost;
use App\Services\Interface\IPostService;

use Illuminate\Support\Facades\Log;
use App\Http\Resources\PostResource;

class PostService implements IPostService
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
                return  $this->Postrepo->restore($post);
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


    public function forceDelete($id)
    {
        try {
            $post = $this->Postrepo->getById($id);
            if (!$post) {
                return null;
            }
            return $this->Postrepo->forceDelete($post);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw $e;
        }
        
    }


  

    public function bulkDelete($ids)
    {
        try {
            $result = $this->Postrepo->bulkDelete($ids);
            
            $response = [
                'status' => 'success',
                'data' => [
                    'deleted_ids' => $result['authorized_ids'],
                    'deleted_count' => $result['deleted_count']
                ]
            ];
            
            if (!empty($result['unauthorized_ids'])) {
                $response['status'] = 'partial';
                $response['message'] = 'Some items were not deleted due to authorization issues';
                $response['data']['unauthorized_ids'] = $result['unauthorized_ids'];
            }
            
            return $response;
            
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            if (str_contains($e->getMessage(), 'No authorized posts found')) {
                throw new \Exception(__('messages.post.no_authorized_ids'), 403);
            }
            throw $e;
        }
    }
    
    public function bulkRestore($ids)
    {
        try {
            $result = $this->Postrepo->bulkRestore($ids);
            
            if (count($result['unauthorized_ids']) > 0) {
                return [
                    'status' => 'partial',
                    'message' => 'Some items were not restored due to authorization issues',
                    'data' => $result
                ];
            }
            
            return [
                'status' => 'success',
                'data' => $result
            ];
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw $e;
        }
    }
    
    public function bulkForceDelete($ids)
    {
        try {
            $result = $this->Postrepo->bulkForceDelete($ids);
            
            if (!$result['any_trashed_exist']) {
                throw new \Exception('No trashed posts found with the given IDs');
            }
            
            if (!empty($result['unauthorized_ids']) || $result['authorized_ids'] === []) {
                return [
                    'status' => 'partial',
                    'message' => 'Some items could not be permanently deleted',
                    'data' => [
                        'deleted_ids' => $result['authorized_ids'],
                        'unauthorized_ids' => $result['unauthorized_ids'],
                        'not_trashed_ids' => array_diff($result['unauthorized_ids'], $result['authorized_ids'])
                    ]
                ];
            }
            
            return [
                'status' => 'success',
                'data' => [
                    'deleted_ids' => $result['authorized_ids']
                ]
            ];
            
        } catch (\Exception $e) {
            Log::error('Bulk force delete error: ' . $e->getMessage());
            throw $e;
        }
    }

}
