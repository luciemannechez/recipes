<?php

namespace RecipesBundle\Entity;

/**
 * Recipe
 */
class Recipe
{
    public function update(Recipe $newRecipe, $function)
    {
        //$this = $oldRecipe;

        // pour chaque propriétés de l'objet, s'il a une nouvelle valeur, alors on met à jour la valeur de la propriété de l'ancien objet
        foreach ($this as $property => $value) {
            if ( $newRecipe->$property != null)
                $this->$property = $newRecipe->$property;
            else {
                // si c'est put et qu'il n'y a pas de nouvelle valeur, alors on remet à NULL
                if ($function == "put")
                    $value = NULL;
                // si c'est patch, on remet l'ancienne valeur
                elseif ($function == "patch")
                    $this->$property = $value;
            }
        }
    }

    // GENERATED CODE
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var \DateTime
     */
    private $prepTime;

    /**
     * @var \DateTime
     */
    private $cookingTime;

    /**
     * @var bool
     */
    private $peopleNb;

    /**
     * @var string
     */
    private $steps;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Recipe
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set prepTime
     *
     * @param \DateTime $prepTime
     *
     * @return Recipe
     */
    public function setPrepTime($prepTime)
    {
        $this->prepTime = $prepTime;

        return $this;
    }

    /**
     * Get prepTime
     *
     * @return \DateTime
     */
    public function getPrepTime()
    {
        return $this->prepTime;
    }

    /**
     * Set cookingTime
     *
     * @param \DateTime $cookingTime
     *
     * @return Recipe
     */
    public function setCookingTime($cookingTime)
    {
        $this->cookingTime = $cookingTime;

        return $this;
    }

    /**
     * Get cookingTime
     *
     * @return \DateTime
     */
    public function getCookingTime()
    {
        return $this->cookingTime;
    }

    /**
     * Set peopleNb
     *
     * @param boolean $peopleNb
     *
     * @return Recipe
     */
    public function setPeopleNb($peopleNb)
    {
        $this->peopleNb = $peopleNb;

        return $this;
    }

    /**
     * Get peopleNb
     *
     * @return bool
     */
    public function getPeopleNb()
    {
        return $this->peopleNb;
    }

    /**
     * Set steps
     *
     * @param string $steps
     *
     * @return Recipe
     */
    public function setSteps($steps)
    {
        $this->steps = $steps;

        return $this;
    }

    /**
     * Get steps
     *
     * @return string
     */
    public function getSteps()
    {
        return $this->steps;
    }
    /**
     * @var \RecipesBundle\Entity\Type
     */
    private $type;


    /**
     * Set type
     *
     * @param \RecipesBundle\Entity\Type $type
     *
     * @return Recipe
     */
    public function setType(\RecipesBundle\Entity\Type $type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \RecipesBundle\Entity\Type
     */
    public function getType()
    {
        return $this->type;
    }
}
