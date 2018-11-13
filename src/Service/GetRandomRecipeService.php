<?php

namespace App\Service;

use App\Repository\RecipeRepository;

class GetRandomRecipeService
{
    private $recipeRepository;

    public function __construct(RecipeRepository $recipeRepository)
    {
        $this->recipeRepository = $recipeRepository;
    }

    public function getRandomRecipe()
    {
        $id = rand(1, 12);
        return $this->recipeRepository->find($id);
    }
}