<?php

namespace app\Services;

use app\Repositories\Interface\IPost;
use app\Traits\ResponseTrait;
use Illuminate\Support\Facades\Log;
use app\Http\Resources\PostResource;

class PostService
{
    private IPost $Postrepo;

    public function __construct(IPost $Postrepo)
    {
        $this->Postrepo = $Postrepo;
    }

    // Add methods to use the repository here
}
