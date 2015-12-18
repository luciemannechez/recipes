<?php

// src/RecipesBundle/DataFixtures/ORM/LoadRecipe.php

namespace IuchBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use RecipesBundle\Entity\Recipe;

class LoadRecipe extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $service1 = new Recipe();
        $service1->setName('Lasagnes')
                 ->setPeopleNb(4)
                 ->setSteps('naoajdoezfjoejiojeiofjreoifjero');


        $service2 = new Recipe();
        $service2->setName('Cookies')
                 ->setPeopleNb(1)
                 ->setSteps('dezjfoiezjfoi\ndioezfjiojeroiifj.\n.djeoifjo');

        $manager->persist($service1);
        $manager->persist($service2);
        $manager->flush();
    }

    public function getOrder()
    {
        return 2; // ordre d'appel
    }
}