<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use App\Traits\ResponseTrait;
use App\Services\Interface\IPostService;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;


use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    use ResponseTrait;
    protected IPostService $postService;

    public function __construct(IPostService $postService)
    {
        $this->postService = $postService;
    }

    public function index(Request $request)
    {
        try {
            $posts = $this->postService->getPosts($request, $request->get("per_page", 10));
            return $this->returnDataWithPagination(
                __('messages.post.get_all'),
                200,
                PostResource::collection($posts)
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage());
             $this->returnError(__('messages.post.get_failed'), 500);
        }
    }

    public function show(Post $post) 
    {
        try 
        {
            if ($post->user_id !== auth()->id()) {
                 $this->returnError(__('messages.post.not_found'), 404);
            }
            
            return $this->returnData(
                __('messages.post.get'),
                200,
                new PostResource($post)
            );
        } 
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            $this->returnError(__('messages.post.get_failed'), 500);
        }
    }

    public function store(StorePostRequest $request)
    {
        try {
            $post = $this->postService->createPost($request);
            return $this->success(
                __('messages.post.created'),
                201
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $this->returnError(__('messages.post.create_failed'), 500);
        }
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        try {
            $post = $this->postService->updatePost($request, $post->id);
            if (!$post) {
                 $this->returnError(__('messages.post.not_found'), 404);
            }
            return $this->success(
                __('messages.post.updated'),
                200
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage());
             $this->returnError(__('messages.post.update_failed'), 500);
        }
    }

    public function destroy(Post $post)
    {
        try {
            $result = $this->postService->deletePost($post->id);
            if (!$result) {
                 $this->returnError(__('messages.post.not_found'), 404);
            }
            return $this->success(
                __('messages.post.deleted'),
                200
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage());
             $this->returnError(__('messages.post.delete_failed'), 500);
        }
    }

    public function restore( $id)
    {
        try {
            $post = $this->postService->restorePost($id);
            if (!$post) {
                 $this->returnError(__('messages.post.not_found'), 404);
            }
            return $this->success(
                __('messages.post.restored'),
                200
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage());
             $this->returnError(__('messages.post.restore_failed'), 500);
        }
    }

    public function getDeletedPosts(Request $request)
    {
        try {
            $posts = $this->postService->getDeletedPosts($request->get("per_page", 10));
            return $this->returnDataWithPagination(
                __('messages.post.get_all_deleted'),
                200,
                PostResource::collection($posts)
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage());
             $this->returnError(__('messages.post.get_failed'), 500);
        }
    }

    public function forceDelete(Post $post)
    {
        try {
            $result = $this->postService->forceDelete($post->id);
            if (!$result) {
                 $this->returnError(__('messages.post.not_found'), 404);
            }
            return $this->success(
                __('messages.post.deleted'),
                200
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage());
             $this->returnError(__('messages.post.delete_failed'), 500);
        }
    }
    public function bulkDelete(Request $request)
    {
        try {
            $ids = $request->input('ids', []);
            if (empty($ids)) {
                return $this->returnError(__('messages.post.no_ids_provided'), 400);
            }
    
            $result = $this->postService->bulkDelete($ids);
            
            if ($result['status'] === 'partial') {
                return $this->returnData(
                    __('messages.post.partial_bulk_deleted'),
                    207,
                    $result['data']
                );
            }
    
            return $this->success(
                __('messages.post.bulk_deleted'),
                200,
                $result['data']
            );
            
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $statusCode = $e->getCode() ?: 500;
            return $this->returnError($e->getMessage(), $statusCode);
        }
    }
    public function bulkRestore(Request $request)
    {
        try {
            $ids = $request->input('ids', []);
            if (empty($ids)) {
                return $this->returnError(__('messages.post.no_ids_provided'), 400);
            }
    
            $result = $this->postService->bulkRestore($ids);
            
            if ($result['status'] === 'partial') {
                return $this->returnData(
                    __('messages.post.partial_bulk_restored'),
                    207,
                    $result['data']
                );
            }
    
            return $this->success(
                __('messages.post.bulk_restored'),
                200
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return $this->returnError(__('messages.post.bulk_restore_failed'), 500);
        }
    }
    
    public function bulkForceDelete(Request $request)
    {
        try {
            $ids = $request->input('ids', []);
            if (empty($ids)) {
                return $this->returnError(__('messages.post.no_ids_provided'), 400);
            }
    
            $result = $this->postService->bulkForceDelete($ids);
            
            if ($result['status'] === 'partial') {
                return $this->returnData(
                    __('messages.post.partial_bulk_force_deleted'),
                    207,
                    $result['data']
                );
            }
    
            return $this->success(
                __('messages.post.bulk_force_deleted'),
                200,
                $result['data']
            );
            
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            
            if (str_contains($e->getMessage(), 'No trashed posts found')) {
                return $this->returnError(__('messages.post.no_trashed_posts'), 404);
            }
            
            return $this->returnError(__('messages.post.bulk_force_delete_failed'), 500);
        }
    }
}