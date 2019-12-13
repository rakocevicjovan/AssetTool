<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Level;
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

/**
 * Level controller.
 *
 * @Route("level")
 */
class LevelController extends Controller
{
    /**
     * Lists all level entities.
     *
     * @Route("/", name="level_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $levels = $em->getRepository('AppBundle:Level')->findAll();

        return $this->render('level/index.html.twig', array(
            'levels' => $levels,
        ));
    }

    /**
     * Creates a new level entity.
     *
     * @Route("/new", name="level_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $level = new Level();
        $form = $this->createForm('AppBundle\Form\LevelType', $level);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($level);
            $em->flush();

            return $this->redirectToRoute('level_show', array('id' => $level->getId()));
        }

        return $this->render('level/new.html.twig', array(
            'level' => $level,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a level entity.
     *
     * @Route("/{id}", name="level_show")
     * @Method("GET")
     */
    public function showAction(Level $level)
    {
        $deleteForm = $this->createDeleteForm($level);

        return $this->render('level/show.html.twig', array(
            'level' => $level,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing level entity.
     *
     * @Route("/{id}/edit", name="level_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Level $level)
    {
        $deleteForm = $this->createDeleteForm($level);
        $editForm = $this->createForm('AppBundle\Form\LevelType', $level);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('level_edit', array('id' => $level->getId()));
        }

        return $this->render('level/edit.html.twig', array(
            'level' => $level,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a level entity.
     *
     * @Route("/{id}", name="level_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Level $level)
    {
        $form = $this->createDeleteForm($level);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($level);
            $em->flush();
        }

        return $this->redirectToRoute('level_index');
    }



    /**
     * @Route("/getjson/{id}", name="level_get_json")
     */
    public function serializeLevelAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        
        $crcRefHandler = function ($object)
        {
            return $object->getName();
        };

        $resTypeCallback = function($object)
        {
            return $object->getName();
        };

        $encoder = new JsonEncoder();
        $normalizers = array(new DateTimeNormalizer('d. M Y H:i'), new ObjectNormalizer());
        $normalizers[1]->setCircularReferenceHandler($crcRefHandler);
        $normalizers[1]->setCallbacks(['resType' => $resTypeCallback]);
        $serializer = new Serializer($normalizers, [$encoder]);

        $level = $em->getRepository('AppBundle:Level')->findOneById($id);
        $level->setProject($level->getProject()->getName());    //hacky but I don't need all project metadata in these JSON files, name is still useful
       
        $levelDef = $serializer->serialize($level, 'json', ['json_encode_options' => JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT]);

        $response = new Response($levelDef);
        $disposition = $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, $level->getFileName());   // . '.json'
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Content-Disposition', $disposition);

        return $response;
    }


    /**
     * Creates a form to delete a level entity.
     *
     * @param Level $level The level entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Level $level)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('level_delete', array('id' => $level->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
