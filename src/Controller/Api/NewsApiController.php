<?php

namespace App\Controller\Api;

use App\Repository\NewsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api")
 */
class NewsApiController extends AbstractController
{
    /**
     * @Route("/news", name="api_news_api")
     */
    public function allNews(NewsRepository $newsRepository): JsonResponse
    {
        return $this->json($newsRepository->findAll());
    }

    /**
     * @Route("/news/{id}", name="api_news_api")
     */
    public function newsDetails($id, NewsRepository $newsRepository): JsonResponse
    {
        return $this->json($newsRepository->find($id));
    }
}
