<?php

namespace App\Http\Services;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Http;

class NewsService
{
    protected string $apiNewsAllUrl;

    protected string $apiNewsSimilarUrl;

    protected string $apiToken;

    protected array $userData;

    /**
     * @param $userData
     */
    public function __construct($userData)
    {
        $this->apiToken = config('news.api_token');
        $this->apiNewsAllUrl = config('news.all_url');
        $this->apiNewsSimilarUrl = config('news.similar_url');
        $this->userData = $this->adjustData($userData);
    }

    /**
     * Get news by given user data with category, language and limit
     *
     * @return array
     */
    public function getAllNews(): array
    {
        $response = Http::get($this->apiNewsAllUrl, $this->userData);
        if (array_key_exists('error', $response->json())) {
            $this->sendError($response->json());
        }

        return $response->json('data');
    }

    /**
     * Get similar news to given news
     *
     * @param $newsId
     * @return array
     */
    public function getSimilarNews($newsId): array
    {
        $url = $this->apiNewsSimilarUrl.$newsId;
        $response = Http::get($url, ['api_token' => $this->apiToken]);
        if (array_key_exists('error', $response->json())) {
            $this->sendError($response->json());
        }

        return array_slice($response->json('data'), 0, 3);
    }

    /**
     * Attach similar news to news
     *
     * @return array
     */
    public function attachSimilarNewsToNews(): array
    {
        $data = [];
        $allNews = $this->getAllNews();
        foreach ($allNews as $news) {
            $newsId = $news['uuid'];
            $news = $news + ['similarNews' => $this->getSimilarNews($newsId)];
            array_push($data, $news);
        }
        return ['news' => $data];
    }

    /**
     * @param $error
     */
    protected function sendError($error): HttpResponseException
    {
        throw new HttpResponseException(
            response()->json($error)
        );
    }

    /**
     * Adjust user data to api data
     *
     * @param $data
     * @return array
     */
    protected function adjustData($data):array
    {
        $data['categories'] = $data['category'];
        unset($data['category']);
        return $data + ['api_token' => $this->apiToken];
    }
}
