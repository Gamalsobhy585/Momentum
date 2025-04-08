<?php

namespace App\Services;

use App\Repositories\Interface\IPost;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\PostResource;

class PostService
{
    private IPost $Postrepo;

    public function __construct(IPost $Postrepo)
    {
        $this->Postrepo = $Postrepo;
    }

    // Add methods to use the repository here
}
