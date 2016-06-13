<?php

namespace RecipesBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Util\Codes;
use FOS\RestBundle\View\View;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\FOSUserEvents;
use Nelmio\ApiDocBundle\Annotation as Doc;
use RecipesBundle\Entity\User;
use RecipesBundle\Form\Type\RegistrationType;
use RecipesBundle\Form\Type\UserType;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Yaml\Exception\RuntimeException;


class UserController extends FOSRestController
{

    /**
     * @Rest\Get("/", name="")
     *
     * @Doc\ApiDoc(
     *     section="Users",
     *     resource=true,
     *     description="Get the list of all users.",
     *     statusCodes={
     *          200="Returned when successful",
     *     }
     * )
     */
    public function getUsersAction()
    {

        $em = $this->getDoctrine()->getManager();

        return $em->getRepository('RecipesBundle:User')->findAll();
    }

    /**
     * @Rest\Get(
     *    path = "/{id}",
     *    name="",
     *    requirements={"id"="\d+"}
     * )
     *
     * @Doc\ApiDoc(
     *     section="Users",
     *     resource=true,
     *     description="Get one user.",
     *     requirements={
     *          {
     *              "name"="id",
     *              "dataType"="integer",
     *              "requirement"="\d+",
     *              "description"="The user unique identifier."
     *          }
     *      },
     *      statusCodes={
     *          200="Returned when successful",
     *      }
     * )
     */
    public function getUserAction(User $user)
    {
        return $user;
    }

    /**
     * @Rest\Post("/", name="")
     *
     *
     * @Rest\View(statusCode=201)
     *
     * @Doc\ApiDoc(
     *      section="Users",
     *      description="Creates a new user.",
     *      statusCodes={
     *          201="Returned if user has been successfully created",
     *          400="Returned if errors",
     *          500="Returned if server error"
     *      },
     *     parameters={
     *          {
     *              "name"="username",
     *              "dataType"="string",
     *              "required"=true
     *          }
     *     }
     * )
     */
    public function postUserAction(Request $request)
    {
        /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
        $formFactory = $this->container->get('fos_user.registration.form.factory');
        /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
        $userManager = $this->container->get('fos_user.user_manager');
        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->container->get('event_dispatcher');

        $user = $userManager->createUser();
        $user->setEnabled(true);

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        $form = $formFactory->createForm();
        $form->setData($user);

        $jsonData = json_decode($request->getContent(), true); // "true" to get an associative array

        if ('POST' === $request->getMethod()) {
            $form->bind($jsonData);

            if ($form->isValid()) {
                $event = new FormEvent($form, $request);
                $dispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, $event);

                $userManager->updateUser($user);

                $response = new Response("User created.", 201);

                return $response;
            }
        }

        $view = View::create($form, 400);
        return $this->get('fos_rest.view_handler')->handle($view);
    
        /*$form = $this->container->get('fos_user.registration.form');
        $formHandler = $this->container->get('fos_user.registration.form.handler');
        $confirmationEnabled = $this->container->getParameter('fos_user.registration.confirmation.enabled');

        $process = $formHandler->process($confirmationEnabled);

        if ($process) {
            $user = $form->getData();

            //$url = $this->container->get('router')->generate('get_user');
           // $response = new RedirectResponse($url);

            return $user;
        }

        return View::create(array('errors'=>$form->getErrors()), 400);*/

         /*$entity = new User();
         $form = $this->createForm(new RegistrationType(), $entity, array("method" => $request->getMethod()));
         $form->handleRequest($request);

         if ($form->isValid()) {
             $em = $this->getDoctrine()->getManager();
             $em->flush();
             $em->persist($entity);
             return $entity;
         }

         return View::create(array('errors'=>$form->getErrors()), 400);*/
/*

        $user = $this->deserialize('RecipesBundle\Entity\User', $request);

        if ( $user instanceof User === false) {
            return View::create(array('errors'=>$user), 400);
        }

        $userManager = $this->container->get('fos_user.user_manager');

        $userManager->createUser();
        $userManager->updateUser($user);

        $url = $this->generateUrl('get_user', array('id' => $user->getId()), true);

        $response = new Response();
        $response->setStatusCode(201);
        $response->headers->set('Location',$url);

        return $response;*/

    }

    protected function deserialize(
        $class,
        Request $request,
        $format = 'json'
    ) {
        $serializer = $this->get('serializer');
        $validator = $this->get('validator');

        try {
            $entity = $serializer->deserialize($request->getContent(), $class, $format);
        } catch (RuntimeException $e) {
            throw new HttpException(400, $e->getMessage());
        }

        if (count($errors = $validator->validate($entity))) {
            return $errors;
        }

        return $entity;
    }

