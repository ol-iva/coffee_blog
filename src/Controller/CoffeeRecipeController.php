<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\GetRandomRecipeService;

class CoffeeRecipeController extends AbstractController
{
    /**
     * @Route("/coffee-recipe", name="coffee-recipe")
     */
    public function coffeeRecipe(GetRandomRecipeService $randomRecipe)
    {
        $randomRecipe = $randomRecipe->getRandomRecipe();
        return $this->render('coffee_recipe.html.twig', [
                'randomRecipe' => $randomRecipe
            ]
        );
    }
}