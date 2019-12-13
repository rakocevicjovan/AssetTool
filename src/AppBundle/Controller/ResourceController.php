<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Resource;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Resource controller.
 *
 * @Route("resource")
 */
class ResourceController extends Controller
{
    /**
     * Lists all resource entities.
     *
     * @Route("/", name="resource_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $resources = $em->getRepository('AppBundle:Resource')->findAll();

        return $this->render('resource/index.html.twig', array(
            'resources' => $resources,
        ));
    }

    /**
     * Creates a new resource entity.
     *
     * @Route("/new", name="resource_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $resource = new Resource();
        $form = $this->createForm('AppBundle\Form\ResourceType', $resource);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($resource);
            $em->flush();

            return $this->redirectToRoute('resource_show', array('id' => $resource->getId()));
        }

        return $this->render('resource/new.html.twig', array(
            'resource' => $resource,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a resource entity.
     *
     * @Route("/{id}", name="resource_show")
     * @Method("GET")
     */
    public function showAction(Resource $resource)
    {
        $deleteForm = $this->createDeleteForm($resource);

        return $this->render('resource/show.html.twig', array(
            'resource' => $resource,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing resource entity.
     *
     * @Route("/{id}/edit", name="resource_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Resource $resource)
    {
        $deleteForm = $this->createDeleteForm($resource);
        $editForm = $this->createForm('AppBundle\Form\ResourceType', $resource);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('resource_edit', array('id' => $resource->getId()));
        }

        return $this->render('resource/edit.html.twig', array(
            'resource' => $resource,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a resource entity.
     *
     * @Route("/{id}", name="resource_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Resource $resource)
    {
        $form = $this->createDeleteForm($resource);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($resource);
            $em->flush();
        }

        return $this->redirectToRoute('resource_index');
    }

    /**
     * Creates a form to delete a resource entity.
     *
     * @param Resource $resource The resource entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Resource $resource)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('resource_delete', array('id' => $resource->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
