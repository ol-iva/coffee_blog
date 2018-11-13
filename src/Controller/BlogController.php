<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use App\Service\GetRandomRecipeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    /**
     * @Route("/", name="blog", methods="GET")
     */
    public function homepage(ArticleRepository $articleRepository,
                             CategoryRepository $categoryRepository,
                             GetRandomRecipeService $randomRecipe): Response
    {
        $articles = $articleRepository->findAll();

        $categories = $categoryRepository->findAll();

        $randomRecipe = $randomRecipe->getRandomRecipe();

        return $this->render('blog.html.twig', [
            'articles' => $articles,
            'categories' => $categories,
            'randomRecipe' => $randomRecipe
        ]);
    }
}