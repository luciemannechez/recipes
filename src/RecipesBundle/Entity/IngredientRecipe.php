<?php

namespace RecipesBundle\Entity;

/**
 * IngredientRecipe
 */
class IngredientRecipe
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $quantity;

    /**
     * @var \RecipesBundle\Entity\Recipe
     */
    private $recipe;

    /**
     * @var \RecipesBundle\Entity\Ingredient
     */
    private $ingredient;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set quantity
     *
     * @param string $quantity
     *
     * @return IngredientRecipe
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return string
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set recipe
     *
     * @param \RecipesBundle\Entity\Recipe $recipe
     *
     * @return IngredientRecipe
     */
    public function setRecipe(\RecipesBundle\Entity\Recipe $recipe = null)
    {
        $this->recipe = $recipe;

        return $this;
    }

    /**
     * Get recipe
     *
     * @return \RecipesBundle\Entity\Recipe
     */
    public function getRecipe()
    {
        return $this->recipe;
    }

    /**
     * Set ingredient
     *
     * @param \RecipesBundle\Entity\Ingredient $ingredient
     *
     * @return IngredientRecipe
     */
    public function setIngredient(\RecipesBundle\Entity\Ingredient $ingredient = null)
    {
        $this->ingredient = $ingredient;

        return $this;
    }

    /**
     * Get ingredient
     *
     * @return \RecipesBundle\Entity\Ingredient
     */
    public function getIngredient()
    {
        return $this->ingredient;
    }
}