//    /**
//     *
//     * @Rest\Put(
//     *     path = "/{id}",
//     *     name = "",
//     *     requirements = {"id"="\d+"}
//     * )
//     *
//     * @ParamConverter("newRecipe", converter="fos_rest.request_body")
//     *
//     * @Doc\ApiDoc(
//     *      section="Recipes",
//     *      description="Edit an existing recipe.",
//     *      statusCodes={
//     *          201="Returned if recipe has been successfully edited",
//     *          400="Returned if errors",
//     *          500="Returned if server error"
//     *      },
//     *      requirements={
//     *          {
//     *              "name"="id",
//     *              "dataType"="integer",
//     *              "requirement"="\d+",
//     *              "description"="The recipe unique identifier."
//     *          }
//     *      },
//     *     parameters={
//     *          {
//     *              "name"="name",
//     *              "dataType"="string",
//     *              "required"=true
//     *          },
//     *          {
//     *              "name"="people_nb",
//     *              "dataType"="integer",
//     *              "required"=false
//     *          }
//     *     }
//     * )
//     */
//    public function putRecipeAction(Recipe $newRecipe, Recipe $oldRecipe, ConstraintViolationListInterface $violations)
//    {
//        if (count($violations)) {
//            return $this->view($violations, 400);
//        }
//
//        $oldRecipe->update($newRecipe);
//
//        $em = $this->getDoctrine()->getManager();
//        $em->persist($oldRecipe);
//        $em->flush();
//
//        return $this->view('', Response::HTTP_NO_CONTENT);
//    }
//
//    /**
//     *
//     * @Rest\Patch(
//     *     path = "/{id}",
//     *     name = "",
//     *     requirements = {"id"="\d+"}
//     * )
//     *
//     * @ParamConverter("newRecipe", converter="fos_rest.request_body")
//     *
//     * @Doc\ApiDoc(
//     *      section="Recipes",
//     *      description="Edit an existing recipe.",
//     *      statusCodes={
//     *          201="Returned if recipe has been successfully edited",
//     *          400="Returned if errors",
//     *          500="Returned if server error"
//     *      },
//     *      requirements={
//     *          {
//     *              "name"="id",
//     *              "dataType"="integer",
//     *              "requirement"="\d+",
//     *              "description"="The recipe unique identifier."
//     *          }
//     *      },
//     * )
//     */
//    public function patchRecipeAction(Recipe $newRecipe, Recipe $oldRecipe, ConstraintViolationListInterface $violations)
//    {
//        if (count($violations)) {
//            return $this->view($violations, 400);
//        }
//
//        $oldRecipe->patch($newRecipe);
//
//        $em = $this->getDoctrine()->getManager();
//        $em->persist($oldRecipe);
//        $em->flush();
//
//        return $this->view('', Response::HTTP_NO_CONTENT);
//    }
//
//    /**
//     * @Rest\Delete(
//     *     path = "/{id}",
//     *     name = "",
//     *     requirements = {"id"="\d+"}
//     * )
//     *
//     * @Rest\View(statusCode=204)
//     *
//     * @Doc\ApiDoc(
//     *      section="Recipes",
//     *      description="Delete an existing recipe.",
//     *      statusCodes={
//     *          201="Returned if recipe has been successfully deleted",
//     *          400="Returned if recipe does not exist",
//     *          500="Returned if server error"
//     *      },
//     *      requirements={
//     *          {
//     *              "name"="id",
//     *              "dataType"="integer",
//     *              "requirement"="\d+",
//     *              "description"="The recipe unique identifier."
//     *          }
//     *      },
//     * )
//     */
//    public function deleteRecipeAction(Recipe $recipe)
//    {
//        $this->get('recipes_manager')->remove($recipe);
//
//        return $this->view('', Response::HTTP_NO_CONTENT);
//    }
}