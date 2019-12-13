<?php

namespace AppBundle\Controller;

use AppBundle\Entity\GameProject;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Serializer;

use Symfony\Component\HttpFoundation\ResponseHeaderBag;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Gameproject controller.
 *
 * @Route("gameproject")
 */
class GameProjectController extends Controller
{
    /**
     * Lists all gameProject entities.
     *
     * @Route("/", name="gameproject_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $gameProjects = $em->getRepository('AppBundle:GameProject')->findAll();

        return $this->render('gameproject/index.html.twig', array(
            'gameProjects' => $gameProjects,
        ));
    }

    /**
     * Creates a new gameProject entity.
     *
     * @Route("/new", name="gameproject_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {

        //return new Response($request->getMethod()); obviously delete CAN get here so it's NOT BEING SENT BY THE FORM REEEE

        $gameProject = new Gameproject();
        $form = $this->createForm('AppBundle\Form\GameProjectType', $gameProject);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($gameProject);
            $em->flush();

            return $this->redirectToRoute('gameproject_show', array('id' => $gameProject->getId()));
        }

        return $this->render('gameproject/new.html.twig', array(
            'gameProject' => $gameProject,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a gameProject entity.
     *
     * @Route("/{id}", name="gameproject_show")
     * @Method("GET")
     */
    public function showAction(GameProject $gameProject)
    {
        $deleteForm = $this->createDeleteForm($gameProject);

        return $this->render('gameproject/show.html.twig', array(
            'gameProject' => $gameProject,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing gameProject entity.
     *
     * @Route("/{id}/edit", name="gameproject_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, GameProject $gameProject)
    {
        $deleteForm = $this->createDeleteForm($gameProject);
        $editForm = $this->createForm('AppBundle\Form\GameProjectType', $gameProject);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('gameproject_edit', array('id' => $gameProject->getId()));
        }

        return $this->render('gameproject/edit.html.twig', array(
            'gameProject' => $gameProject,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a gameProject entity.
     *
     * @Route("/{id}", name="gameproject_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, GameProject $gameProject)
    {
        $form = $this->createDeleteForm($gameProject);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($gameProject);
            $em->flush();
        }

        return $this->redirectToRoute('gameproject_index');
    }



    /**
     * @Route("/getjson/{id}", name="gameproject_get_json")
     */
    public function serializeProjectAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        
        $crcRefHandler = function ($object)
        {
            return $object->getName();
        };
       
        //filters out everything but name from levels
        $callback1 = function ($levels)
        {
            $nameArr = array();
            foreach ($levels as &$level)
                array_push($nameArr, $level->getName());
            return $nameArr;
        };

        //filter out assets from levels
        $callback2 = function ($levels)
        {
            foreach ($levels as &$level)
                $level->setAssets(new ArrayCollection());
            return $levels;
        };
        
        $encoder = new JsonEncoder();
        $normalizers = array(new DateTimeNormalizer('d. M Y H:i'), new ObjectNormalizer());
        $normalizers[1]->setCallbacks(['levels' => $callback2]);
        $normalizers[1]->setCircularReferenceHandler($crcRefHandler);
        $serializer = new Serializer($normalizers, [$encoder]);
        
        $gameProject = $em->getRepository('AppBundle:GameProject')->findOneById($id);

        $projectDef = $serializer->serialize($gameProject, 'json', ['json_encode_options' => JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT]);

        $response = new Response($projectDef);
        $disposition = $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, $gameProject->getName() . '.json');
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Content-Disposition', $disposition);

        return $response;
    }



    /**
     * Creates a form to delete a gameProject entity.
     *
     * @param GameProject $gameProject The gameProject entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(GameProject $gameProject)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('gameproject_delete', array('id' => $gameProject->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

}
