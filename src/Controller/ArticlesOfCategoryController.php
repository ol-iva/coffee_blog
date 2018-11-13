<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\GetRandomRecipeService;

class ArticlesOfCategoryController extends AbstractController
{
    /**
     * @Route("/articles-of-category/{category}", name="articles-of-category")
     */
    public function articlesByOneCategory(Category $category, ArticleRepository $articleRepository, CategoryRepository $categoryRepository, GetRandomRecipeService $randomRecipe)
    {
        $articles = $articleRepository->getArticlesByCategory($category);
        //dump($articles); die;
        $categories = $categoryRepository->findAll();
        $randomRecipe = $randomRecipe->getRandomRecipe();
        return $this->render('blog.html.twig', ['articles' => $articles,
                'categories' => $categories,
                'randomRecipe' => $randomRecipe
            ]
        );
    }

}