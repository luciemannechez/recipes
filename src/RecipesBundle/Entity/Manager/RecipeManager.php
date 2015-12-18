<?php

namespace RecipesBundle\Entity\Manager;

use RecipesBundle\Entity\Recipe;
use Doctrine\Common\Persistence\ObjectManager;

class RecipeManager
{
    public function __construct(ObjectManager $em) {
        $this->em = $em;
    }

    public function save(Recipe $recipe)
    {
        $this->em->persist($recipe);
        $this->em->flush();
    }

    public function remove(Recipe $recipe)
    {
        $this->em->remove($recipe);
        $this->em->flush();
    }
}