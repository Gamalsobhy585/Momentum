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
            return $this->success(
                __('messages.post.get_all'),
                200,
                PostResource::collection($posts)
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return $this->returnError(__('messages.post.get_failed'), 500);
        }
    }

    public function show(Post $id)
    {
        try {
            $post = $this->postService->getPostById($id);
            if (!$post) {
                return $this->returnError(__('messages.post.not_found'), 404);
            }
            return $this->success(
                __('messages.post.get'),
                200,
                new PostResource($post)
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return $this->returnError(__('messages.post.get_failed'), 500);
        }
    }

    public function store(StorePostRequest $request)
    {
        try {
            $post = $this->postService->createPost($request);
            return $this->success(
                __('messages.post.created'),
                201,
                new PostResource($post)
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return $this->returnError(__('messages.post.create_failed'), 500);
        }
    }

    public function update(UpdatePostRequest $request, Post $id)
    {
        try {
            $post = $this->postService->updatePost($request, $id);
            if (!$post) {
                return $this->returnError(__('messages.post.not_found'), 404);
            }
            return $this->success(
                __('messages.post.updated'),
                200,
                new PostResource($post)
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return $this->returnError(__('messages.post.update_failed'), 500);
        }
    }

    public function destroy(Post $id)
    {
        try {
            $result = $this->postService->deletePost($id);
            if (!$result) {
                return $this->returnError(__('messages.post.not_found'), 404);
            }
            return $this->success(
                __('messages.post.deleted'),
                200
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return $this->returnError(__('messages.post.delete_failed'), 500);
        }
    }

    public function restore(Post $id)
    {
        try {
            $post = $this->postService->restorePost($id);
            if (!$post) {
                return $this->returnError(__('messages.post.not_found'), 404);
            }
            return $this->success(
                __('messages.post.restored'),
                200,
                new PostResource($post)
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return $this->returnError(__('messages.post.restore_failed'), 500);
        }
    }

    public function getDeletedPosts(Request $request)
    {
        try {
            $posts = $this->postService->getDeletedPosts($request->get("per_page", 10));
            return $this->success(
                __('messages.post.get_all_deleted'),
                200,
                PostResource::collection($posts)
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return $this->returnError(__('messages.post.get_failed'), 500);
        }
    }
}
