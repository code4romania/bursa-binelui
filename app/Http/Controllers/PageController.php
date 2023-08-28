<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\PageResource;
use App\Models\Page;
use Inertia\Inertia;
use Inertia\Response;

class PageController extends Controller
{
    public function __invoke(Page $page): Response
    {
        return Inertia::render('Public/Page', [
            'page' => new PageResource($page),
        ]);
    }
}
