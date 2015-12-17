<?php

// src/RecipesBundle/DataFixtures/ORM/LoadUser.php

namespace RecipesBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class LoadUser extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface

{
    /**
     * @var ContainerInterface
     */
    private $container;
    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {

        // Get our userManager, you must implement `ContainerAwareInterface`
        $userManager = $this->container->get('fos_user.user_manager');

        // Create our user and set details
        $user1 = $userManager->createUser();
        $user1->setUsername('admin');
        $user1->setPlainPassword('admin');
        $user1->setEmail('admin@email.com');
        $user1->setRoles(array('ROLE_ADMIN'));

        $user2 = $userManager->createUser();
        $user2->setUsername('lucie');
        $user2->setPlainPassword('lucie');
        $user2->setEmail('lucie@email.com');
        $user2->setRoles(array('ROLE_USER'));

        // Update the user
        $userManager->updateUser($user1, true);
        $userManager->updateUser($user2, true);

    }
    public function getOrder()
    {
        return 1; // ordre d'appel
    }
}