<?php

namespace RecipesBundle\Entity;

/**
 * Recipe
 */
class Recipe
{
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
    private $preparation;


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
     * Set preparation
     *
     * @param string $preparation
     *
     * @return Recipe
     */
    public function setPreparation($preparation)
    {
        $this->preparation = $preparation;

        return $this;
    }

    /**
     * Get preparation
     *
     * @return string
     */
    public function getPreparation()
    {
        return $this->preparation;
    }
    /**
     * @var string
     */
    private $steps;


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
