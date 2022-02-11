<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewsRequest;
use App\Http\Services\NewsService;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * @param NewsRequest $request
     * @return array
     */
    public function getNews(NewsRequest $request): array
    {
        $service = new NewsService($request->safe()->all());
        return $service->attachSimilarNewsToNews();
    }
}
