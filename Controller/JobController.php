<?php

namespace COil\Jobeet2Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use COil\Jobeet2Bundle\Entity\Job;
use COil\Jobeet2Bundle\Form\JobType;
use COil\Jobeet2Bundle\Controller\Jobeet2Controller;

/**
 * Job controller.
 *
 * @Route("/job")
 */
class JobController extends Jobeet2Controller
{
    /**
     * Finds and displays a Job entity or any user.
     *
     * @Route("/{company_slug}/{location_slug}/{id}/{position_slug}", name="job_show_user")
     *
     * @Template("Jobeet2Bundle:Job:show.html.twig")
     */
    public function showUserAction($id)
    {
        $em     = $this->getDoctrine()->getEntityManager();
        $entity = $this->getRepo('Job')->findOneActiveById($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Job entity.');
        }

        return array(
            'job' => $entity
        );
    }

    /**
     * Finds and displays a Job entity for the creator of the offer.
     *
     * @Route("/{token}/show", name="job_show")
     *
     * @Template()
     */
    public function showAction($token)
    {
        $em     = $this->getDoctrine()->getEntityManager();
        $entity = $this->getRepo('Job')->findOneByToken($token);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Job entity.');
        }

        $deleteForm = $this->createDeleteForm($token);

        return array(
            'job'        => $entity,
            'deleteForm' => $deleteForm->createView(),
            'activeDays' => $this->getActiveDays()
        );
    }

    /**
     * Displays a form to create a new Job entity.
     *
     * @Route("/new", name="job_new")
     * @Template()
     */
    public function newAction()
    {
        $entity  = new Job();
        $jobType = new JobType();
        $form    = $this->createForm(new JobType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'fields' => $jobType->getFields(),
            'helps'  => $jobType->getHelps()
        );
    }

    /**
     * Creates a new Job entity.
     *
     * @Route("/create", name="job_create")
     * @Method("post")
     * @Template("Jobeet2Bundle:Job:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Job();
        $request = $this->getRequest();
        $jobType = new JobType();
        $form    = $this->createForm($jobType, $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('job_show', array('token' => $entity->getToken())));

        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'fields' => $jobType->getFields(),
            'helps'  => $jobType->getHelps()
        );
    }

    /**
     * Displays a form to edit an existing Job entity.
     *
     * @Route("/{token}/edit", name="job_edit")
     * @Template()
     */
    public function editAction($token)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $entity = $em->getRepository('Jobeet2Bundle:Job')->findOneByToken($token);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Job entity.');
        }

        $jobType = new JobType();
        $editForm = $this->createForm($jobType, $entity);
        $deleteForm = $this->createDeleteForm($token);

        return array(
            'entity' => $entity,
            'form'   => $editForm->createView(),
            'fields' => $jobType->getFields(),
            'helps'  => $jobType->getHelps()
        );
    }

    /**
     * Edits an existing Job entity.
     *
     * @Route("/{token}/update", name="job_update")
     * @Method("post")
     * @Template("Jobeet2Bundle:Job:edit.html.twig")
     */
    public function updateAction($token)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $entity = $em->getRepository('Jobeet2Bundle:Job')->findOneByToken($token);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Job entity.');
        }

        $jobType    = new JobType();
        $editForm   = $this->createForm($jobType, $entity);
        $deleteForm = $this->createDeleteForm($token);
        $request    = $this->getRequest();
        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('job_show', array('token' => $entity->getToken())));
        }

        return array(
            'entity'    => $entity,
            'edit_form' => $editForm->createView(),
            'fields'    => $jobType->getFields(),
            'helps'     => $jobType->getHelps()
        );
    }

    /**
     * Deletes a Job entity.
     *
     * @Route("/delete", name="job_delete")
     * @Method("post")
     */
    public function deleteAction()
    {
        $request = $this->getRequest();
        $post    = $request->request->get('form');
        $token   = $post['token'];

        $form = $this->createDeleteForm($token);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('Jobeet2Bundle:Job')->findOneByToken($token);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Job entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('home'));
    }

    /**
     * Form that can be used to delete the current Job entity.
     *
     * @param  String $token
     * @return FormBuilder
     */
    private function createDeleteForm($token)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $entity = $em->getRepository('Jobeet2Bundle:Job')->findOneByToken($token);

        return $this->createFormBuilder(array('token' => $entity->getToken()))
            ->add('token', 'hidden')
            ->getForm()
        ;
    }

    /**
     * Publish a Job entity.
     *
     * @Route("/{token}/publish", name="job_publish")
     * @Method("get")
     */
    public function publishAction($token)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $entity = $em->getRepository('Jobeet2Bundle:Job')->findOneByToken($token);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Job entity.');
        }

        $entity->publish();
        $em->persist($entity);
        $em->flush();

        $this->getRequest()->getSession()->setFlash('notice', sprintf('Your job is now online for %s days.', $this->getActiveDays()));

        return $this->redirect($this->generateUrl('job_show_user', $entity->getShowRouteParameters()));
    }

    /**
     * Shortcut.
     *
     * @return integer
     */
    protected function getActiveDays()
    {
        return $this->container->getParameter('jobeet2.active_days');
    }
}