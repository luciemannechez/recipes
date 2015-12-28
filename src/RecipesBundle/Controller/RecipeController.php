<?php

namespace RecipesBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Nelmio\ApiDocBundle\Annotation as Doc;
use RecipesBundle\Entity\Recipe;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use RecipesBundle\Entity\Manager\RecipeManager;

class RecipeController extends FOSRestController
{

    /**
     * @Rest\Get("/", name="")
     *
     * @Doc\ApiDoc(
     *     section="Recipes",
     *     resource=true,
     *     description="Get the list of all recipes.",
     *     statusCodes={
     *          200="Returned when successful",
     *     }
     * )
     */
    public function getRecipesAction()
    {
        return $this->get('doctrine')
            ->getRepository('RecipesBundle:Recipe')
            ->getRecipes();
    }

    /**
     * @Rest\Get(
     *    path = "/{id}",
     *    name="",
     *    requirements={"id"="\d+"}
     * )
     *
     * @Doc\ApiDoc(
     *     section="Recipes",
     *     resource=true,
     *     description="Get one recipe.",
     *     requirements={
     *          {
     *              "name"="id",
     *              "dataType"="integer",
     *              "requirement"="\d+",
     *              "description"="The recipe unique identifier."
     *          }
     *      },
     *      statusCodes={
     *          200="Returned when successful",
     *      }
     * )
     */
    public function getRecipeAction(Recipe $recipe)
    {
        return $recipe;
    }

    /**
     * @Rest\Post("/", name="")
     *
     * @ParamConverter("recipe", converter="fos_rest.request_body")
     *
     * @Rest\View(statusCode=201)
     *
     * @Doc\ApiDoc(
     *      section="Recipes",
     *      description="Creates a new recipe.",
     *      statusCodes={
     *          201="Returned if recipe has been successfully created",
     *          400="Returned if errors",
     *          500="Returned if server error"
     *      }
     * )
     */
    public function postRecipeAction(Recipe $recipe, ConstraintViolationListInterface $violations)
    {
        if (count($violations)) {
            return $this->view($violations, 400);
        }

        $this->get('recipes_manager')->save($recipe);

        return $this->view(null, 201,
            [
                'Location' => $this->generateUrl('get_recipe', [ 'id' => $recipe->getId()]),
            ]);
    }

    /**
     *
     * @Rest\Put(
     *     path = "/{id}",
     *     name = "",
     *     requirements = {"id"="\d+"}
     * )
     *
     * @ParamConverter("newRecipe", converter="fos_rest.request_body")
     *
     * @Doc\ApiDoc(
     *      section="Recipes",
     *      description="Edit an existing recipe.",
     *      statusCodes={
     *          201="Returned if recipe has been successfully edited",
     *          400="Returned if errors",
     *          500="Returned if server error"
     *      },
     *      requirements={
     *          {
     *              "name"="id",
     *              "dataType"="integer",
     *              "requirement"="\d+",
     *              "description"="The recipe unique identifier."
     *          }
     *      },
     *     parameters={
     *          {
     *              "name"="name",
     *              "dataType"="string",
     *              "required"=true
     *          },
     *          {
     *              "name"="people_nb",
     *              "dataType"="integer",
     *              "required"=false
     *          }
     *     }
     * )
     */
    public function putRecipeAction(Recipe $newRecipe, Recipe $oldRecipe, ConstraintViolationListInterface $violations)
    {
        if (count($violations)) {
            return $this->view($violations, 400);
        }

        $oldRecipe->update($newRecipe);

        $em = $this->getDoctrine()->getManager();
        $em->persist($oldRecipe);
        $em->flush();

        return $this->view('', Response::HTTP_NO_CONTENT);
    }

    /**
     *
     * @Rest\Patch(
     *     path = "/{id}",
     *     name = "",
     *     requirements = {"id"="\d+"}
     * )
     *
     * @ParamConverter("newRecipe", converter="fos_rest.request_body")
     *
     * @Doc\ApiDoc(
     *      section="Recipes",
     *      description="Edit an existing recipe.",
     *      statusCodes={
     *          201="Returned if recipe has been successfully edited",
     *          400="Returned if errors",
     *          500="Returned if server error"
     *      },
     *      requirements={
     *          {
     *              "name"="id",
     *              "dataType"="integer",
     *              "requirement"="\d+",
     *              "description"="The recipe unique identifier."
     *          }
     *      },
     * )
     */
    public function patchRecipeAction(Recipe $newRecipe, Recipe $oldRecipe, ConstraintViolationListInterface $violations)
    {
        if (count($violations)) {
            return $this->view($violations, 400);
        }

        $oldRecipe->patch($newRecipe);

        $em = $this->getDoctrine()->getManager();
        $em->persist($oldRecipe);
        $em->flush();

        return $this->view('', Response::HTTP_NO_CONTENT);
    }

    /**
     * @Rest\Delete(
     *     path = "/{id}",
     *     name = "",
     *     requirements = {"id"="\d+"}
     * )
     *
     * @Rest\View(statusCode=204)
     *
     * @Doc\ApiDoc(
     *      section="Recipes",
     *      description="Delete an existing recipe.",
     *      statusCodes={
     *          201="Returned if recipe has been successfully deleted",
     *          400="Returned if recipe does not exist",
     *          500="Returned if server error"
     *      },
     *      requirements={
     *          {
     *              "name"="id",
     *              "dataType"="integer",
     *              "requirement"="\d+",
     *              "description"="The recipe unique identifier."
     *          }
     *      },
     * )
     */
    public function deleteRecipeAction(Recipe $recipe)
    {
        $this->get('recipes_manager')->remove($recipe);

        return $this->view('', Response::HTTP_NO_CONTENT);
    }
}