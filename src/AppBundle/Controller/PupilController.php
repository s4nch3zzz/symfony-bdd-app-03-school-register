<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Pupil;
use AppBundle\Form\PupilType;

/**
 * Pupil controller.
 *
 * @Route("/admin/pupil")
 */
class PupilController extends Controller
{

    /**
     * Lists all Pupil entities.
     *
     * @Route("/", name="admin_pupil")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Pupil')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Pupil entity.
     *
     * @Route("/", name="admin_pupil_create")
     * @Method("POST")
     * @Template("AppBundle:Pupil:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Pupil();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_pupil_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Pupil entity.
     *
     * @param Pupil $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Pupil $entity)
    {
        $form = $this->createForm(new PupilType(), $entity, array(
            'action' => $this->generateUrl('admin_pupil_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Pupil entity.
     *
     * @Route("/new", name="admin_pupil_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Pupil();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Pupil entity.
     *
     * @Route("/{id}", name="admin_pupil_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Pupil')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Pupil entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Pupil entity.
     *
     * @Route("/{id}/edit", name="admin_pupil_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Pupil')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Pupil entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Pupil entity.
    *
    * @param Pupil $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Pupil $entity)
    {
        $form = $this->createForm(new PupilType(), $entity, array(
            'action' => $this->generateUrl('admin_pupil_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Pupil entity.
     *
     * @Route("/{id}", name="admin_pupil_update")
     * @Method("PUT")
     * @Template("AppBundle:Pupil:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Pupil')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Pupil entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_pupil_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Pupil entity.
     *
     * @Route("/{id}", name="admin_pupil_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Pupil')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Pupil entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_pupil'));
    }

    /**
     * Creates a form to delete a Pupil entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_pupil_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
